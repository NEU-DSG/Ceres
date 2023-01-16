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




    public function extract() {
        $cleanedData = array();


        $this->dataToRender = $cleanedData;
    }

    public function getDataToRender() {
        return $this->dataToRender;
    }
}


