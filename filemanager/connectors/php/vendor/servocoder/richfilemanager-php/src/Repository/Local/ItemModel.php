<?php

namespace RFM\Repository\Local;

use RFM\Facade\Log;
use RFM\Factory\Factory;
use RFM\Repository\BaseStorage;
use RFM\Repository\BaseItemModel;
use RFM\Repository\ItemData;
use RFM\Repository\ItemModelInterface;
use function RFM\app;

class ItemModel extends BaseItemModel implements ItemModelInterface
{
    /**
     * @var Storage
     */
    protected $storage;

    /**
     * Absolute path for item model, based on relative path.
     *
     * @var string
     */
    protected $pathAbsolute;

    /**
     * Relative path for item model, the only value required to create item model.
     *
     * @var string
     */
    protected $pathRelative;

    /**
     * Whether item exists in file system on any other storage.
     * Defined and cached upon creating new item instance.
     *
     * @var bool
     */
    protected $isExists;

    /**
     * Whether item is folder.
     * Defined and cached upon creating new item instance.
     *
     * @var bool
     */
    protected $isDir;

    /**
     * Define whether item is thumbnail file or thumbnails folder.
     * Set up in constructor upon initialization and can't be modified.
     *
     * @var bool
     */
    protected $isThumbnail;

    /**
     * Calculated item data stored into the ItemData object instance.
     *
     * @var ItemData
     */
    protected $itemData;

    /**
     * Model for parent folder of the current item.
     * Return NULL if there is no parent folder (user storage root folder).
     *
     * @var null|self
     */
    protected $parent;

    /**
     * Model for thumbnail file or folder of the current item.
     *
     * @var null|self
     */
    protected $thumbnail;

    /**
     * ItemModel constructor.
     *
     * @param string $path
     * @param bool $isThumbnail
     */
    public function __construct($path, $isThumbnail = false)
    {
        $this->setStorage(BaseStorage::STORAGE_LOCAL_NAME);
        $this->isThumbnail = $isThumbnail;
        $this->resetStats($path);
    }

    /**
     * Update model stats from original storage item.
     *
     * @param string|null $path
     * @return $this
     */
    public function resetStats($path = null)
    {
        if ($path !== null) {
            $this->setRelativePath($path);
            $this->setAbsolutePath();
            $this->parent = null;
            $this->thumbnail = null;
        }

        // clear file status cache
        clearstatcache(true, $this->pathAbsolute);

        $this->setIsExists();
        $this->setIsDirectory();
        $this->itemData = null;

        return $this;
    }

    /**
     * Return relative path to item.
     *
     * @return string
     */
    public function getRelativePath()
    {
        return $this->pathRelative;
    }

    /**
     * Set relative item path.
     *
     * @param string $path
     */
    protected function setRelativePath($path)
    {
        $this->pathRelative = $path;
    }

    /**
     * Return absolute path to item.
     *
     * @return string
     */
    public function getAbsolutePath()
    {
        return $this->pathAbsolute;
    }

    /**
     * Set absolute item path. Based on relative item path.
     */
    protected function setAbsolutePath()
    {
        $this->pathAbsolute = $this->storage->cleanPath($this->storage->getRoot() . '/' . $this->pathRelative);
    }

    /**
     * Define whether item is file or folder.
     * In case item doesn't exist at a storage we check the trailing slash.
     * That is why it's important to add slashes to the end of folders path.
     */
    public function setIsDirectory()
    {
        if ($this->isExists) {
            $this->isDir = is_dir($this->pathAbsolute);
        } else {
            $this->isDir = substr($this->pathRelative, -1, 1) === '/';
        }
    }

    /**
     * Validate whether item is file or folder.
     *
     * @return bool
     */
    public function isDirectory()
    {
        return $this->isDir;
    }

    /**
     * Define if file or folder exists.
     */
    protected function setIsExists()
    {
        $this->isExists = file_exists($this->pathAbsolute);
    }

    /**
     * Validate whether file or folder exists.
     *
     * @return bool
     */
    public function isExists()
    {
        return $this->isExists;
    }

