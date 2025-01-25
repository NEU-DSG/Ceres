<?php

namespace Ceres\Extractor;

abstract class AbstractDrs1Extractor extends AbstractExtractor {

    protected $solrDataArray = [];


    protected function extractSolrData(): array {
        $solrDataArray = [];

        return $solrDataArray;
    }

}