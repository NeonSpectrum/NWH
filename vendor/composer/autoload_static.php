<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit80456bb60c05835f5176e70a2b0a5c6e
{
    public static $prefixLengthsPsr4 = array (
        's' => 
        array (
            'setasign\\Fpdi\\' => 14,
        ),
        'S' => 
        array (
            'Symfony\\Component\\Process\\' => 26,
            'Spatie\\ImageOptimizer\\' => 22,
        ),
        'P' => 
        array (
            'Psr\\SimpleCache\\' => 16,
            'Psr\\Log\\' => 8,
            'PhpOffice\\PhpSpreadsheet\\' => 25,
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'B' => 
        array (
            'Bt51\\NTP\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'setasign\\Fpdi\\' => 
        array (
            0 => __DIR__ . '/..' . '/setasign/fpdi/src',
        ),
        'Symfony\\Component\\Process\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/process',
        ),
        'Spatie\\ImageOptimizer\\' => 
        array (
            0 => __DIR__ . '/..' . '/spatie/image-optimizer/src',
        ),
        'Psr\\SimpleCache\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/simple-cache/src',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'PhpOffice\\PhpSpreadsheet\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpoffice/phpspreadsheet/src/PhpSpreadsheet',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'Bt51\\NTP\\' => 
        array (
            0 => __DIR__ . '/..' . '/bt51/ntp/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'PayPal' => 
            array (
                0 => __DIR__ . '/..' . '/paypal/rest-api-sdk-php/lib',
            ),
        ),
    );

    public static $classMap = array (
        'FPDF' => __DIR__ . '/..' . '/setasign/fpdf/fpdf.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit80456bb60c05835f5176e70a2b0a5c6e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit80456bb60c05835f5176e70a2b0a5c6e::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit80456bb60c05835f5176e70a2b0a5c6e::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit80456bb60c05835f5176e70a2b0a5c6e::$classMap;

        }, null, ClassLoader::class);
    }
}
