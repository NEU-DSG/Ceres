<?php
namespace Ceres\Renderer;

use Ceres\Renderer\Html;
use Ceres\Util\DataUtilities as DataUtil;
use Ceres\Util\StringUtilities as StringUtil;


class KeyValue extends Html {
    protected string $templateFileName = 'keyvalue.html';

    public function build() {
        
        foreach($this->dataToRender as $rowData) {
            $row = $this->buildRow($rowData);
            $this->containerElement->appendChild($row);
        }
    }

    public function buildRow($rowData) {
        $row = $this->htmlDom->createElement('div');
        $this->appendToClass($row, 'ceres-keyvalue-row');
        $keyNode = $this->htmlDom->createElement('span');
        $this->appendToClass($keyNode, 'ceres-key');
        $valueNode = $this->htmlDom->createElement('span');
        $this->appendToClass($valueNode, 'ceres-value');
        $separatorNode = $this->htmlDom->createElement('span');
        $this->appendToClass($separatorNode, 'ceres-separator');

        $this->appendTextNode($keyNode, $rowData['key']);
        $this->appendTextNode($valueNode, $rowData['value']);
        $separator = $this->getRendererOption('separator');
        $this->appendTextNode($separatorNode, $separator);

        $row->appendChild($keyNode);
        $row->appendChild($separatorNode);
        $row->appendChild($valueNode);
        return $row;
    }
}