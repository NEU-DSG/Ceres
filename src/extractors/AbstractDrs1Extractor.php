<?php

namespace Ceres\Extractor;

require_once(CERES_ROOT_DIR . '/src/extractors/AbstractExtractor.php');

use Ceres\Extractor\AbstractExtractor as AbstractExtractor;

abstract class AbstractDrs1ItemExtractor extends AbstractExtractor {

    /**
     * $modsDataArray
     * 
     * Array of MODS data from the JSON response
     * 
     * @var array
     */
    
    protected $modsDataArray = [];
    
    /**
     * contentObjectsArray
     *
     * @var array
     */
    protected $contentObjectsArray = [];


    /**
     * extractModsData
     * 
     * Takes the MODS portion of the source data and turns it into an array for the renderer
     * 
     * @return void
     */

    protected function extractModsData(): void {
        $this->modsDataArray = $this->sourceData['mods'];
    }

    /**
     * extractContentObjects
     * 
     * Separate the content objects and flip them so it's easier to look up by type
     *
     * @return void
     */
    protected function extractContentObjects(): void {
        $sourceContentObjectsArray = $this->sourceData['content_objects'];
        $ceresContentObjectsArray = $sourceContentObjectsArray;
        $this->contentObjectsArray = array_flip($ceresContentObjectsArray);
    }

    



}