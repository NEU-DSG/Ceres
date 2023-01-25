<?php
namespace Ceres\Renderer;

use Ceres\Renderer\KeyValue;



class ViewPackage extends KeyValue {
    protected array $dataToRender = [];

    

    public function __construct() {
        parent::__construct();
        // setting explicitly here, because, ironically, this Renderer isn't
        // actually built into a Ceres\ViewPackage

        $options = [
            'keyClass' => 'ceres-vp-key',
            'valueClass' => 'ceres-vp-value',
            'separator' => '--'

        ];
    
        $this->setRendererOptions($options);
        
    }


}