<?php

namespace Ceres\Extractor;

class Drs1ToTextMedia extends AbstractDrs1ItemExtractor {

    protected string $text; //TODO do I need this?
    protected string $mediaUrl;  //TODO do I need this?
    protected array $renderArray = [
        'drsItem' => [
            'type' => 'jwPlayer',
            'data' => [
                'mods' => [],
                'drsPid' => '',
                'jwPlayerSetup' => [
                    'image' => '', //the thumbnail for the media
                    'sourceFile' => '', //file url to give the player
                    'type' => '', // the file mime type
                    'ttlFile' => '', // url for the .ttl transcription file
                ]
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
        //there might be more

        // We want the wowza (stream) url, not the direct path to the source file
        $mediaUrl = array_key_first($this->sourceData['canonical_object']);
        $mediaUrlParts = explode('/', $mediaUrl);
        $pid = $mediaUrlParts[array_keys($mediaUrlParts)[count($mediaUrlParts) - 1]];
        $pid = str_replace('?datastream_id=content', '', $pid);
        $wowzaUrl = 'https://repository.library.northeastern.edu/wowza/' . $pid . '/plain';
        $this->renderArray['drsItem']['data']['jwPlayerSetup']['sourceFile'] = $wowzaUrl;
        $this->renderArray['drsItem']['data']['jwPlayerSetup']['type'] = 'mp4';
    }

    protected function extractText(): void {
        $transcriptionPid = array_key_first($this->sourceData['associated']);
// todo: need a full record to work from for testing/deving
        $textUrl = "https://nb9662.neu.edu/mockCeresData/sampleTranscription.txt";
        $this->renderArray['drsText']['data']['fileUrl'] = $textUrl;

//        $this->renderArray['drsText']['data']['text'] = file_get_contents($textUrl);
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

     // TODO: mime_content_type doesn't seem to work -- see if I can
     // grab the content type from a curl request for just the header info

/*     
    protected function getTextSubtype($filePath): string|false {
        $textSubtype = mime_content_type($filePath);
        if ($textSubtype == 'text/plain') {
            return $textSubtype;
        } else {
            // throw a Notice
            return false;
        }
    }
*/

}
