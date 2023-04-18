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
        } else {
            $var = $binding[$var];
        }
        $value = $var['value'];

// echo "<h3>value1: $value</h3>";
        $value = $this->mapValueToLabel($value);
// echo "<h3>value2: $value</h3>";
        return $value;
    }


    //@todo likely move to absSqlExt?? or the same thing more general for Tables? A Trait?
    protected function postSetVars(): void {
//echo "<h2>postSetVars: STT</h2>";
        $this->reorderVars();
    }

    /**
     * 
     * For actions that must happen ONLY after I can lose the var-binding connection
     *
     * @return void
     */
    protected function preExtract():void {
        //@todo make varsToRemoveArray an option
        $this->removeVars($varsToRemoveArray = null);
    }

    public function extract():void {
        $this->preExtract();
        //$dataToRender[] = $this->getVars();
        $dataToRender[] = $this->vars;
        $bindingVals = [];
        foreach ($this->bindings as $binding) {
            foreach ($this->vars as $var) {
                $bindingVals[] = $this->valueForBindingVar($binding, $var);
            }
            $dataToRender[] = $bindingVals;
            $bindingVals = [];
        }
        //@todo the logic here needs to be updated for pre/post events see #34
        $this->setDataToRender($dataToRender);
    }

    protected function postSetDataToRender(): void {
        $valueLabelMapping = $this->valueForExtractorOption('valueLabelMapping');

        foreach ($this->vars as $var) {
            $newVars[] = $this->mapValueToLabel($var, $valueLabelMapping);
        }
        $this->dataToRender[0] = $newVars;
    }

    /**
     * mapValueToLabel
     * 
     * Take a value, generally from $this->headerDataToRender, and map it onto
     * a new, usually prettier, value for the Renderer to use
     * 
     * @todo worry about whether this should be in a TableRenderer
     *
     * @param string $value
     * @param string|null $valueLabelMapping
     * @return string
     */
    protected function mapValueToLabel(string $value, ?string $valueLabelMapping = null): string {
        //originalSequence can come from $this->vars
        //labelMapping can start with $this->vars
        //should ultimately be a map based on {var} and {var}Label
//echo "<h1>mapValueToLabel $value: STT</h1>";
        //from people.rq

        if (is_null($valueLabelMapping)) {
            $valueLabelMapping = $this->valueForExtractorOption('extractorValueLabelMappingFilePath');
        }
        if (is_null($valueLabelMapping)) {
            return $value;
        } else {
            $valueLabelMapping = json_decode(file_get_contents($valueLabelMapping), true);
        }



//@todo remove this!        
        $valueLabelMapping = [
            "langCode"  =>  "Language Code",
            "qid"  =>  "ID for use elsewhere", 
            "personLabel"  =>  null,
            "personDescription"  =>  "Description",
            "createdCollections"  =>  "Collections Created",
            "foundedOrganizations" =>  "Organizations Founded",
            "maintainsCollections" =>  "Collections Maintained",
            "donatedCollections"  =>  "Collections Donated",
            "donorPropLabel" =>  null,
            "creatorPropLabel" =>  null,
            "maintainerPropLabel" =>  null,
            "founderPropLabel" =>  null,
            "name"  =>  "Name",
            "namePropLabel"  =>  null,
            "officialWebsite"  =>  "Website",
            "officialWebsitePropLabel"  =>  null,
            "emailAddress"  =>  "Email",
            "emailAddressPropLabel"  =>  null
        ];
        
        if (key_exists($value, $valueLabelMapping)) {
                if (is_null($valueLabelMapping[$value])) {
                    return $value;
                }
                return $valueLabelMapping[$value];    
            } else {
                return $value;
            }
    }
}

