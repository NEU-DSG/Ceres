<?php

namespace Ceres\Renderer;

use Ceres\Renderer\Html;
use DOMNode;

require(CERES_ROOT_DIR . '/src/renderers/Html.php');

class Card extends Html {

    protected DOMNode $mainNode;
    protected DOMNode $secondaryNode;
    protected string $templateFileName = 'card.html';

    public function __construct() {
        parent::__construct();

        $this->mainNode = $this->htmlDom->getElementById('ceres-card-main');
        $this->secondaryNode = $this->htmlDom->getElementById('ceres-card-secondary');
    }

    public function build(): void {
        $mainRenderArray = $this->renderArray['data']['main'];
        $this->mainNode = $this->buildMainNode($mainRenderArray);

        $secondaryRenderArray = $this->renderArray['data']['secondary'];
        $this->secondaryNode = $this->buildSecondaryNode($secondaryRenderArray);
    }

    protected function buildMainNode($mainRenderArray): void {
        $mainNode = $this->htmlDom->getElementById('ceres-card-main');
        foreach($mainRenderArray as $renderData) {
            if (is_array($renderData)) {
                $innerNode = $this->handleInnerRenderArray($renderData);
                $mainNode->appendChild($innerNode);
            } else {
                $this->appendTextNode($mainNode, $renderData);
            }
        }
    }

    protected function buildSecondaryNode($secondaryRenderArray): void {
        $secondaryNode = $this->htmlDom->getElementById('ceres-card-main');
        foreach($secondaryRenderArray as $renderData) {
            if (is_array($renderData)) {
                $innerNode = $this->handleInnerRenderArray($renderData);
                $secondaryNode->appendChild($innerNode);
            } else {
                $this->appendTextNode($secondaryNode, $renderData);
            }
        }
    }
}
