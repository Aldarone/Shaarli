<?php
$vendorDir = realpath(dirname(__FILE__));
require_once "$vendorDir/PhpFig/Psr4AutoloaderClass.php";

$loader = new \PhpFig\Psr4AutoloaderClass;
$loader->addNameSpace('Shaarli', "$vendorDir/OoShaarli/src");
$loader->addNameSpace('Rain', "$vendorDir/Rain");
$loader->register();
