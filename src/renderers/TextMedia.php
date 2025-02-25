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
        //$importedMediaContainerNode = $this->htmlDom->importNode($mediaContainerNode, true);
        $this->mediaContainerNode->appendChild($mediaContainerNode);
        $this->textContainerNode->appendChild($this->buildTextContainerNode());
    }

    public function buildMediaContainerNode(): DOMNode {
        $type = $this->renderArray['drsItem']['type'];
        switch ($type) {
            case "jwPlayer":
                $jwPlayerRenderArray = [
                    'type' => 'jwPlayer',
                    'data' => [
                        'jwPlayerSetup' => []
                    ]
                ];
                // print_r($this->renderArray);
                // die();
                $jwPlayerRenderArray['data']['jwPlayerSetup'] = $this->renderArray['drsItem']['data']['jwPlayerSetup'];
                // print_r($jwPlayerRenderArray);
                // die();
                // pass off to Jwplayer renderer
                $jwPlayerRenderer = new Jwplayer;
                $jwPlayerRenderer->setRenderArrayFromArray($jwPlayerRenderArray);
                $jwPlayerRenderer->build();
                // the jwPlayer node is built in a different DOMDocument
                $foreignContainerNode = $jwPlayerRenderer->getContainerNode();
                $nativeContainerNode = $this->htmlDom->importNode($foreignContainerNode, true);
               
                //$jwPlayerNode = $this->htmlDom->getElementById('jwplayer');
                $jwPlayerNode = $this->htmlDom->createElement('div');
                $jwPlayerNode->setAttribute('id', 'jwplayer');
               
                $jwPlayerNode->appendChild($nativeContainerNode);
                
                return $jwPlayerNode;
            break;



        }

    }

    public function buildTextContainerNode(): DOMNode {
        $text = $this->renderArray['drsText']['data']['text'];
        $textUrl = $this->renderArray['drsText']['data']['fileUrl'];
        $text = file_get_contents($textUrl);
        if (!$text) {
            $text = "Could not find a transcript file";
        }
        $textNode = $this->htmlDom->createTextNode($text);
        return $textNode;
    }
}

