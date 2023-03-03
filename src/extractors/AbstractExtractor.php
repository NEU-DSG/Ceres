<?php

namespace Ceres\Extractor;

abstract class AbstractExtractor {
    
    protected array $extractorOptions = array();
    protected $sourceData;
    protected array $dataToRender = [];

    public function __construct() {
        
    }

    abstract public function extract();

    /**
     * getDataToRender
     * 
     * Returns exactly what the fetcher gave it, in case the result needs no processing
     *
     * @param boolean $bounceSource
     * @return mixed
     */
    protected $sourceData = array();


    public function __construct() {
        
    }

/**
 * extract
 * 
 * Extracts the data needed from the source and puts it into
 * $dataToRender
 * 
 */

    abstract function extract();

    public function getDataToRender() {
        return $this->dataToRender;
    }

    public function setSourceData($data) {
        $this->sourceData = $data;
    }

    public function setOptionValue(string $optionName, string $optionValue) {
        $this->options[$optionName] = $optionValue;
    }
}


