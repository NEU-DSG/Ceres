<?php

namespace Ceres\Renderer;

use DOMElement;
use DOMNode;

// only needed until I get a real autoloader
require_once('TextMedia.php');

class OralHistory extends TextMedia {

    protected string $templateFileName = 'oral-history.html';
    public DOMElement $metadataContainerNode;

    public function __construct() {
        parent::__construct();

        $this->textContainerNode = $this->htmlDom->getElementbyId('ceres-container-text');
        $this->mediaContainerNode = $this->htmlDom->getElementById('ceres-container-media');
        $this->metadataContainerNode = $this->htmlDom->getElementById('ceres-container-dl');
    }


    public function build(): void {
        $mediaContainerNode = $this->buildMediaContainerNode();
        $importedMediaContainerNode = $this->htmlDom->importNode($mediaContainerNode, true);
        $this->mediaContainerNode->appendChild($importedMediaContainerNode);
        $this->textContainerNode->appendChild($this->buildTextContainerNode());
        $dlRenderArray = $this->renderArray['drsItem']['data']['mods'];
        $this->metadataContainerNode->appendChild($this->dlRenderArrayToDl($dlRenderArray));
    }

    
}




