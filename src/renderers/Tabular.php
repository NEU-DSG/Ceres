<?php

namespace Ceres\Renderer;

use DOMElement;

class Tabular extends Html {

    protected string $templateFileName = 'tabular.html';
    protected DOMElement $tbodyNode;
    protected DOMElement $theadNode;
    protected DOMElement $tfootNode;
    protected DOMElement $captionNode;

    public function __construct() {
        parent::__construct();

        $this->tbodyNode = $this->htmlDom->getElementsByTagName('tbody')->item(0);
        $this->theadNode = $this->htmlDom->getElementsByTagName('thead')->item(0);
        $this->tfootNode = $this->htmlDom->getElementsByTagName('tfoot')->item(0);
        $this->captionNode = $this->htmlDom->getElementsByTagName('caption')->item(0);

    }

    public function setDataToRender() {
        //@todo what happens if row lengths don't match? something for extractor
        //to throw something about?
    
        $dataToRender = [
            ['Ambiguous Thing', 'Option 1', 'Option 2'],
            ['Wednesday', 'day of the week', 'part of the Addams family'],
            ['Patrick', '2FP', '3FP'],
        ];
        $this->dataToRender['fakeExtractor'] = $dataToRender;
    }



    public function render() {
        $this->build();
        echo $this->toHtmlString();
    }

    public function build() {
        foreach($this->dataToRender as $extractorName => $rowsData) {
            foreach ($rowsData as $rowData) {
                $row = $this->buildRow($rowData);
                $this->tbodyNode->appendChild($row);      
            }

        }
      /*
        foreach ($this->extractors as $name=>$extractor) {
          fire up extractor(s) to get what's needed
        }



      */
    }

    public function buildRow($rowData) {
        $trClass = $this->getRenderOptionValue('trClass');
        $tdClass = $this->getRenderOptionValue('tdClass');

        $trNode = $this->htmlDom->createElement('tr');
        $this->appendToClass($trNode, $trClass);

        foreach ($rowData as $columnData) {
            $tdNode = $this->htmlDom->createElement('td');
            $this->appendTextNode($tdNode, $columnData);
            $this->appendToClass($tdNode, $tdClass);
            $trNode->appendChild($tdNode);
        }
        return $trNode;
    }
}
