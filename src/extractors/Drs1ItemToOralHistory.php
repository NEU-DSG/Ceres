<?php

namespace Ceres\Extractor;

use ArrayObject;
use Ceres\Util\DataUtilities;

class Drs1ItemToOralHistory extends Drs1ItemToTextMedia {

    protected array $transcriptionRenderArray;
    protected array $metadataRenderArray;
    protected ArrayObject $tabArrayTemplate;
    protected ArrayObject $tabContentArrayTemplate;

    protected $renderArray = [
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
        'drsText' => [
            'type' => 'tabbed', 
            'data' => [
                'tabs' => [
                    ['type' => 'tab',
                     'data' => [
                        'id' => '', // handled by renderer for matching tabContent
                        'label' => 'plain text label' // @todo or HTML?
                     ]
                    ]
                    // repeat as necessary
                    
                ],
                'tabContent' => [
                    [
                        'type' => 'tabcontent',
                        'data' => [
                            'id' => '', // handled by renderer for matching up tab
                            'tabContentRenderArray' => []
                        ]
                    ]
                    // repeat as necessary
                ]
            ]
        ]
    ];

    /**
     * extractText
     * 
     * Overrides parent class to create the renderArray for tabbed content,
     * dealing with the different text sources, probably just transcript and metadata
     *
     * @return void
     */
    protected function extractText(): void {
        // @todo check this against having multiple pids in associated
        // might need to switch here after a mimetype check
        $transcriptionPid = array_key_first($this->sourceData['associated']);

        $transcriptionDataUrl = 'https://repository.library.northeastern.edu/api/v1/files/' . $transcriptionPid;
        $transcriptionData = file_get_contents($transcriptionDataUrl);
        $transcriptionData = json_decode($transcriptionData, true);
        $canonicalObject = $transcriptionData['canonical_object'];
        $fileUrl = array_key_first($canonicalObject);
        $mimeType = DataUtilities::getMimeTypeForUrl($fileUrl);


        // @todo turn these into tabPanels
        $this->renderArray['drsText']['type'] = $mimeType;
        $this->renderArray['drsText']['data']['fileUrl'] = $fileUrl;

        // see https://www.php.net/manual/en/arrayobject.getarraycopy.php

        $transcriptionRenderArray = [
            'drsText' => [
                'type' => $mimeType,
                'data' => [
                    'fileUrl' => $fileUrl
                ]
            ]
        ];
        
    }

    protected function setTabTemplateArrayObject(): void {

        $tabArrayTemplate =                    
         [  'type' => 'tab',
            'data' => [
            'id' => '', // handled by renderer for matching tabContent
            'label' => 'plain text label' // @todo or HTML?
            ]
        ];

        $this->tabArrayTemplate = new ArrayObject($tabArrayTemplate);

    }

    protected function setTabContentTemplateArrayObject(): void {

        $tabContentArrayTemplate =
        [
            'type' => 'tabcontent',
            'data' => [
                'id' => '', // handled by renderer for matching up tab
                'tabContentRenderArray' => []
            ]
        ];

        $this->tabContentArrayTemplate = new ArrayObject($tabContentArrayTemplate);
    }

}