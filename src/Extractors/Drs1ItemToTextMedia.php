<?php

namespace Ceres\Extractor;

use Ceres\Util\DataUtilities;

class Drs1ItemToTextMedia extends AbstractDrs1ItemExtractor {

    protected string $text; // @todo  do I need this?
    protected string $mediaUrl;  // @todo do I need this?
    protected array $renderArray = [
        'drsItem' => [
            'type' => 'jwPlayer',
            'data' => [
                'mods' => [],
                'drsPid' => '',
                'jwPlayerSetup' => [
                    'imageFile' => '', //the thumbnail for the media
                    'sourceFile' => '', //file url to give the player
                    'sourceFileType' => '', //mime type for the video/audio
                    'vttFile' => '', // url for the .vtt transcription file
                ]
            ] 
    
        ],
        // look among the associated files for what might be a transcription
        'drsAssociatedFiles' => [
            [
                'type' => '', // the mimetype of the associated file
                'data' => [
                    'fileUrl' => '', // the url to get the contents from
                ]
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
        // from parent class(es)
        $this->extractContentObjects();
        $this->renderArray['drsItem']['data']['mods'] = $this->extractAndReturnModsRenderArray();

        // defined here
        $this->extractAssociatedFiles();
        $this->extractMedia();
    }

    protected function extractMedia(): void {
        //it's called canonical_object in the response
        //there might be more
        // We want the wowza (stream) url, not the direct path to the source file
        $mediaUrl = array_key_first($this->sourceData['canonical_object']);

        //flip the array to make it easier to dig up associated files
        $contentObjects = array_flip($this->sourceData['content_objects']);
        
        if (array_key_exists('Text Document', $contentObjects)) {
            $vttFileUrl = $contentObjects['Text Document'];
        }
        
        $imageFile = $contentObjects['Master Image'];

        $mediaUrlParts = explode('/', $mediaUrl);
        $pid = $mediaUrlParts[array_keys($mediaUrlParts)[count($mediaUrlParts) - 1]];
        $pid = str_replace('?datastream_id=content', '', $pid);
        $wowzaUrl = 'https://repository.library.northeastern.edu/wowza/' . $pid . '/plain';
        $this->renderArray['drsItem']['data']['jwPlayerSetup']['sourceFile'] = $wowzaUrl;
        $this->renderArray['drsItem']['data']['jwPlayerSetup']['sourceFileType'] = 'video/mp4';
        //$this->renderArray['drsItem']['data']['jwPlayerSetup']['sourceFileType'] = $sourceFileType;

        if (isset($vttFileUrl)) {
            $this->renderArray['drsItem']['data']['jwPlayerSetup']['vttFile'] = $vttFileUrl;
        }
        
        $this->renderArray['drsItem']['data']['jwPlayerSetup']['imageFile'] = $imageFile;
    }
// @todo turn this into extractTextsArray to roll through the files and record mimetypes
// to pass along to the renderer

    protected function extractAssociatedFiles(): void {
        // @todo check this against having multiple pids in associated
        // might need to switch here after a mimetype check

        $parsedAssociatedFilesArray = [];

        if (is_null($this->sourceData['associated'])) {
            $this->renderArray['drsAssociatedFiles'] = [];
        } else {
        $associatedFilesArray = array_keys($this->sourceData['associated']);
        foreach ($associatedFilesArray as $pid) {
            $pidDataUrl = 'https://repository.library.northeastern.edu/api/v1/files/' . $pid;
            $pidData = file_get_contents($pidDataUrl);
            $pidData = json_decode($pidData, true);
            $canonicalObject = $pidData['canonical_object'];
            $fileUrl = array_key_first($canonicalObject);
            $mimeType = DataUtilities::getMimeTypeForUrl($fileUrl);
            $parsedAssociatedFilesArray[] = [
                'type' => $mimeType,
                'data' => ['fileUrl' => $fileUrl]
            ];
        }
        $this->renderArray['drsAssociatedFiles'] = $parsedAssociatedFilesArray;
        }
    }
}
