<?php

namespace Ceres\Renderer;

use DOMElement;
use DOMNode;

class Tabbed extends Html {

    protected DOMElement $tabTemplate;
    protected DOMElement $tabPanelTemplate;
    protected DOMNode $tabsContainer;

    public function __construct() {
        parent::__construct();

        $this->setTabsContainer();
        $this->setTabTemplate();
        $this->setTabPanelTemplate();
    }

    public function build(): void {
        foreach ($this->renderArray['data'] as $index=>$tabPanelPair) {
            if ($index == 0) {
                $this->buildTabTabPanelPair($tabPanelPair, true);
            } else {
                $this->buildTabTabPanelPair($tabPanelPair, false);
            }
        }
    }

    protected function setTabsContainer(): void {
        $this->tabsContainer = $this->htmlDom->getElementById('ceres-tabbed-tabs');
    }

    protected function setTabTemplate(): void {
        $this->tabTemplate = $this->htmlDom->getElementById('ceres-tab-template');
    }

    protected function setTabPanelTemplate(): void {
        $this->tabPanelTemplate = $this->htmlDom->getElementById('ceres-tab-panel-template');
    }

    protected function buildTabTabPanelPair(array $renderArray, $isFirst = false): void {
        $tabId = $this->mintTabId();

        $newTabNode = $this->buildTab($tabId, $isFirst);
        $newTabPanelNode = $this->buildTabPanel($tabId, $isFirst);

        $this->tabsContainer->appendChild($newTabNode);
        $this->containerNode->appendChild($newTabPanelNode);

    }

    /**
     * mintTabId
     * 
     * create a unique id for the tab
     *
     * @return string
     */
    protected function mintTabId(): string {
        //mint an id for the tab
        $tabId = 'tab-' . time(); //just my first guess for how to do this. therefore own method if it has to change
        return $tabId;
    }

    /**
     * buildTab
     * 
     * take the tabTemplate, clone it, and set its attributes
     *
     * @param tabId the id to apply to the attribute node
     * @param isFirst true if it is the first (selected) tab
     * 
     * @return DOMNode
     */
    protected function buildTab(string $tabId, bool $isFirst): DOMElement {
        $tabNode = $this->tabTemplate->cloneNode(true);
        $tabNode->setAttribute('id', $tabId);

        if ($isFirst) {
            $tabNode->setAttribute('aria-selected', 'true');
            $tabNode->setAttribute('tabindex', '0');
        }

        $tabNode->setAttribute('id', $tabId);
        $tabNode->setAttribute('aria-controls', $tabId . '-content');

        return $tabNode;
    }

    /**
     * buildTabPanel
     * 
     * take the tabPanelTemplate, clone it, and set its attributes
     *
     * @param tabId the basis tabId to build the corresponding panel id 
     * @param isFirst true if it is the first (selected) tab
     * @return DOMNode
     */
    protected function buildTabPanel(string $tabId, bool $isFirst): DOMElement {
        $tabPanelId = $tabId . '-content';
        
        $newTabPanelNode = $this->tabPanelTemplate->cloneNode();
        $newTabPanelNode->setAttribute('id', $tabPanelId);

        if ($isFirst) {
            //$newTabPanelNode->setAttribute('tabindex', '0'); @todo see if i need this
        } else {
            $newTabPanelNode->setAttribute('hidden', 'hidden');
        }

        $newTabPanelNode->setAttribute('aria-labelledby', $tabId);
        return $newTabPanelNode;
    }
}
