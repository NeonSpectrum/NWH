<?php
require "../files/autoload.php";
echo json_encode(Braintree_ClientToken::generate());
?>