    /**
     * Build item data class instance.
     */
    public function compileData()
    {
        $data = new ItemData();
        $data->pathRelative = $this->pathRelative;
        $data->pathAbsolute = $this->pathAbsolute;
        $data->pathDynamic = $this->getDynamicPath();
        $data->isDirectory = $this->isDir;
        $data->isExists = $this->isExists;
        $data->isImage = $this->isImageFile();
        $data->isRoot = $this->isRoot();
        $data->timeModified = filemtime($this->pathAbsolute);
        $data->timeCreated = $data->timeModified;

        // check file permissions
        $data->isReadable = $this->isExists ? $this->hasReadPermission() : false;
        $data->isWritable = $this->isExists ? $this->hasWritePermission() : false;

        // fetch file info
        $pathInfo = pathinfo($this->pathAbsolute);
        $data->basename = $pathInfo['basename'];

        // get file size
        if (!$this->isDir && $data->isReadable) {
            $data->size = $this->storage->getFileSize($this->pathAbsolute);
        }

        // handle image data
        if ($data->isImage) {
            $data->imageData['isThumbnail'] = $this->isThumbnail;
            $data->imageData['pathOriginal'] = $this->getOriginalPath();
            $data->imageData['pathThumbnail'] = $this->getThumbnailPath();

            if ($data->isReadable && $data->size > 0) {
                list($width, $height, $type, $attr) = getimagesize($this->pathAbsolute);
            } else {
                list($width, $height) = [0, 0];
            }

            $data->imageData['width'] = $width;
            $data->imageData['height'] = $height;
        }

        $this->itemData = $data;
    }

    /**
     * Return item data class instance.
     *
     * @return ItemData
     */
    public function getData()
    {
        if (is_null($this->itemData)) {
            $this->compileData();
        }

        return $this->itemData;
    }

    /**
     * Return model for parent folder on the current item.
     * Create and cache if not existing yet.
     *
     * @return null|self
     */
    public function closest()
    {
        if (is_null($this->parent)) {
            // dirname() trims trailing slash
            $path = dirname($this->pathRelative) . '/';
            // root folder returned as backslash for Windows
            $path = $this->storage->cleanPath($path);

            // can't get parent
            if ($this->isRoot()) {
                return null;
            }
            $this->parent = new self($path, $this->isThumbnail);
        }

        return $this->parent;
    }

    /**
     * Return model for thumbnail of the current item.
     * Create and cache if not existing yet.
     *
     * @return null|self
     */
    public function thumbnail()
    {
        if (is_null($this->thumbnail)) {
            $this->thumbnail = (new Factory())->createThumbnailModel($this);
        }

        return $this->thumbnail;
    }

    /**
     * Return path without storage root path, prepended with dynamic folder.
     * Based on relative item path.
     *
     * @return mixed
     */
    public function getDynamicPath()
    {
        $path = $this->storage->getDynamicRoot() . '/' . $this->pathRelative;

        return $this->storage->cleanPath($path);
    }

    /**
     * Return thumbnail relative path for item model.
     * Work for both files and dirs paths.
     *
     * @return string
     */
    public function getThumbnailPath()
    {
        if ($this->isThumbnail) {
            return $this->pathRelative;
        }

        $path = '/' . $this->storage->config('images.thumbnail.dir') . '/' . $this->pathRelative;

        return $this->storage->cleanPath($path);
    }

    /**
     * Return original relative path for thumbnail model.
     * Work for both files and dirs paths.
     *
     * @return string
     */
    public function getOriginalPath()
    {
        $path = $this->pathRelative;

        if (!$this->isThumbnail) {
            return $path;
        }

        $thumbRoot = '/' . trim($this->storage->config('images.thumbnail.dir'), '/');
        if (strpos($path, $thumbRoot) === 0) {
            // remove thumbnails root folder
            $path = substr($path, strlen($thumbRoot));
        }

        return $path;
    }

    /**
     * Check whether the item is root folder.
     *
     * @return bool
     */
    public function isRoot()
    {
        $rootPath = $this->storage->getRoot();

        // root for thumbnails is defined in config file
        if ($this->isThumbnail) {
            $rootPath = $this->storage->cleanPath($rootPath . '/' . $this->storage->config('images.thumbnail.dir'));
        }

        return rtrim($rootPath, '/') === rtrim($this->pathAbsolute, '/');
    }

    /**
     * Check whether file is image, based on its mime type.
     *
     * @return string
     */
    public function isImageFile()
    {
        $mime = mime_content_type($this->pathAbsolute);

        return $this->storage->isImageMimeType($mime);
    }

