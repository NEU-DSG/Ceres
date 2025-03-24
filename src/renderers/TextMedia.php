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
                $jwPlayerRenderArray['data']['jwPlayerSetup'] = $this->renderArray['drsItem']['data']['jwPlayerSetup'];
                // echo $jwPlayerRenderArray;
                // die();
                
                // pass off to Jwplayer renderer
                $jwPlayerRenderer = new Jwplayer;
                $jwPlayerRenderer->setRenderArrayFromArray($jwPlayerRenderArray);
                $jwPlayerRenderer->build();

                // $jwPlayerSetup = $jwPlayerRenderer->getJwplayerSetupAsJson();
                // echo $jwPlayerSetup;
                // die();




                // the jwPlayer node is built in a different DOMDocument
                // @todo is it? it _should be_ but doesn't seem to be
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
        $associatedFiles = $this->renderArray['drsAssociatedFiles'];

        foreach ($associatedFiles as $associatedFileRenderArray) {
            // look for text/html, then text/plain, then crap
            switch ($associatedFileRenderArray['type']) {
                case 'text/html':

                    $htmlUrl = $associatedFileRenderArray['data']['fileUrl'];
                    $html = file_get_contents($htmlUrl);

                    $htmlFrag = $this->htmlDom->createDocumentFragment();
                    $htmlFrag->appendXML($html);
                    return $htmlFrag;
                break;

                case 'text/plain':
                    $textUrl = $associatedFileRenderArray['data']['fileUrl'];
                    $text = file_get_contents($textUrl);
                    if (!$text) {
                        $text = "Could not find a transcript file";
                    }                    
                break;

                case 'application/pdf':
                    $pdfUrl = $associatedFileRenderArray['data']['fileUrl'];
                    $html = "Download <a href='". $pdfUrl . "'>PDF</a>";
                    $htmlFrag = $this->htmlDom->createDocumentFragment();
                    $htmlFrag->appendXML($html);
                    return $htmlFrag;
                break;

                default:
                    $text = 'Could not find a transcript file - found mimetype: ' . $associatedFileRenderArray['type'];

            }

        }
        
        $textNode = $this->htmlDom->createTextNode($text);
        return $textNode;
    }
}

