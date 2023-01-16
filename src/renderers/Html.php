<?php
namespace Ceres\Renderer;

use DOMDocument;
use DOMElement;
use DOMXPath;

class Html extends AbstractRenderer {

    protected DOMElement $containerElement;
    protected DOMXPath $xPath;
    protected DOMDocument $htmlDom;
    protected string $templateFileName = 'html.html';

    public function __construct() {
        $this->loadHtmlTemplate();
        $this->xPath = new DOMXPath($this->htmlDom);
        $this->setContainerElement();

        parent::__construct();
    }

    public function render() {
        
    }

    public function toHtmlString($node = null) {
        if (is_null($node)) {
            $node = $this->containerElement;
        }
        return $this->htmlDom->saveHtml($node);
    }

    public function loadHtmlTemplate() {
        $this->htmlDom = new DOMDocument();
        $this->htmlDom->loadHtmlFile(CERES_ROOT_DIR . "/data/rendererTemplates/$this->templateFileName");
    }

    public function setContainerElement() {
        // $query = "/html[1]/body[1]/div[1]";
        // $nodes = $this->xPath->query($query);
        // $this->containerElement = $nodes->item(0);
        $this->containerElement = $this->htmlDom->getElementById('ceres-container');
    }

    public function getContainerElement() {

        return $this->containerElement;
    }


    public function appendToClass(DOMElement $element, $value ) {
        $class = $element->getAttribute('class');
        $class = $class .= " $value";
        $element->setAttribute('class', $class);
    }

}