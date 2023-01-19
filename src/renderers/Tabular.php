<?php

namespace Ceres\Renderer;

use DOMElement;

class Tabular extends Html {

    protected string $templateFileName = 'tabular.html';
    protected DOMElement $tbodyEl;
    protected DOMElement $theadEl;
    protected DOMElement $tfootEl;
    protected DOMElement $captionEl;

    public function __construct() {
        parent::__construct();

        $this->tbodyEl = $this->htmlDom->getElementsByTagName('tbody')->item(0);
        $this->theadEl = $this->htmlDom->getElementsByTagName('thead')->item(0);
        $this->tfootEl = $this->htmlDom->getElementsByTagName('tfoot')->item(0);
        $this->captionEl = $this->htmlDom->getElementsByTagName('caption')->item(0);

    }

    public function render() {
        echo "hi. ready to render! \n";
    }

    public function build() {
    
      /*
        foreach ($this->extractors as $name=>$extractor) {
          fire up extractor(s) to get what's needed
        }



      */
    }

    public function appendTableRow(DOMElement $parentEl, array $rowData) {
        foreach ($rowData as $key => $value) {
            $tr = $this->htmlDom->createElement('tr');
            //deal with adding tds or ths
            //figure out atts or other from $rowData
        }

        $parentEl->appendChild($parentEl);
    }

}
