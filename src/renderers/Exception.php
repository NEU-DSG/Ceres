<?php

namespace Ceres\Renderer;

use Ceres\Renderer\AbstractRenderer;
//use Ceres\Renderer\Html;
use Ceres\Exception\CeresException;

require_once('/var/www/html/Ceres/src/renderers/Html.php');

class Exception extends Html {

    public function render() {
        $this->html .= "Booooo. :(";
    
    }
}
