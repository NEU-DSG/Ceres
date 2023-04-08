<?php

namespace Ceres\Extractor;

abstract class AbstractExtractor {
    
    protected array $extractorOptions = array();
    protected array $dataToRender = [];
    protected string $jsonToInject = '';


    /**
     * extract
     * 
     * Extracts the data needed from the source and puts it into
     * $dataToRender
     * 
     */
    abstract public function extract();

    protected array $sourceData = array();

    public function __construct() {
        
    }

    public function getDataToRender(): array {
        return $this->dataToRender;
    }

    public function getJsonToInject(): string {
        return $this->jsonToInject;
    }

    public function setSourceData($data) {
        $this->sourceData = $data;
    }

    public function setOptionValue(string $optionName, string $optionValue) {
        $this->extractorOptions[$optionName] = $optionValue;
    }

}


