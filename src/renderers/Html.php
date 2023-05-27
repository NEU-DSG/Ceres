<?php
namespace Ceres\Renderer;

use Ceres\Util\DataUtilities;
use DOMDocument;
use DOMElement;
use DOMXPath;

class Html extends AbstractRenderer {

    protected DOMElement $containerNode;
    protected DOMXPath $xPath;
    protected DOMDocument $htmlDom;
    protected string $templateFileName = 'html.html';

    public function __construct() {
        $this->setHtmlDom();
        $this->xPath = new DOMXPath($this->htmlDom);
        $this->setContainerNode();

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
    public function renderFullHtml(): string {
        $this->build();
        return $this->htmlDom->saveHtml();
    }

    public function render(): string {

        $this->build();

        // just to be nice if/when I end up with compound Renderers,
        // need to make sure I don't end up with multiple ids
        $this->containerNode->removeAttribute(('id'));
        //$templateNode = $this->htmlDom->getElementById('ceres-template');
        //$this->containerElement->removeChild($templateNode); 
        return $this->toHtmlString();
    }

    public function build(): void {
        $text = $this->getRendererOptionValue('text');
        $this->appendTextNode($this->containerNode, $text);
    }

    // @todo move to utils?
    public function linkify(array $linkData): DOMElement {
        $aElement = $this->htmlDom->createElement('a');
        $aElement->setAttribute('href', $linkData['url']);
        $this->appendTextNode($aElement, $linkData['label']);
        return $aElement;
        }
  
    public function toHtmlString(?DOMElement $node = null): string {
        if (is_null($node)) {
            $node = $this->containerNode;
        }
        return $this->htmlDom->saveHtml($node);
    }

    public function setHtmlDom(): void {
        $this->htmlDom = new DOMDocument();

        set_error_handler(["\Ceres\Util\DataUtilities", 'suppressWarnings'], E_WARNING);
        $this->htmlDom->loadHtmlFile(CERES_ROOT_DIR . "/data/rendererTemplates/$this->templateFileName");
        restore_error_handler();
    }

    public function setContainerNode(): void {
        $this->containerNode = $this->htmlDom->getElementById('ceres-container');
    }

    public function getContainerNode(): DOMElement {
        return $this->containerNode;
    }


    public function appendToClass(DOMElement $element, $value ): void {
        $class = $element->getAttribute('class');
        $class = $class .= " $value";
        $element->setAttribute('class', $class);
    }

    public function appendTextNode(DOMElement $element, ?string $text): void {
        $textNode = $this->htmlDom->createTextNode($text);
        $element->appendChild($textNode);
    }

    public function enumToSelect(array $enumOptions): DOMElement {
        $selectNode = $this->htmlDom->createElement('select');

        foreach ($enumOptions as $option) {
            $optionNode = $this->htmlDom->createElement('option');
            $this->appendTextNode($optionNode, $option);
            $selectNode->appendChild($optionNode);
        }
        return $selectNode;
    }

    public function arrayToUl(array $dataArray): DOMElement {
        $ulNode = $this->htmlDom->createElement('ul');
        foreach($dataArray as $liText) {
            $liNode = $this->htmlDom->createElement('li');
            $this->appendTextNode($liNode, $liText);
            $ulNode->appendChild($liNode);
        }
        return $ulNode;
    }

    public function varcharToInput(?string $text): DOMElement {
        $inputNode = $this->htmlDom->createElement('input');
        $inputNode->setAttribute('type', 'text');
        $inputNode->setAttribute('value', $text);
        return $inputNode;
    }

    public function textToTextArea(?string $text): DOMElement {
        $textAreaNode = $this->htmlDom->createElement('textarea');
        $this->appendTextNode($textAreaNode, $text);
        return $textAreaNode;
    }

    public function textToHeading(string $text, string $headingLevel): DOMElement {
        $headingNode = $this->htmlDom->createElement($headingLevel);
        $this->appendTextNode($headingNode, $text);
        return $headingNode;
    }

    public function boolToCheckbox(?bool $value) {

    }

}