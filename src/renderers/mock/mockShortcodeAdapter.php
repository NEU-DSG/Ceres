<?php
namespace Ceres\Renderer\Mock;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

define('CERES_ROOT_DIR', dirname(__DIR__, 3));
// echo CERES_ROOT_DIR;
// die();
require_once(CERES_ROOT_DIR . '/src/util/DataUtilities.php');
require_once('../AbstractRenderer.php');
require_once('../Html.php');
require_once('DrstkMap.php');
require_once('DrstkMedia.php');
require_once('DrstkSingle.php');
require_once('DrstkSlider.php');
require_once('DrstkTile.php');
require_once('DrstkTimeline.php');

use Ceres\Renderer\Mock\DrstkTile;
use Ceres\Renderer\Mock\DrstkMap;
use Ceres\Renderer\Mock\DrstkMedia;
use Ceres\Renderer\Mock\DrstkTimeline;
use Ceres\Renderer\Mock\DrstkSingle;
use Ceres\Renderer\Mock\DrstkSlider;
use DOMDocument;

$dom = new DOMDocument();


if (isset($_GET['shortcodeType'])) {
    $shortcodeType = $_GET['shortcodeType'];
    switch ($shortcodeType) {
        case 'single':
            $dom->loadHTMLFile(CERES_ROOT_DIR . '/data/rendererTemplates/drstkSingle.html');
        break;

        case 'tile':
            $dom->loadHTMLFile(CERES_ROOT_DIR . '/data/rendererTemplates/drstkTile.html');
        break;

        case 'map':
            $dom->loadHTMLFile(CERES_ROOT_DIR . '/data/rendererTemplates/drstkMap.html');
        break;

        case 'media':
            $dom->loadHTMLFile(CERES_ROOT_DIR . '/data/rendererTemplates/drstkMedia.html');
        break;

        case 'timeline':
            $dom->loadHTMLFile(CERES_ROOT_DIR . '/data/rendererTemplates/drstkTimeline.html');
        break;

        case 'slider':
            $dom->loadHTMLFile(CERES_ROOT_DIR . '/data/rendererTemplates/drstkSlider.html');
        break;

        default:
            echo "Invalid shortcode type. Valid types are: single, tile, map, media, timeline, slider.";
            die();
    } 

} else {
    echo "Required GET param shortcodeType not provided.";
    die();
}

$containerNode = $dom->getElementById('ceres-container');
echo $dom->saveHTML($containerNode);

// Wish below worked out of the box, but no such luck. So
die(); //Bart, Die

if (isset($_GET['shortcodeType'])) {
    $shortcodeType = $_GET['shortcodeType'];
    switch ($shortcodeType) {
        case 'single':
            $rendererClass = new DrstkSingle;
        break;

        case 'tile':
            $rendererClass = new DrstkTile;
        break;

        case 'map':
            $rendererClass = new DrstkMap;
        break;

        case 'media':
            $rendererClass = new DrstkMedia;
        break;

        case 'timeline':
            $rendererClass = new DrstkTimeline;
        break;

        case 'slider':
            $rendererClass = new DrstkSlider;
        break;

        default:
            echo "Invalid shortcode type. Valid types are: single, tile, map, media, rimeline, slider.";
            die();
    } 

} else {
    echo "Required GET param shortcodeType not provided.";
    die();
}

$rendererClass->render();