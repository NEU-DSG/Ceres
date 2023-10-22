<?php
namespace CERES\Extractor;

use Ceres\Extractor\AbstractSparqlExtractor;

class SparqlToTable extends AbstractSparqlExtractor {

    protected array $mainVars;
    protected array $secondaryVars;

    public function extract() {
        $renderArray = [
            'type' => 'card',
            'data' => [
                'main' => [],
                'secondary' => [],
            ]
        ];

        foreach($this->mainVars as $mainVar) {
            $renderArray['data']['main'][] = $this->valueForBindingVar(string $binding, string $mainVar);
        }
    }

    public function setMainVars(array $mainVars): void {
        $this->mainVars = $mainVars;
    }

    public functionSetSecondaryVars(array $sedondaryVars): void {
        $this->secondaryVars = $secondaryVars;
    }

    protected function preSetVars(array $vars): array
    {
        
    }
}