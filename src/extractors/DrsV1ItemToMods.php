<?php

namespace Ceres\Extractor;

class DrsV1ItemToMods extends AbstractDrs1ItemExtractor {

    protected array $renderArray = [
        'type' => 'dl',
        'data' => []
    ];

    // todo: get rid of these when done devving
    public function getRenderArray(): array {
        return $this->renderArray;
    }

    public function getSourceData() {
        return $this->sourceData;
    }

    public function extract(): void {
        $this->extractModsData();
    }

    protected function extractModsData(): void {
        $modsDataArray = $this->sourceData['mods'];
        foreach($modsDataArray as $dt => $dds) {
            $dtDdsArray['dts'] = array($dt);
            $dtDdsArray['dds'] = [];
            foreach($dds as $dd) {
                $dtDdsArray['dds'][] = $dd;
            }
            $this->renderArray['data'][] = $dtDdsArray;
        }
    }

    // TODO: is this actually used?
    protected function extractDtDdGroup($dtDdGroup): array {
        foreach($dtDdGroup as $dt => $dds) {
            // simplifying the dt/dd structure assuming there's only one dt 'cuz that's what I get
            //$dtDdArray['dts'] = array($dt);
            $dtDdArray['dts'] = $dt;
            $dtDdArray['dds'] = [];
            echo $dt . PHP_EOL . PHP_EOL;
            echo $dds . PHP_EOL . PHP_EOL ;
            foreach($dds as $dd) {
                $dtDdsArray['dds'] = $dd;
            }
        }
        return $dtDdsArray;
    }
}

