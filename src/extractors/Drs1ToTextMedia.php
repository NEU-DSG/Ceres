<?php

namespace Ceres\Extractor;

use Ceres\Util\DataUtilities;

class Drs1ItemToTextMedia extends AbstractDrs1ItemExtractor {

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
                    'sourceFileType' => 'video/mp4',
                    'vttFile' => '', // url for the .vtt transcription file
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
        $this->renderArray['drsItem']['data']['mods'] = $this->extractAndReturnModsRenderArray();

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
        $this->renderArray['drsItem']['data']['jwPlayerSetup']['sourceFileType'] = 'video/mp4';
        $this->renderArray['drsItem']['data']['jwPlayerSetup']['vttFile'] = '';
        $this->renderArray['drsItem']['data']['jwPlayerSetup']['imageFile'] = '';
    }

    protected function extractText(): void {
        $transcriptionPid = array_key_first($this->sourceData['associated']);

        $transcriptionDataUrl = 'https://repository.library.northeastern.edu/api/v1/files/' . $transcriptionPid;
        $transcriptionData = file_get_contents($transcriptionDataUrl);
        $transcriptionData = json_decode($transcriptionData, true);
        $canonicalObject = $transcriptionData['canonical_object'];
        $fileUrl = array_key_first($canonicalObject);
        $mimeType = DataUtilities::getMimeTypeForUrl($fileUrl);
        $this->renderArray['drsText']['type'] = $mimeType;
        $this->renderArray['drsText']['data']['fileUrl'] = $fileUrl;
    }

}
