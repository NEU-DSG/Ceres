<?php

namespace Ceres\Extractor;

use ArrayObject;
use Ceres\Util\DataUtilities;

require_once(CERES_ROOT_DIR . '/src/extractors/Drs1ItemToTextMedia.php');

class Drs1ItemToOralHistory extends Drs1ItemToTextMedia {

    // we can use $modsRenderArray from ancestor class

    protected array $transcriptionRenderArray;
    protected array $tabArrayTemplate =
    [
        [
            'type' => 'tab',
            'data' => [
                'id' => '', // handled by renderer for matching tabContent
                'label' => 'Transcription'
            ],
        ],
        [
            'type' => 'tab',
            'data' => [
                'id' => '', // handled by renderer for matching tabContent
                'label' => 'Metadata'
            ],
        ]     
    ];

    protected array $tabContentArrayTemplate =
    [
        'type' => 'tabcontent',
        'data' => [
            'id' => '', // handled by renderer for matching up tab
            'tabContentRenderArray' => []
        ]
    ];

    protected array $renderArray = [
        'drsItem' => [
            'type' => 'jwPlayer',
            'data' => [
                'mods' => [], // @todo in this class it goes into tabs
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
                // hardcoding here because, ya know how this process works
                'tabs' => [
                    [
                        'type' => 'tab',
                        'data' => [
                            'id' => '', // handled by renderer for matching tabContent
                            'label' => 'Transcription'
                        ],
                    ],
                    [
                        'type' => 'tab',
                        'data' => [
                            'id' => '', // handled by renderer for matching tabContent
                            'label' => 'Metadata'
                        ],
                    ]
                    // repeat as necessary
                    
                ],
                'tabContent' => [
                    // for transcript, key 0
                    [
                        'type' => 'tabcontent',
                        'data' => [
                            'id' => '', // handled by renderer for matching up tab
                            'tabContentRenderArray' => []
                        ]
                    ],
                    // for metadata, key 1
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

    public function extract(): void {
        // from parent class(es)
        $this->extractContentObjects();
        
        // parent class does this. here, we do it in extractText
        // because we have two+ varieties of text
        // $this->renderArray['drsItem']['data']['mods'] = $this->extractAndReturnModsRenderArray();

        // defined here
        $this->extractText();
        $this->extractMedia();

        // apply what's been extracted to the top-level renderArray
        $this->renderArray['drsText']['data']['tabContent']
            [0]['data']['tabContentRenderArray'] = $this->transcriptionRenderArray;


        $this->renderArray['drsText']['data']['tabContent']
            [1]['data']['tabContentRenderArray'] = $this->modsRenderArray; 
    }    

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
        //$this->renderArray['drsText']['type'] = $mimeType;
        //$this->renderArray['drsText']['data']['fileUrl'] = $fileUrl;

        $this->transcriptionRenderArray = [
            'drsText' => [
                'type' => $mimeType,
                'data' => [
                    'fileUrl' => $fileUrl
                ]
            ]
        ];


        // pass off to ancestor's extractModsData
        $this->extractModsData();
    }

}
