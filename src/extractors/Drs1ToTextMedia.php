<?php

namespace Ceres\Extractor;

use Ceres\Extractor\AbstractExtractor;

class Drs1ToTextMedia extends AbstractDrs1ItemExtractor {

    protected string $text;
    protected string $mediaUrl;
    public array $renderArray = [
        'drsItem' => [
            'type' => 'jwPlayer',
            'data' => [
                'mods' => [],
                'drsPid' => '',
                'mediaUrl' => ''
            ] 
    
        ],
        'drsText' => [
            'type' => 'text',
            'data' => [
                'fileUrl' => 'the url to get the contents from',
                'text' => ''
    
            ]
        ]
    ];

    /**
     * extract
     * 
     * Takes the DRS v1 response and extract the relevant text and media data to renderer(s)
     *
     * @return void
     */
    public function extract(): void {
        // from parent class
        $this->extractContentObjects();
        $this->extractModsData();

        // defined here
        $this->extractText();
        $this->extractMediaUrl();
    }

    protected function extractMediaUrl(): void {
        //it's called canonical_object in the response
        $this->renderArray['drsItem']['data']['mediaUrl'] = array_key_first($this->sourceData['canonical_object']);
    }

    protected function extractText(): void {
        $textUrl = $this->contentObjectsArray['Text Document'];
        $this->renderArray['drsText']['data']['fileUrl'] = $textUrl;
        /*
        
        $mimeType = $this->getTextSubtype($textUrl);
        if ($mimeType == 'text/plain') {
            $this->renderArray['drsText']['data']['text'] = file_get_contents($textUrl);
        } else {
            $this->renderArray['drsText']['data']['text'] = "Could not detect mime type. Assuming it is text.";
            $this->renderArray['drsText']['data']['text'] .= file_get_contents($textUrl);
        }
        */

        $this->renderArray['drsText']['data']['text'] = file_get_contents($textUrl);
    }

    /**
     * getTextSubtype
     * 
     * Makes queries to DRS to figure out whether a "Text Document" is txt, pdf, other
     *
     * @param $filePath the URL for filepath to the file to detect
     * 
     * @return mixed
     */
    protected function getTextSubtype($filePath): mixed {
        $textSubtype = mime_content_type($filePath);
        if ($textSubtype == 'text/plain') {
            return $textSubtype;
        } else {
            // throw a Notice
            return false;
        }
    }
}
