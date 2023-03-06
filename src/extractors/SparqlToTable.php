<?php

namespace Ceres\Extractor;


class SparqlToTable extends AbstractSparqlExtractor {
    
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

    public function extract():void {

        $dataToRender = [];
        $dataToRender[] = $this->vars;
        $bindingVals = [];
        foreach ($this->bindings as $binding) {
            foreach ($this->vars as $var) {
                $bindingVals[] = $this->valueForBindingVar($binding, $var);
            }
            $dataToRender[] = $bindingVals;
            $bindingVals = [];
        }
        // echo "<h3>sparqlToTable, 50</h3>";
        // print_r($dataToRender);
        // die();

        $this->dataToRender = $dataToRender;
    }
}
