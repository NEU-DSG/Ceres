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

    protected function preSetDataToRender(array $dataToRender): array {
        return $dataToRender; //do nothing, let other classes implement this as needed
    } 

    protected function postSetDataToRender(): void {
        //do nothing, let other classes implement this as needed
    }

    public function getDataToRender(): array {
        return $this->dataToRender;
    }

    public function preSetJsonToInject(string $jsonToInject): string {
        return $jsonToInject; //do nothing, let other classes implement this as needed
    }

    public function postSetJsonToInject(): void {
        //do nothing, let other classes implement this as needed
    }

    public function getJsonToInject(): string {
        return $this->jsonToInject;
    }

    protected function preSetSourceData($data) {
        return $data; //do nothing, let other classes implement this as needed
    }

    protected function postSetSourceData(): void {
        //do nothing, let other classes implement this as needed
    }

    public function setSourceData($data) {
        $data = $this->preSetSourceData($data);
        $this->sourceData = $data;
        $this->postSetSourceData();
    }

    public function setOptionValue(string $optionName, string $optionValue) {
        $this->extractorOptions[$optionName] = $optionValue;
    }

}


