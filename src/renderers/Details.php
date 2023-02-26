<?php

namespace Ceres\Renderer;

use Ceres\Renderer\Html;

require_once('/var/www/html/Ceres/src/renderers/Html.php');

class Details extends Html {

    protected string $templateFileName = 'details.html';


    public function build() {

        $this->dataToRender = [
            'summary' => "Fear what lurks below, should you choose....",
            'details' => "BWAHAHAHAHAHAHAHAHAHAHHA!"
        ];

        $detailsEl = $this->htmlDom->getElementsByTagName('details')->item(0);
        $summaryEl = $this->htmlDom->getElementsByTagName('summary')->item(0);
        $this->appendTextNode($summaryEl, $this->dataToRender['summary']);
        $this->appendTextNode($detailsEl, $this->dataToRender['details']);
    }
}
