<?php

namespace Ceres\Renderer;

require_once(CERES_ROOT_DIR . '/src/renderers/Html.php');

use DOMElement;
use DOMNode;
use Ceres\Renderer\Html as Html;

class TextMedia extends Html {


    protected string $templateFileName = 'text-media.html';
    public DOMElement $textContainerNode;
    public DOMElement $mediaContainerNode;

    public function __construct() {
        parent::__construct();

        $this->textContainerNode = $this->htmlDom->getElementbyId('ceres-container-text');
        $this->mediaContainerNode = $this->htmlDom->getElementById('ceres-container-media');
    }

    public function build(): void {
        $this->mediaContainerNode->appendChild($this->buildMediaContainerNode());
        $this->textContainerNode->appendChild($this->buildTextContainerNode());
    }

    public function buildMediaContainerNode(): DOMNode {
        $jwPlayerNode = $this->htmlDom->createElement('div');
        $jwPlayerNode->setAttribute('id', 'jw-player');

        // TODO: fill this in with real jwPlayer
        $tempTextNode = $this->htmlDom->createTextNode("to be filled in with JWPlayer");
        $jwPlayerNode->appendChild($tempTextNode);
        return $jwPlayerNode;
    }

    public function buildTextContainerNode(): DOMNode {
        $text = $this->renderArray['drsText']['data']['text'];
        $textUrl = $this->renderArray['drsText']['data']['fileUrl'];
        $text = file_get_contents($textUrl);
        $textNode = $this->htmlDom->createTextNode($text);
        return $textNode;
    }
}

