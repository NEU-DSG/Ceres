<?php

namespace Ceres\Extractor;

abstract class AbstractExtractor {


    // includeMediaThumbnail
    // includeItemLink
    // includeMediaLink
    
    protected array $options = array();
    protected array $dataToRender = [];

    /**
     * The data from a Fetcher for start with
     *
     * @var array
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


