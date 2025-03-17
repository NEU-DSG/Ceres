<?php

namespace Ceres\Renderer;

use DOMNode;

class Tabbed extends Html {

    protected DOMNode $tabTemplate;
    protected DOMNode $panelTemplate;

    //set Container, from HTMLRenderer

    protected function setTabTemplate(): void {

    }

    protected function setTabPanelTemplate(): void {

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
        $tabId = "";

        return $tabId;
    }

    /**
     * mintTabPanelId
     * 
     * taking the tab id, mint a corresponding id
     *
     * @param string $tabId
     * @return string
     */
    protected function mintTabPanelId(string $tabId): string {
        $tabPanelId = "";

        return $tabPanelId;
    }

    /**
     * setTabId
     * 
     * Set the id on the tab, corresponding to its tabPanel
     *
     * @param DOMNode $tabNode
     * @return void
     */
    protected function setTabId(DOMNode $tabNode): DOMNode {

    }


    protected function setTabAriaSelected(DOMNode $tabNode): DOMNode {
        
    }

    protected function setTabTabIndex(DOMNode $tabNode): DOMNode {

    }

    /**
     * setTabPanelId
     * 
     * Set the id on the tabPanel, corresponding to its tab
     *
     * @param DOMNode $tabPanelNode
     * @return void
     */
    protected function setTabPanelId(DOMNode $tabPanelNode): DOMNode {

    }


    protected function setTabAriaControls(DOMNode $tabNode): DOMNode {

    }

    protected function setTabPanelAriaLabelledBy(DOMNode $tabPanelNode): DOMNode {

    }



    /**
     * buildTab
     * 
     * take the tabTemplate, clone it, and set its attributes
     *
     * @return DOMNode
     */
    protected function buildTab(): DOMNode {

    }

    /**
     * buildTabPanel
     * 
     * take the tabPanelTemplate, clone it, and set its attributes
     *
     * @return DOMNode
     */
    protected function buildTabPanel(): DOMNode {

    }

}
