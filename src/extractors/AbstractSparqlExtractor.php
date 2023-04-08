<?php

namespace Ceres\Extractor;


abstract class AbstractSparqlExtractor extends AbstractExtractor {

    // from head/vars in sparql result
    protected array $vars;
    protected array $bindings;
    
    /**
     * valueForBindingVar
     * 
     * From a binding from SPARQL, dig up the value for a var in a binding
     * 
     * So with this as a sample from a single $binding
     * {
     * "work" : {
     *   "type" : "uri",
     *   "value" : "http://www.wikidata.org/entity/Q109272120"
     * },
     * "workDescription" : {
     *   "xml:lang" : "en",
     *   "type" : "literal",
     *   "value" : "2002 mural by Marshall Dackert, Mel Georgakopoulos, and Mayor's Mural Crew"
     * },
     * 
     * valueFoBindingVar($binding, 'work') will return the URI
     *
     * @param array $binding
     * @param string $var
     * @return string
     */
    public function valueForBindingVar(array $binding, string $var):string {
        if (! isset($binding[$var])) {
            return "missing $var data";
        }
        return $binding[$var]['value'];
    }

    protected function postSetSourceData(): void {
        $this->setVars();
        $this->setBindings();
    }

    public function setSourceData($sourceData):void {
        //handle exceptions if isn't json etc.
        //@todo maybe that could be done in pre (or even a validate() method?)
        if (is_string($sourceData)) {
            $sourceData = json_decode($sourceData, true);
        }
        $sourceData = $this->preSetSourceData($sourceData);
        $this->sourceData = $sourceData;
        $this->postSetSourceData();
    }

    protected function preSetVars(array $vars): array {
// echo"<h3>preSetVars: AbsSparqlEx</h3>";
        return $vars; //do nothing, let other classes implement this as needed
    }

    protected function postSetVars():void {
// echo"<h3>postSetVars: AbsSparqlEx";
        //do nothing, let other classes implement this as needed
    }

    protected function setVars():void {
        $vars = $this->sourceData['head']['vars'];
        $vars = $this->preSetVars($vars);
        $this->vars = $vars;
        $this->postSetVars();
    }

    protected function preSetBindings(array $bindings): array {
// echo"<h3>preSetBindings: AbsSparqlEx</h3>";
        return $bindings; //do nothing, let other classes implement this as needed
    }

    protected function postSetBindings(): void {
// echo"<h3>preSetBindings: AbsSparqlEx</h3>";
        //do nothing, let other classes implement this as needed
    }
    
    protected function setBindings():void {
        $bindings = $this->sourceData['results']['bindings'];
        $bindings = $this->preSetBindings($bindings);
        $this->bindings = $this->sourceData['results']['bindings'];
        $this->postSetBindings();
    }


    /**
     * removeVars
     *
     * remove vars so R'r doesn't have to deal with more than it cares about
     * must happen BEFORE and processing that is var-binding dependent happens
     * 
     * @param array $rowToRender a row that is part of the data to render
     * @param array $toRemoveArray a supplied array of the $vars to be removed
     * @return void
     */
    protected function removeVars(?array $varsToRemoveArray): void {
        //@todo make $toRemoveArray an ExtratorOption? 2023-04-06 18:01:26
        //check if a $toRemoveArray exists (as an ExtractorOption) and run conditionally
        //as a postSetDataToRender?
        // this is ahead of refactoring the reordering???
        

        $varsToRemoveArray = 
        [
            "langCode",
            "qid", 
            "personLabel",
            "donorPropLabel",
            "creatorPropLabel",
            "maintainerPropLabel",
            "founderPropLabel",
            "namePropLabel"
        ];

        foreach($this->vars as $index => $var) {
            if(in_array($var, $varsToRemoveArray)) {
                unset($this->vars[$index]);
            }

        }
        
    }
}
