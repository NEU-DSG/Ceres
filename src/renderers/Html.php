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
        $this->stripCeresIds();
        return $this->htmlDom->saveHtml();
    }

    public function render(): string {
        
        $this->build();
        // only strip the ids related to ceres, marked by the string
        // `ceres`, just before rendering so any ids can be there for processing
        // but need to go to avoid multiple ids on one page
        $this->stripCeresIds();
        return $this->toHtmlString();
    }

    public function build() {
        $text = $this->getRendererOptionValue('text');
        $this->appendTextNode($this->containerNode, $text);
    }

    public function imgRenderArrayToImg(array $renderData): DOMElement {
        $imgNode = $this->htmlDom->createElement('img');
        if (isset($renderData['globalAtts'])) {
            $this->setGlobalAttributes($renderData['globalAtts'], $imgNode);
            unset($renderData['globalAtts']);
        }
        
        return $imgNode;
    }

    // @todo move to utils?
    public function linkArrayToA(array $linkData) : DOMElement {
        $aNode = $this->htmlDom->createElement('a');
        if (isset($renderData['globalAtts'])) {
            $this->setGlobalAttributes($linkData['globalAtts'], $aNode);
            unset($renderData['globalAtts']);   
        }
        
        
        $aNode->setAttribute('href', $linkData['url']);
        $this->appendTextNode($aNode, $linkData['label']);
        return $aNode;
    }
  
    public function toHtmlString(?DOMElement $node = null) : string {
        if (is_null($node)) {
            $node = $this->containerNode;
        }
        return $this->htmlDom->saveHtml($node);
    }

    public function setHtmlDom() {
        $this->htmlDom = new DOMDocument();

        set_error_handler(["\Ceres\Util\DataUtilities", 'suppressWarnings'], E_WARNING);
        $this->htmlDom->loadHtmlFile(CERES_ROOT_DIR . "/data/rendererTemplates/$this->templateFileName");
        restore_error_handler();
    }

    protected function setContainerNode() {
        $this->containerNode = $this->htmlDom->getElementById('ceres-container');
    }

    protected function getContainerNode() : DOMElement {
        return $this->containerNode;
    }


    protected function appendToClass(DOMElement $element, $value ):void {
        $class = $element->getAttribute('class');
        $class = $class .= " $value";
        $element->setAttribute('class', $class);
    }

    protected function appendTextNode(DOMElement $element, ?string $text) {
        $textNode = $this->htmlDom->createTextNode($text);
        $element->appendChild($textNode);
    }



/* mini-renderers to build really simple HTML elements */

    // @todo move to utils?
    protected function linkRenderArrayToA(array $linkData) : DOMElement {
        $aElement = $this->htmlDom->createElement('a');
        $aElement->setAttribute('href', $linkData['url']);
        $this->appendTextNode($aElement, $linkData['label']);
        return $aElement;
    }

    //@todo or pass off to a KeyValue renderer?
    protected function kvRenderArrayToKeyValue(array $keyValueData): DOMElement {
        $kvContainerNode = $this->htmlDom->createElement('div');
        foreach($keyValueData as $key=>$value) {
            if (is_array($value)) {
                $text = "$key: an array!";
            } else {
                $text = "$key: $value";
            }
            $kvPContainerNode = $this->htmlDom->createElement('p');
            $this->appendTextNode($kvPContainerNode, $text);
            $kvContainerNode->appendChild($kvPContainerNode);
        }
        return $kvContainerNode;
    }



    protected function enumRenderArrayToSelect(array $enumOptions) : DOMElement {
        $selectNode = $this->htmlDom->createElement('select');
        foreach ($enumOptions as $option) {
            $optionNode = $this->htmlDom->createElement('option');
            $this->appendTextNode($optionNode, $option);
            $selectNode->appendChild($optionNode);
        }
        return $selectNode;
    }

    // protected function extractorComplexKeyValueArrayToUl(array $dataArray): DOMElement {
    //     $ulNode = $this->htmlDom->createElement('ul');
    //     foreach($dataArray as $key => $value) {
    //         //li for $key
    //         $liNode = $this->htmlDom->createElement('li');
    //         $this->appendTextNode($liNode, $key);
            
    //         //new ul for $value
    //         //@todo remove assumption that all the complex (values) are ul
    //         $subUlNode = $this->renderArrayToUl($value['data']);
    //         $liNode->appendChild($subUlNode);
    //         $ulNode->appendChild($liNode);
    //     }

    //     return $ulNode;
    // }


    protected function listRenderArrayToUl(array $renderArray) {
        $ulNode = $this->htmlDom->createElement('ul');
        if (isset($renderData['globalAtts'])) {
            $this->setGlobalAttributes($renderData['globalAtts'], $ulNode);
            unset($renderData['globalAtts']);
        }
        
        foreach($renderArray as $liText) {
            $liNode = $this->htmlDom->createElement('li');
            $this->appendTextNode($liNode, $liText);
            $ulNode->appendChild($liNode);
        }
        return $ulNode;
    }

    public function listRenderArrayToOl(array $renderData) : DOMElement {
        $olNode = $this->htmlDom->createElement('ol');
        if (isset($renderData['globalAtts'])) {
            $this->setGlobalAttributes($renderData['globalAtts'], $olNode);
            unset($renderData['globalAtts']);  
        }
        
        foreach($renderData as $liText) {
            $liNode = $this->htmlDom->createElement('li');
            $this->appendTextNode($liNode, $liText);
            $olNode->appendChild($liNode);
        }
        return $olNode;
    }

    public function varcharToInput(?string $text) : DOMElement {
        $inputNode = $this->htmlDom->createElement('input');
        $inputNode->setAttribute('type', 'text');
        $inputNode->setAttribute('value', $text);
        return $inputNode;
    }

    protected function textToTextArea(?string $text) : DOMElement {
        $textAreaNode = $this->htmlDom->createElement('textarea');
        $this->appendTextNode($textAreaNode, $text);
        return $textAreaNode;
    }

    protected function textToHeading(string $text, string $headingLevel) : DOMElement {
        $headingNode = $this->htmlDom->createElement($headingLevel);
        $this->appendTextNode($headingNode, $text);
        return $headingNode;
    }

    protected function boolToCheckbox(?bool $value) {

    }


    protected function handleInnerRenderArray($renderData) {
        switch ($renderData['type']) {
            case 'list':
                switch ($renderData['subtype']) {
                    case 'ul':
                        $innerNode = $this->listRenderArrayToUl($renderData['data']);
                    break;
        
                    case 'ol':
                        $innerNode = $this->listRenderArrayToOl($renderData['data']);
                    break;
                }
            break;

            case 'img':
                $innerNode = $this->imgRenderArrayToImg($renderData['data']);
            break;


            case 'keyValue':

            break;
        }
        return $innerNode;
    }

    protected function stripCeresIds(): void {
        $xpath = "//div[contains(@id,'ceres')]";
        $nodes = $this->xPath->query($xpath, $this->htmlDom);
        foreach ($nodes as $node) {
            $node->removeAttribute('id');
        }
    }

    protected function setGlobalAttributes(array $globalAtts = [], DOMElement $node) {
        foreach($globalAtts as $att => $value) {
            $attributeNode = $this->htmlDom->createAttribute($att);
            $attributeNode->value = $value;
            $node->appendChild($attributeNode);
        }

    }
}
