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

    public function setSourceData($sourceData):void {
        if (is_string($sourceData)) {

            $sourceData = json_decode($sourceData, true);


        }
        $this->sourceData = $sourceData;
        $this->setVars();
        $this->setBindings();
    }

    protected function setVars():void {
        $this->vars = $this->sourceData['head']['vars'];
    }

    protected function setBindings():void {
        $this->bindings = $this->sourceData['results']['bindings'];
    }
}
