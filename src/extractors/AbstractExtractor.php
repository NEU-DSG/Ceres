<?php

namespace Ceres\Extractor;

abstract class AbstractExtractor {
    
    protected array $extractorOptions = [];
    protected array $dataToRender = [];
    protected string $jsonToInject = '';


    /**
     * extract
     * 
     * Extracts the data needed from the source and puts it into $dataToRender
     * Requires data from sourceData to be ready to go in props
     * @return void
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

    protected function setDataToRender(array $dataToRender): void {
        $dataToRender = $this->preSetDataToRender($dataToRender);
        $this->dataToRender = $dataToRender;
        $this->postSetDataToRender();
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

    public function setJsonToInject(string $jsonToInject): void {
        $jsonToInject = $this->preSetJsonToInject($jsonToInject);
        $this->jsonToInject = $jsonToInject;
        $this->postSetJsonToInject();
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


    /**
     * mapRowLabels
     * 
     * In Extractors instead of Renderers bc it's massaging for R's, so R's can be dumb
     * 
     * Mostly only relevant to Table Renderers, but maybe broader?
     * 
     * Take a row of $this->dataToRender to render and map the values onto a supplied array like
     * [
     *     [<oldLabel => <newLabel>] ,
     *     [<oldLabel => <newLabel>] ,
     * ]
     * @todo likely from an ExtractorOption 2023-04-06 16:56:34
     *
     * @todo put in postSetDataToRender hook? dunno if it should be a standard from AbstractExtractor
     * 
     * @param array $rowData
     * @param array $labelMapping
     * @return array
     */
    protected function mapRowLabels(array $rowData, array $labelMapping): array {
        $newRowData = [];
        foreach($rowData as $data) {
            if (array_key_exists($data, $labelMapping)) {
                $newRowData[] = $labelMapping[$data];
            }
        }
        return $newRowData;
    }
}


