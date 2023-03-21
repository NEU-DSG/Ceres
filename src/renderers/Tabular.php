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

    public function setDataToRender(?string $extractorName = null) {
        //have this roll through the fetcher->fetchData --> $extractor->setSourceData() chain
        $fetcher = $this->fetchers[0];
        $extractor = $this->extractors[0];

        $sourceData = $fetcher->fetchData();

        $extractor->setSourceData($sourceData);
        $extractor->extract();

        $this->dataToRender = $extractor->getDataToRender();
    }

    public function build() {
        $rowsData = $this->dataToRender; 
        $firstRowIsHeader = $this->getRendererOptionValue('firstRowIsHeader');

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
