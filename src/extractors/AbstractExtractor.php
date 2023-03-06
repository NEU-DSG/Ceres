<?php

namespace Ceres\Extractor;

abstract class AbstractExtractor {
    
    protected array $extractorOptions = array();
    protected array $dataToRender = [];

    abstract public function extract();

    /**
     * getDataToRender
     * 
     * Returns exactly what the fetcher gave it, in case the result needs no processing
     *
     * @param boolean $bounceSource
     * @return mixed
     */
    protected array $sourceData = array();

    public function __construct() {
        
    }

/**
 * extract
 * 
 * Extracts the data needed from the source and puts it into
 * $dataToRender
 * 
 */

    public function getDataToRender() {
        return $this->dataToRender;
    }

    public function setSourceData($data) {
        $this->sourceData = $data;
    }

    public function setOptionValue(string $optionName, string $optionValue) {
        $this->extractorOptions[$optionName] = $optionValue;
    }

}


