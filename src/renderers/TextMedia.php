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
        $mediaContainerNode = $this->buildMediaContainerNode();
        $importedMediaContainerNode = $this->htmlDom->importNode($mediaContainerNode, true);
        $this->mediaContainerNode->appendChild($importedMediaContainerNode);
        $this->textContainerNode->appendChild($this->buildTextContainerNode());
    }

    public function buildMediaContainerNode(): DOMNode {
        $type = $this->renderArray['drsItem']['type'];
        switch ($type) {
            case "jwPlayer":
                // pass off to Jwplayer renderer
                $jwPlayerRenderer = new Jwplayer;
                $jwPlayerRenderer->setRenderArrayFromArray($this->renderArray['drsItem']);
                $jwPlayerRenderer->build();
                return $jwPlayerRenderer->getContainerNode();

            break;



        }
        $jwPlayerNode = $this->htmlDom->getElementById('jwplayer');
        $jwPlayerNode->setAttribute('id', 'jwplayer');
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

