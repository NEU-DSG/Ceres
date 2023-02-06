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
        $this->setHtmlDom();
        $this->xPath = new DOMXPath($this->htmlDom);
        $this->setContainerElement();

        parent::__construct();
    }



    /**
     * renderFullHtml
     *
     * Renders the full HTML from DOCTYPE to closing </html>
     * Mostly used for dev/debuging
     * 
     * @return void
     */
    public function renderFullHtml() {
        $this->build();
        echo $this->htmlDom->saveHtml();
    }

    public function render() {

        $this->build();

        // just to be nice if/when I end up with compound Renderers,
        // need to make sure I don't end up with multiple ids
        $this->containerElement->removeAttribute(('id'));
        $templateNode = $this->htmlDom->getElementById('ceres-template');
        //$this->containerElement->removeChild($templateNode); 
        echo "<br>before toHtmlString<br>";
        echo $this->toHtmlString();
        echo "<br>after toHtmlString<br>";
    }

    public function build() {
        $text = $this->getRendererOption('text');
        $this->appendTextNode($this->containerElement, $text);

 
    }

    // @todo move to utils?
    public function linkify(array $linkData) : DOMElement {
        $aElement = $this->htmlDom->createElement('a');
        $aElement->setAttribute('href', $linkData['url']);
        $this->appendTextNode($aElement, $linkData['label']);
        return $aElement;
        }
  
    public function toHtmlString($node = null) : string {
        if (is_null($node)) {
            $node = $this->containerElement;
        }
        return $this->htmlDom->saveHtml($node);
    }

    public function setHtmlDom() {
        $this->htmlDom = new DOMDocument();
        $this->htmlDom->loadHtmlFile(CERES_ROOT_DIR . "/data/rendererTemplates/$this->templateFileName");
    }

    public function setContainerElement() {
        // $query = "/html[1]/body[1]/div[1]";
        // $nodes = $this->xPath->query($query);
        // $this->containerElement = $nodes->item(0);
        $this->containerElement = $this->htmlDom->getElementById('ceres-container');
    }

    public function getContainerElement() : DOMElement {
        return $this->containerElement;
    }


    public function appendToClass(DOMElement $element, $value ) {
        $class = $element->getAttribute('class');
        $class = $class .= " $value";
        $element->setAttribute('class', $class);
    }


    public function appendTextNode(DOMElement $element, string $text) {
        $textNode = $this->htmlDom->createTextNode($text);
        $element->appendChild($textNode);
    }

}