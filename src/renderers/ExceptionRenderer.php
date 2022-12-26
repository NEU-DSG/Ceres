<?php

namespace Ceres\Renderer;

use Ceres\Renderer\AbstractRenderer;
use Ceres\Exception\CeresException;

class Exception extends AbstractRenderer {

    public function render() {
        $this->html .= "Booooo. :(";
    
    }
}
