<?php
namespace Ceres\Renderer;


use DOMDocument;
use DOMElement;
use DOMXPath;
use Ceres\Util\DataUtilities as DataUtil;

class ViewPackage extends Html {
    //@todo: a temp shim until the extractor is built
    protected array $dataToRender = [];
    protected string $templateFileName = 'vpdata.html';
    protected string $viewPackageName;
    protected DOMElement $vpRendererDetailsNode;
    protected DOMElement $vpExtractorDetailsNode;
    protected DOMElement $vpFetcherDetailsNode;
    

    public function __construct(string $viewPackageName) {
        
        
        $this->viewPackageName = $viewPackageName;

        parent::__construct();


        $this->setDataToRender();
    }

    public function setDataToRender() {
        $allVpData = DataUtil::getWpOption('ceres_view_packages');
        $rendererData =$allVpData[$this->viewPackageName];
        //$rendererClassInfo = $rendererData['renderer'];
        $rendererClassInfo = DataUtil::skipArrayLevel($rendererData['renderer']);

        $rendererName = $rendererClassInfo['fullClassName'];
        $rendererOptions = $rendererClassInfo['options'];
        
        foreach ($rendererOptions as $index => $optionName) {
            $optionValue = DataUtil::valueForOption($optionName, $this->viewPackageName);
            $rendererOptions[$optionName] = $optionValue;
            unset($rendererOptions[$index]);
        }

        $rendererData['renderer']['Tabular']['options'] = $rendererOptions;

        $this->dataToRender = $rendererData;
    }

    public function build() {



    }

    public function buildDetailsNode(array $dataForDetails) {
        $detailsNode = $this->htmlDom->createElement(('details'));
        $summaryNode = $this->htmlDom->createElement('summary');
        $detailsNode->appendChild($summaryNode);

        foreach($dataForDetails as $option=>$valuesArray) {
            $dlNode = $this->htmlDom->createElement('dl');

            foreach($valuesArray as $value) {
                $dtNode = $this->htmlDom->createElement('dt');
                $ddNode = $this->htmlDom->createElement('dd');;
            }
        }
    }

}