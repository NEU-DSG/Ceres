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
    public function getDataToRender($bounceSource = false) {
        if ($bounceSource) {
            return json_encode($this->sourceData);
        }
        return $this->dataToRender;
    }

    public function setSourceData($sourceData):void {
        if (is_string($sourceData)) {
            $sourceData = json_decode($sourceData, true);
        }
        
        $this->sourceData = $sourceData;
    }
}


