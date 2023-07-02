<?php
namespace Ceres\Documentation;
 
use Ceres\Util\DataUtilities as DataUtil;

require_once('/var/www/html/Ceres/config/ceresSetup.php');

$allVpData = DataUtil::getWpOption('ceres_view_packages');
DataUtil::rebuildAllWpOptions();




echo 'ok';