    /**
     * Retrieve mime type of model item.
     *
     * @return string
     */
    public function getMimeType()
    {
        return mime_content_type($this->pathAbsolute);
    }

    /**
     * Remove current file or folder.
     *
     * @return bool
     */
    public function remove()
    {
        return $this->storage->unlinkRecursive($this);
    }

    /**
     * Create thumbnail from the original image.
     *
     * @return void
     */
    public function createThumbnail()
    {
        // check is readable current item
        if (!$this->hasReadPermission()) {
            return;
        }

        // check that thumbnail creation is allowed in config file
        if (!$this->storage->config('images.thumbnail.enabled')) {
            return;
        }

        $modelThumb = $this->thumbnail();
        $modelTarget = $modelThumb->closest();
        $modelExistent = $modelTarget;

        // look for closest existent folder
        while (!$modelExistent->isRoot() && !$modelExistent->isExists()) {
            $modelExistent = $modelExistent->closest();
        }

        // check that the closest existent folder is writable
        if ($modelExistent->isExists() && !$modelExistent->hasWritePermission()) {
            return;
        }

        Log::info('generating thumbnail "' . $modelThumb->getAbsolutePath() . '"');

        // create folder if it does not exist
        if (!$modelThumb->closest()->isExists()) {
            $this->storage->createFolder($modelTarget);
        }

        $this->storage->initUploader($this->closest())
            ->create_thumbnail_image(basename($this->pathAbsolute));
    }

    /**
     * Check the extensions blacklist for item.
     *
     * @return bool
     */
    public function isAllowedExtension()
    {
        // check the extension (for files):
        $extension = pathinfo($this->pathRelative, PATHINFO_EXTENSION);
        $extensionRestrictions = $this->storage->config('security.extensions.restrictions');

        if ($this->storage->config('security.extensions.ignoreCase')) {
            $extension = strtolower($extension);
            $extensionRestrictions = array_map('strtolower', $extensionRestrictions);
        }

        if ($this->storage->config('security.extensions.policy') === 'ALLOW_LIST') {
            if (!in_array($extension, $extensionRestrictions)) {
                // Not in the allowed list, so it's restricted.
                return false;
            }
        } else if ($this->storage->config('security.extensions.policy') === 'DISALLOW_LIST') {
            if (in_array($extension, $extensionRestrictions)) {
                // It's in the disallowed list, so it's restricted.
                return false;
            }
        } else {
            // Invalid config option for 'policy'. Deny everything for safety.
            return false;
        }

        // Nothing restricted this path, so it is allowed.
        return true;
    }

    /**
     * Check the patterns blacklist for path.
     *
     * @return bool
     */
    public function isAllowedPattern()
    {
        // check the relative path against the glob patterns:
        $pathRelative = $this->getOriginalPath();
        $patternRestrictions = $this->storage->config('security.patterns.restrictions');

        if ($this->storage->config('security.patterns.ignoreCase')) {
            $pathRelative = strtolower($pathRelative);
            $patternRestrictions = array_map('strtolower', $patternRestrictions);
        }

        // (check for a match before applying the restriction logic)
        $matchFound = false;
        foreach ($patternRestrictions as $pattern) {
            if (fnmatch($pattern, $pathRelative)) {
                $matchFound = true;
                break;  // Done.
            }
        }

        if ($this->storage->config('security.patterns.policy') === 'ALLOW_LIST') {
            if (!$matchFound) {
                // relative path did not match the allowed pattern list, so it's restricted:
                return false;
            }
        } else if ($this->storage->config('security.patterns.policy') === 'DISALLOW_LIST') {
            if ($matchFound) {
                // relative path matched the disallowed pattern list, so it's restricted:
                return false;
            }
        } else {
            // Invalid config option for 'policy'. Deny everything for safety.
            return false;
        }

        // Nothing is restricting access to this item, so it is allowed.
        return true;
    }

    /**
     * Check the global blacklists for this file path.
     *
     * @return bool
     */
    public function isUnrestricted()
    {
        $valid = true;

        if (!$this->isDir) {
            $valid = $valid && $this->isAllowedExtension();
        }

        return $valid && $this->isAllowedPattern();
    }

