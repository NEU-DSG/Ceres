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

        $this->appendToClass($this->tbodyNode, $this->getRendererOptionValue('tbodyClass'));
        $this->appendToClass($this->theadNode, $this->getRendererOptionValue('theadClass'));
        $this->appendToClass($this->tfootNode, $this->getRendererOptionValue('tfootClass'));
        $this->appendToClass($this->captionNode, $this->getRendererOptionValue('captionClass'));
        $this->appendToClass($this->containerNode, $this->getRendererOptionValue('tableClass'));
    }

    public function setDataToRender(string $extractorName = null) {
        //@todo what happens if row lengths don't match? something for extractor
        //to throw something about?
    
        $dataToRender = [
            ['Ambiguous Thing', 'Option 1', 'Option 2'],
            ['Wednesday', 'day of the week', 'part of the Addams family'],
            ['Thing', 'Scary beast from _The Thing_', 'part of the Addams family'],
            ['Patrick', '2FP', '3FP'],
        ];
        $this->dataToRender['fakeExtractor'] = $dataToRender;
    }

    public function build() {
        foreach($this->dataToRender as $extractorName => $rowsData) {
            //$firstRowIsHeader = $this->getRenderOptionValue('firstRowIsHeader');
            $firstRowIsHeader = true;

            if ($firstRowIsHeader) {
                $headerRowData = array_shift($rowsData);
                $rowNode = $this->buildRow($headerRowData, 'th');
                $this->theadNode->appendChild($rowNode);
            }

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

    public function buildRow($rowData, $cellElement = 'td') {
        $trClass = $this->getRendererOptionValue('trClass');
        $tdClass = $this->getRendererOptionValue('tdClass');
        $thClass = $this->getRendererOptionValue('thClass');
        $theadClass = $this->getRendererOptionValue('theadClass');

        $trNode = $this->htmlDom->createElement('tr');
        $this->appendToClass($trNode, $trClass);

        foreach ($rowData as $columnData) {
            $tdNode = $this->htmlDom->createElement($cellElement);
            $this->appendTextNode($tdNode, $columnData);
            $this->appendToClass($tdNode, $tdClass);
            $trNode->appendChild($tdNode);
        }
        return $trNode;
    }
}
