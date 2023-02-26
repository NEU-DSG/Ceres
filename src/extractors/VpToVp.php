<?php

namespace Ceres\Extractor;

use Ceres\Extractor\AbstractExtractor;
use Ceres\Util\DataUtilities as DataUtil;
use Ceres\Exception\DataException;

class VpToVp extends AbstractExtractor {

    public function __construct() {
        parent::__construct();
        $this->sourceData = DataUtil::getWpOption('ceres_view_packages');

    }

    public function extract() {
        $dataToRender = [];
        if (isset($this->options['vpNameId'])) {
            $vpArray = $this->sourceData[$this->options['vpNameId']];
        } else {
            throw new DataException("Invalid vpNameId option");
        }
        
        foreach ($vpArray as $property => $value) {
            if (is_array($value)) {
                $value = print_r($value, true);
            }
            if (is_null($value)) {
                $value = 'null';
            }
            $dataToRender[] = ['key' => $property,
                               'value' => $value
                              ];

        }
        $this->dataToRender = $dataToRender;
    }



}