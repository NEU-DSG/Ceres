<?php
namespace Ceres\Renderer;

use Ceres\Renderer\KeyValue;



class ViewPackage extends KeyValue {
    //@todo: a temp shim until the extractor is built
    protected array $dataToRender = [];

    

    public function __construct()
    {
        parent::__construct();
        $options = [
            'keyClass' => 'ceres-vp-key',
            'valueClass' => 'ceres-vp-value',
            'separator' => '--'

        ];
        $this->dataToRender =  [
            ['key' => 'propName1',
             'value' => 'value1'
            ],
            ['key' => 'propName2',
            'value' => 'value2'
            ],
            ['key' => 'propName3',
            'value' => 'value3'
            ] ,
    
    
        ];
    

        $this->setRendererOptions($options);

        
    }
}