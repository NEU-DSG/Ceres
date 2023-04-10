<?php 

namespace Ceres\Renderer;

use DOMElement;

class LeafletMapBrc extends Html {
  
    protected string $jsonToInject;
    protected string $templateFileName = 'brc-leaflet.html';

    public function __construct() {
        parent::__construct();

        // echo CERES_ROOT_DIR . '/assets/js/leaflet/brc/brc-leaflet-response.json';
        // die();
//       $this->setDataToRenderFromFile(CERES_ROOT_DIR . '/assets/js/leaflet/brc/brc-leaflet-response.json');
        $this->setJsonToInjectFromFile(CERES_ROOT_DIR . '/assets/js/leaflet/brc/brc-leaflet-response.json');
    }

    public function build() {
        $this->containerNode->appendChild($this->jsonToInjectToScriptNode('response'));
    }

    // @todo  candidate for a Trait
    public function jsonToInjectToScriptNode(?string $varName = null, ?string $text = null) : DOMElement {
        $scriptNode = $this->htmlDom->createElement('script');

        if (is_null($text)) {
            $jsonToInject = $this->jsonToInject;
        } else {
            $jsonToInject = $text;
        }

        if (is_null($varName)) {
            $this->appendTextNode($scriptNode, $jsonToInject);
        } else {
            $this->appendTextNode($scriptNode, "var $varName = " . $jsonToInject);
        }
        
        return $scriptNode;
    }
}