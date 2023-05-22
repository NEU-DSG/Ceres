<?php

namespace Ceres\Extractor;

abstract class AbstractExtractor {
    
    protected array $extractorOptions = [];
    protected array $renderArray = [];
    protected string $jsonToInject = '';


    /**
     * extract
     * 
     * Extracts the data needed from the source and puts it into $renderArray
     * Requires data from sourceData to be ready to go in props
     * @return void
     */
    abstract public function extract();

    protected array $sourceData = array();

    public function __construct() {
        
    }


    public function getExtractorOptions(): array {
        return $this->extractorOptions;
    }
    //@todo another one to abstract across F/E/Rs, probably as a Trait
    public function valueForExtractorOption(string $optionName) {
        if (isset($this->extractorOptions[$optionName])) {
            return $this->extractorOptions[$optionName];
        }
        return null;
    }


    //@todo another one to abstract across F/E/Rs, probably as a Trait
    public function setExtractorOptionValue(string $optionName, string $optionValue, bool $asCurrentValue = false) {
        if ($asCurrentValue) {
            $this->extractorOptions[$optionName]['currentValue'] = $optionValue;    
        } else {
            $this->extractorOptions[$optionName] = $optionValue;
        }
    }

    protected function preSetDataToRender(array $renderArray): array {
// echo"<h3>preSetDataToRender: AbsExt</h3>";
        return $renderArray; //do nothing, let other classes implement this as needed
    } 

    protected function postSetDataToRender(): void {
// echo"<h3>postSetDataToRender: AbsExt</h3>";
        //do nothing, let other classes implement this as needed
    }

    protected function setDataToRender(array $renderArray): void {
        $renderArray = $this->preSetDataToRender($renderArray);
        $this->renderArray = $renderArray;
        $this->postSetDataToRender();
    }


    public function getDataToRender(): array {
        return $this->renderArray;
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
 //echo"<h3>preSetSourceData: AbsExt</h3>";
        return $data; //do nothing, let other classes implement this as needed
    }

    protected function postSetSourceData(): void {
 //echo"<h3>preSetSourceData: AbsExt</h3>";

        //do nothing, let other classes implement this as needed
    }

    public function setSourceData($data) {
        $data = $this->preSetSourceData($data);
        $this->sourceData = $data;
        $this->postSetSourceData();
    }

    public function setSourceDataFromFile(string $filePath): void {
        $data = json_decode(file_get_contents($filePath), true);
        $this->setSourceData($data);
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
     * Take a row of $this->renderArray to render and map the values onto a supplied array like
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


