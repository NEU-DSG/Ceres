<?php

namespace Ceres\Renderer\Html;

use Ceres\Renderer\Html;
use DOMNode;

class Card extends Html {

    protected DOMNode $mainNode;
    protected DOMNode $secondaryNode;


    public function __construct() {
        parent::__construct();

        $this->mainNode = $this->htmlDom->getElementById('ceres-card-main');
        $this->secondaryNode = $this->htmlDom->getElementById('ceres-card-secondary');
    }

    public function build() {
        $mainRenderArray = $this->renderArray['data']['main'];
        $secondaryArray = $this->renderArray['data']['secondary'];
    }

    protected function buildMainNode($mainRenderArray) {
        foreach($mainRenderArray as $element) {
            if (is_array($element)) {

            } else {
                
            }
        }
    }
}
