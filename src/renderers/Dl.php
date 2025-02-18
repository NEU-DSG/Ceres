<?php

namespace Ceres\Renderer;

class Dl extends Html {

    protected string $templateFileName = 'dl.html';

    public function build(): void {
        // Html render has this method as a subrenderer,
        // but I need the full container stuff
        // also, I need to fix handleInnerRenderArray
        $this->containerNode->appendChild($this->dlRenderArrayToDl($this->renderArray));
    }



}

