<?php

namespace Ceres\Renderer;

use Ceres\Renderer\AbstractRenderer;
use Ceres\Exception\CeresException;

class Exception extends Html {

    public function render() {
        $this->html .= "Booooo. :(";
    
    }
}
