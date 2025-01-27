<?php

namespace Ceres\Extractor;

use Ceres\Extractor\AbstractDrs1Extractor;

$renderArrayStructure = [
    'drsItem' => [
        'type' => 'jwPlayer',
        'data' => [
            'mods' => [],
            'drsPid' => '',
        ] 

    ],
    'drsTextData' => [
        'type' => 'text',
        'subtype' => 'text/plain | pdf',
        'data' => [
            'fileUrl' => 'the url to get the contents from'

        ]
    ]


];

class Drs1ToTextMedia extends AbstractDrs1ItemExtractor {

    /**
     * extract
     * 
     * Takes the DRS v1 response and extract the relevant text and media data to renderer(s)
     *
     * @return void
     */
    public function extract(): void {
        $this->extractContentObjects();
        $this->extractModsData();
    }

    protected function extractMediaUrl(): void {

    }

    protected function extractText(): void {

    }

    /**
     * getTextSubtype
     * 
     * Makes queries to DRS to figure out whether a "Text Document" is txt, pdf, other
     *
     * @param $filePath the URL for filepath to the file to detect
     * 
     * @return string
     */
    protected function getTextSubtype($filePath): string {
        // $textSubtype = mime_content_type($filePath);
        // if ($textSubtype) {

        // } else {

        // }
        $textSubtype = ''; // usually either txt or pdf; possibly others like iiif or (shudder) a word processor doc like docx or odf
        return $textSubtype;
    }
}