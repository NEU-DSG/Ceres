<?php
namespace Ceres\Documentation;
 
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use Ceres\Renderer\Details;
use Ceres\Renderer\Card;
use Ceres\Util\DataUtilities as DataUtil;
use Exception;

require_once('/var/www/html/Ceres/config/ceresSetup.php');

$allVpData = DataUtil::getWpOption('ceres_view_packages');
DataUtil::rebuildAllWpOptions();


$options = DataUtil::getWpOption('ceres_all_options');

$testOption1 = $options['extractorReorderMappingFilePath'];
$testOption2 = $options['extractorRemoveVarsFilePath'];

$dlRenderArray = [];

//$dlRenderArray[] = extractOptionToDlRenderArray($testOption1);
//$dlRenderArray[] = extractOptionToDlRenderArray($testOption2);


$detailsCardRenderArray = extractOptionToDetailsCardRenderArray($testOption1);

function extractArrayToListRenderArray($array) {
    $listRenderArray = ['type' => 'list',
                        'data' => $array,
    ];
    return $listRenderArray;
}

function extractOptionToDlRenderArray(array $option, ?string $subtype = null): array {
    $dlRenderArray['type'] = 'dl';
    if (! is_null($subtype)) {
        $dlRenderArray['subtype'] = $subtype;
    }
    

    $optionDetailsMap = [
        //'Description' => $option['desc'],
        //'Type' => $option['type'],
        'Defaults' => $option['defaults'],
        //'Access' => $option['access'],
    ];

    foreach($optionDetailsMap as $optionSettingLabel => $value) {
        // The extra array for the $detail and $value is
        // not needed here. For single string values, the 
        // simple string will suffice. But, for multiple dt's
        // or dd's, the array is used, so it's an example
        // of the complete usage

        $valueType = gettype($value);
        switch ($valueType) {
            case 'string':
                $value = extractStringToTextRenderArray($value);
                break;
            case 'array':
                $value = extractArrayToListRenderArray($value);
                break;

        }

        switch($optionSettingLabel) {
            case 'Access':
                if (is_string($optionSettingLabel)) {
                    $optionSettingLabel = extractStringToTextRenderArray($optionSettingLabel);
                }

                $dlRenderArray['data'][] = [
                    'dts' => [
                                $optionSettingLabel,
                             ],
                    'dds' => [ $value ],
                ];
                break;

            case 'Defaults':
                $value = DataUtil::defaultsForOption('extractorValueLabelMappingFilePath');
                $innerDlRenderArray = extractDefaultOptionValuesToDlRenderArray($value);
                $dlRenderArray['data'] = [];
                $dtDdGroup = 
                    ['dts' => ['Defaults'],
                     'dds' => $innerDlRenderArray
                    ];
                
                
                $dlRenderArray['data'][] = $dtDdGroup;
                
                // $dlRenderArray['data'][] = [
                //     ['dts' => ['Defaults'],
                //      'dds' => []
                //     ]
                // ];
                
                //$dlRenderArray['data'][0]['dds'][] = extractDefaultOptionValuesToDlRenderArray($value);
                break;

            default:
                if (is_string($optionSettingLabel)) {
                    $optionSettingLabel = extractStringToTextRenderArray($optionSettingLabel);
                }
                $dlRenderArray['data'][] = [
                    'dts' => [$optionSettingLabel],
                    'dds' => [$value]
                ];
        }
    }
    return $dlRenderArray;
}

function extractDefaultOptionValuesToDlRenderArray(array $defaultValues) {
    $innerDlRenderArray = [
        'type' => 'dl',
        //'subtype' => 'keyValue'
    ];

    // making assumption of 1 - 1 dt/dd relationship
    // but dd could be an array that represents
    // the details as a list
    foreach ($defaultValues as $dt => $dds) {
        $dtDdGroup = [
            'dts' => [$dt],
        ];
        if (is_string($dds)) {
            $dtDdGroup['dds'] = [$dds];
        } else {
            $ddsArray = [];
            foreach ($dds as $newDd) {
                $ddsArray[] = $newDd;
            }
            $dtDdGroup['dds'] = $ddsArray;
        }
        $innerDlRenderArray['data'] = [$dtDdGroup];
        //print_r($innerDlRenderArray);
        // //working as expected
        //die();
        return $innerDlRenderArray;
    }

}

function extractStringToTextRenderArray(string $text, ?string $htmlElement = null) {
    $textRenderArray = ['type' => 'text',
                        'data' => $text,
                        ];
    if (! is_null($htmlElement)) {
        $textRenderArray['subtype'] = $htmlElement;
    }
    return $textRenderArray;
}



function extractOptionToDetailsCardRenderArray($option) {
    $detailsCardRenderArray = ['type' => 'card',
                               'subtype' => 'details'
    ];
    $detailsCardRenderArray['data'] = [
        'main' => extractStringToTextRenderArray($option['label']),
        'secondary' => extractOptionToDlRenderArray($option)
    ];
    //print_r($detailsCardRenderArray);
    // good to here
    // die();
    return $detailsCardRenderArray;
}
$detailsRenderer = new Details;
// print_r($detailsCardRenderArray);
$detailsRenderer->setRenderArrayFromArray($detailsCardRenderArray);

$cardRenderer = new Card;
$cardRenderer->setRenderArrayFromArray($detailsCardRenderArray);

//$detailsRenderer->build(); RENDER CALLS BUILD()
echo $detailsRenderer->render();

//echo $cardRenderer->render();




