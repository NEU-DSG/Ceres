<?php

namespace Ceres\Renderer;

use Ceres\Renderer\Html;
use DOMNode;

// require_once('/var/www/html/Ceres/src/renderers/Html.php');
require_once(CERES_ROOT_DIR . '/src/renderers/Html.php');
class Details extends Html {

    protected DOMNode $detailsNode;
    protected DOMNode $summaryNode;
    protected string $templateFileName = 'details.html';

    public function __construct() {
        parent::__construct();

        $this->detailsNode = $this->htmlDom->getElementById('ceres-details');
    }
    public function build(): void {
        $mainRenderArray = $this->renderArray['data']['main'];
        $this->summaryNode = $this->buildSummaryNode($mainRenderArray);

        $secondaryRenderArray = $this->renderArray['data']['secondary'];
        $this->detailsNode = $this->buildDetailsNode($secondaryRenderArray);

    }


    protected function buildSummaryNode($mainRenderArray): void {
        $summaryNode = $this->htmlDom->getElementById('ceres-summary');
        foreach($mainRenderArray as $renderData) {
            if (is_array($renderData)) {
                $innerNode = $this->handleInnerRenderArray($renderData);
                $summaryNode->appendChild($innerNode);
            } else {
                $this->appendTextNode($summaryNode, $renderData);
            }
        }
    }

    protected function buildDetailsNode($mainRenderArray): void {
        $summaryNode = $this->htmlDom->getElementById('ceres-details');
        foreach($mainRenderArray as $renderData) {
            if (is_array($renderData)) {
                $innerNode = $this->handleInnerRenderArray($renderData);
                $summaryNode->appendChild($innerNode);
            } else {
                $this->appendTextNode($summaryNode, $renderData);
            }
        }
    }
}