    /**
     * Verify if item has read permission.
     *
     * @return bool
     */
    public function hasReadPermission()
    {
        // Check system permission (O.S./filesystem/NAS)
        if ($this->storage->hasSystemReadPermission($this->pathAbsolute) === false) {
            return false;
        }

        // Check the user's Auth API callback:
        if (function_exists('fm_has_read_permission') && fm_has_read_permission($this->pathAbsolute) === false) {
            return false;
        }

        // Nothing is restricting access to this item, so it is readable
        return true;
    }

    /**
     * Verify if item has write permission.
     *
     * @return bool
     */
    public function hasWritePermission()
    {
        // Check the global `readOnly` config flag:
        if ($this->storage->config('security.readOnly') !== false) {
            return false;
        }

        // Check system permission (O.S./filesystem/NAS)
        if ($this->storage->hasSystemWritePermission($this->pathAbsolute) === false) {
            return false;
        }

        // Check the user's Auth API callback:
        if (function_exists('fm_has_write_permission') && fm_has_write_permission($this->pathAbsolute) === false) {
            return false;
        }

        // Nothing is restricting access to this item, so it is writable
        return true;
    }

    /**
     * Check whether item path is valid by comparing paths.
     *
     * @return bool
     */
    public function isValidPath()
    {
        $rootPath = $this->storage->getRoot();
        $rpSubstr = substr(realpath($this->pathAbsolute) . DS, 0, strlen(realpath($rootPath))) . DS;
        $rpFiles = realpath($rootPath) . DS;

        // handle better symlinks & network path
        $pattern = ['/\\\\+/', '/\/+/'];
        $replacement = ['\\\\', '/'];
        $rpSubstr = preg_replace($pattern, $replacement, $rpSubstr);
        $rpFiles = preg_replace($pattern, $replacement, $rpFiles);
        $match = ($rpSubstr === $rpFiles);

        if (!$match) {
            Log::info('Invalid path "' . $this->pathAbsolute . '"');
            Log::info('real path: "' . $rpSubstr . '"');
            Log::info('path to files: "' . $rpFiles . '"');
        }
        return $match;
    }

    /**
     * Check that item exists and path is valid.
     *
     * @return void
     */
    public function checkPath()
    {
        if (!$this->isExists || !$this->isValidPath()) {
            $langKey = $this->isDir ? 'DIRECTORY_NOT_EXIST' : 'FILE_DOES_NOT_EXIST';
            app()->error($langKey, [$this->pathRelative]);
        }
    }

    /**
     * Check that item has read permission.
     *
     * @return void
     */
    public function checkRestrictions()
    {
        if (!$this->isDir) {
            if ($this->isAllowedExtension() === false) {
                app()->error('FORBIDDEN_NAME', [$this->pathRelative]);
            }
        }

        if ($this->isAllowedPattern() === false) {
            app()->error('INVALID_FILE_TYPE');
        }

        // Nothing is restricting access to this file or dir, so it is readable.
        return;
    }

    /**
     * Check that item has read permission.
     *
     * @return void -- exits with error response if the permission is not allowed
     */
    public function checkReadPermission()
    {
        // Check system permission (O.S./filesystem/NAS)
        if ($this->storage->hasSystemReadPermission($this->pathAbsolute) === false) {
            app()->error('NOT_ALLOWED_SYSTEM');
        }

        // Check the user's Auth API callback:
        if (function_exists('fm_has_read_permission') && fm_has_read_permission($this->pathAbsolute) === false) {
            app()->error('NOT_ALLOWED');
        }

        // Nothing is restricting access to this file or dir, so it is readable
        return;
    }

    /**
     * Check that item can be written to.
     *
     * @return void -- exits with error response if the permission is not allowed
     */
    public function checkWritePermission()
    {
        // Check the global `readOnly` config flag:
        if ($this->storage->config('security.readOnly') !== false) {
            app()->error('NOT_ALLOWED');
        }

        // Check system permission (O.S./filesystem/NAS)
        if ($this->storage->hasSystemWritePermission($this->pathAbsolute) === false) {
            app()->error('NOT_ALLOWED_SYSTEM');
        }

        // Check the user's Auth API callback:
        if (function_exists('fm_has_write_permission') && fm_has_write_permission($this->pathAbsolute) === false) {
            app()->error('NOT_ALLOWED');
        }

        // Nothing is restricting access to this file, so it is writable
        return;
    }
}