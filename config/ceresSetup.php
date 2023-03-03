<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
if (empty(CERES_ROOT_DIR)) {
    define('CERES_ROOT_DIR', dirname(__DIR__, 1)); 
}

$files = glob(CERES_ROOT_DIR . '/src/*/*.php');
$missingFiles = [];
//print_r($files);
foreach($files as $file) {
    try {
        require_once($file);
    } catch (Exception $e) {
        $missingFiles[] = $file;
    }
}



require_once(CERES_ROOT_DIR . '/data/ceres_settings.php');
require_once(CERES_ROOT_DIR . '/devscraps/ceres_utility_functions.php');
