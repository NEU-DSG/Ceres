<?php

namespace Ceres\Extractor;

use Ceres\Data;
use Ceres\Util\DataUtilities as DataUtil;
use Ceres\Extractor\AbstractExtractor;


class CeresOptionsToTable extends AbstractExtractor {

    public function extract() {
        $this->preExtract();
        $dataToRender = $this->optionsToTableArray();

        //$dataToRender = [];//do the things to go from $this->sourceData to $this->dataToRender
        $this->setDataToRender($dataToRender);
    }

    protected function preSetSourceData($sourceData)
    {
        return Data\getAllOptions();
    }

    protected function optionsToTableArray() {
        $tableArray = [];
        //$headings = ['OptionId', 'Label', 'Shortcode', 'Description', 'Defaults', 'Type', 'Access' ];
        $headings = ['OptionId', 'Label', 'Description', 'Access', 'Type', 'Defaults', 'Shortcode', 'Applies To' ];
        $tableArray[] = $headings;
    
        foreach($this->sourceData as $optionName=>$props) {
            $tableArray[] = $this->optionToRow($optionName, $props);
        }
        return $tableArray;
    }
    
    
    protected function optionToRow($optionName, $props) {
        $rowArray = [$optionName];
        $propsToShow = ['label', 'shortcode', 'desc', 'type', 'defaults', 'access'];
        foreach($props as $prop=>$value) {
            if (in_array($prop, $propsToShow)) {
                switch ($prop) {
    
                    case 'type':
                        switch ($value) {
                            case 'bool':
                                $newValue = "true/false";
                            break;
    
                            case 'varchar':
                                $newValue = "short text";
                            break;
    
                            case 'text':
                                $newValue = "long text";
                            break;
    
                            case 'enum':
                                $newValue = DataUtil::allEnumValuesForOption($optionName);
                                $newValue = "enums broken until I fix nested data arrays";                         
                                //$value = "A list of settings (to be filled in)";
                            break;
    
                            case 'FilePath':
                                $newValue = "The id of a file with the relevant data";
                            break;
    
                        }
    
                    break;

                    case 'access':
                        $newValue = [];
                        $newValue['type'] = 'ul';
                        $newValue['data'] = $value;

                        
                    break;
    
                    case 'defaults':
                        $newValue = [];
                        $newValue['type'] = 'keyValue';
                        $newValue['data'] = DataUtil::allDefaultsForOption($optionName);
                    break;
    
                    default:
                        $newValue = $value;
    
                    break;
    
                }
                $rowArray[] = $newValue;
            }
            
        }
    
        return $rowArray;
    }
    

}
