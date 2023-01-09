<?php
namespace Ceres\Config;


function getAllOptions() {
    $ceresAllOptions = [
        'altLabelProp' => [
            'label'   => '',
            'desc'    => '',
            'access' => ['projectOwner', 'coder'],
            'type'    => 'varchar',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'renderers', 
        ],
        'imageWrap' => [
            'label'   => 'Image Wrap',
            'desc'    => 'How to wrap text around images',
            'access' => ['contentCreator', 'projectOwner', 'coder'],
            'type'    => 'enum',
            'defaults' => 'from other array',
            'notes' => '',
            'appliesTo' => 'renderers', 
        ],
    
        'extractorMetadataFilterBy' => [
            'label'   => 'Filter Metadata By',
            'desc'    => 'A property in the metadata used to filter metadata results for display',
            'access' => ['coder'],
            'type'    => 'varchar',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'extractors',
        ],
    
        
        'extractorResourcesFilterBy' => [
            'label'   => 'Filter Resources By',
            'desc'    => 'A property in the metadata used to filter search results',
            'access' => ['coder'],
            'type'    => 'varchar',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'extractors', 
             
        ],
        'extractorMetadataSortBy' => [
            'label'   => 'Sort By Metadata',
            'desc'    => 'How to sort metadata fields for display',
            'access' => ['coder'],
            'type'    => 'varchar',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'extractors', 
            
        ],
        'extractorResourcesSortBy' => [
            'label'   => 'Sort resources by',
            'desc'    => 'The property to use for sorting results',
            'access' => ['coder'],
            'type'    => 'varchar',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'extractors',
            
        ],
        'extractorMetadataSortOrder' => [
            'label'   => 'Metadata sort order',
            'desc'    => 'The order to sort metadata by, e.g. asc or desc',
            'access' => ['coder'],
            'type'    => 'enum',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'extractors',  
            
        ],
        'extractorResourcesSortOrder' => [
            'label'   => 'Resources Sort Order',
            'desc'    => 'The order to sort results by, e.g. asc or desc',
            'access' => ['coder'],
            'type'    => 'enum',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'extractors', 
            
        ],
    
        // @todo: remove this for extractor?
        'extractorMetadataSortByProperty' => [
            'label'   => 'Sort Metadata By Property',
            'desc'    => 'The metadata property to use for... ',
            'access' => ['coder'],
            'type'    => 'varchar',
            'defaults' => 'from other array',
            'notes' => 'Maybe remove this for Extractors', 
            'appliesTo' => 'extractors', 
            
        ],
        'extractorResourcesSortByProperty' => [
            'label'   => 'Sort Resources By Property',
            'desc'    => 'Property to use when sorting results',
            'access' => ['coder'],
            'type'    => 'varchar',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'extractors', 
            
        ],
        // @todo: do I need this?
        'extractorGroupBy' => [
            'label'   => 'Group By',
            'desc'    => 'Property to use for grouping ',
            'access' => ['projectOwner', 'coder'],
            'type'    => 'varchar',
            'defaults' => 'from other array',
            'notes' => 'Needed?', 
            'appliesTo' => 'extractors', 
            
        ],
        'extractorMetadataToShow' => [
            'label'   => 'Metadata To Show',
            'desc'    => 'The specific metadata properties to display',
            'access' => ['contentCreator', 'projectOwner', 'coder'],
            'type'    => 'enum',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'extractors', 
            
        ],
        'fetcherMetadataToShow' => [
            'label'   => 'Metadata To Show',
            'desc'    => 'The specific metadata properties to display',
            'access' => ['contentCreator', 'projectOwner', 'coder'],
            'type'    => 'enum',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'fetchers', 
            
        ],
        'fetcherGroupBy' => [
            'label'   => 'Group by',
            'desc'    => 'Property to use for grouping results',
            'access' => ['contentCreator', 'projectOwner', 'coder'],
            'type'    => 'varchar',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'fetchers', 
             
        ],
        'fetcherFilterBy' => [
            'label'   => 'Filter by',
            'desc'    => 'Property to use for filtering results',
            'access' => ['projectOwner', 'coder'],
            'type'    => 'varchar',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'fetchers', 
             
        ],
        'fetcherSortBy' => [
            'label'   => 'Sort by',
            'desc'    => 'Property to use for sorting results',
            'access' => ['projectOwner', 'coder'],
            'type'    => 'varchar',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'fetchers', 
            
        ],
        'fetcherSortOrder' => [
            'label'   => 'Sort order',
            'desc'    => 'The order with which to sort results',
            'access' => ['projectOwner', 'coder'],
            'type'    => 'varchar',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'fetchers', 
            
        ],
        'fetcherSortByProperty' => [
            'label'   => 'Sort by property',
            'desc'    => 'The property to use for sorting results',
            'access' => ['projectOwner', 'coder'],
            'type'    => 'varchar',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'fetchers', 
            
        ],
        'resourceLinkProp' => [
            'label'   => 'Resource Link Property',
            'desc'    => 'The property to use as the link back to the original resource',
            'access' => ['projectOwner', 'coder'],
            'type'    => 'varchar',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'fetchers', 
            
        ],
        'mediaLinkProp' => [
            'label'   => 'Media Link Property',
            'desc'    => 'The property to use as the link back to the original media',
            'access' => ['projectOwner', 'coder'],
            'type'    => 'varchar',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'fetchers', 
            
        ],
        'mediaUriProp' => [
            'label'   => 'Media URI Property',
            'desc'    => 'The URI to use for displaying media',
            'access' => ['projectOwner', 'coder'],
            'type'    => 'varchar',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'fetchers', 
            
        ],
        'thClassName' => [
            'label'   => 'Table Head Class Name',
            'desc'    => 'The CSS class to apply to &lt;th> elements',
            'access' => ['projectOwner', 'coder'],
            'type'    => 'varchar',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'renderers', 
            
        ],
        'tdClassName' => [
            'label'   => 'Table Data Class Name',
            'desc'    => 'The CSS class to apply to &lt;td> elements',
            'access' => ['projectOwner', 'coder'],
            'type'    => 'varchar',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'renderers', 
            
        ],
    
        'getAll' => [
            'label'   => 'Get All',
            'desc'    => 'Whether to get all resources matching the query, or force pagination of the queries for rolling loads',
            'access' => ['coder'],
            'type'    => 'bool',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'fetchers', 
            
        ],
        'responseFormat' => [
            'label'   => 'Response Format',
            'desc'    => 'The data format the API should return',
            'access' => ['coder'],
            'type'    => 'varchar',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'fetchers', 
            
        ],
        'perPage' => [
            'label'   => 'Per Page',
            'desc'    => 'The number of results for each page returned by the API',
            'access' => ['coder'],
            'type'    => 'int',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'fetchers', 
            
        ],
        'startPage' => [
            'label'   => 'Start Page',
            'desc'    => 'The start page of results from the API',
            'access' => ['coder'],
            'type'    => 'int',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'fetchers', 
            
        ],
        'resourceIds' => [
            'label'   => 'Resource Ids',
            'desc'    => 'The resource ids to return',
            'access' => ['contentCreator', 'projectOwner', 'coder'],
            'type'    => 'varchar',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'fetchers', 
            
        ],
        'query' => [
            'label'   => 'Query',
            'desc'    => 'The full query to send to the API',
            'access' => ['coder'],
            'type'    => 'text',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'fetchers', 
            
        ],
    
        'endpoint' => [
            'label'   => 'Endpoint',
            'desc'    => 'The API endpoint URI',
            'access' => ['coder'],
            'type'    => 'varchar',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'fetchers', 
            
        ],
        'searchType' => [
            'label'   => 'Search Type',
            'desc'    => 'The type of search to use for the specific API, e.g. search vs item in DRS',
            'access'  => ['coder'],
            'type'    => 'varchar',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'fetchers',
        ],
        'thumbnailSize' => [
            'label'   => 'Thumbnail Size',
            'desc'    => 'The size of the thumbnail to use',
            'access' => ['contentCreator', 'projectOwner', 'coder'],
            'type'    => 'varchar',
            'defaults' => 'from other array',
            'notes' => 'This will vary based on API result structure',
            'appliesTo' => 'renderers', 
            
        ],
        'separator' => [
            'label'   => 'Separator',
            'desc'    => 'The separator character to use for key/value pairs',
            'access' => ['projectOwner', 'coder'],
            'type'    => 'varchar',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'renderers', 
            
        ],
        'keyClass' => [
            'label'   => 'Key Class',
            'desc'    => 'A CSS class to apply to keys in rendering arrays',
            'access' => ['projectOwner', 'coder'],
            'type'    => 'varchar',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'renderers', 
            
        ],
        'valueClass' => [
            'label'   => 'Value Class',
            'desc'    => 'A CSS class to apply to values in rendering arrays',
            'access' => ['projectOwner', 'coder'],
            'type'    => '',
            'defaults' => 'from other array',
            'notes' => "",
            'appliesTo' => 'renderers', 
            
        ],
        'leafletCeres' => [
            'label'   => 'Leaflet CERES',
            'desc'    => '',
            'access' => ['contentCreator', 'projectOwner', 'coder'],
            'type'    => '',
            'defaults' => 'from other array',
            'notes' => 'need to break this out', 
            'appliesTo' => 'renderers', 
            
        ],
        //passthroughs to Leaflet
        'leafletNative' =>[
            'label'   => '',
            'desc'    => '',
            'access' => ['coder'],
            'type'    => '',
            'defaults' => 'from other array',
            'notes' => 'need to break this out? probably not if access remains limited to coders', 
            'appliesTo' => 'renderers', 
        ],
    
    ];
    return $ceresAllOptions;
}

// 'extractorMetadataFilterBy' => [
//     'currentValue' => null,
//     'defaults' => [
//         'ceres' => '',
//         'projectName' => '',
//         'viewPackageName' => '',
//     ]
// ],
// ],


function getOptionsValues() {
    $ceresOptionsValues = [
        'altLabelProp' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'resourceLinkProp' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'searchType' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'extractorMetadataFilterBy' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'imageWrap' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'extractorMetadataToShow' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
                ]
            ],
        

        'thumbnailSize' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'extractorResourcesFilterBy' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'extractorMetadataSortBy' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'extractorResourcesSortBy' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'extractorMetadataSortOrder' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'extractorResourcesSortOrder' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'extractorMetadataSortByProperty' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'extractorResourcesSortByProperty' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'extractorGroupBy' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'itemLinkProp' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'mediaLinkProp' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'mediaUriProp' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'thClassName' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'tdClassName' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'endpoint' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'fetcherMetadataToShow' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'getAll' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'responseFormat' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'perPage' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'startPage' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'resourceIds' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'query' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'fetcherGroupBy' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ], 
        'fetcherFilterBy' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'fetcherSortBy' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'fetcherSortOrder' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'fetcherSortByProperty' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'separator' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'keyClass' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        'valueClass' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        //settings in the surrounding HTML
        'leafletCeres' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],
        //passthroughs to Leaflet
        'leafletNative' => [
            'currentValue' => null,
            'defaults' => [
                'ceres' => '',
                'projectName' => '',
                'viewPackageName' => '',
            ]
        ],

    ]; 

    return $ceresOptionsValues;
}

function getViewPackages() {
    /**
     * 
     * sets up the templates for various definitions of a
     * view package. No values are set here -- it is a template
     * for view packages to know what to display
     * permissions by ceresRole and default and set values
     * appear elsewhere
     * 
     */



    /**
     * 
     * for building up  view packages. template, not set values
     * 
     */

    $extractorOptions = [
        'general' => [
            'extractorMetadataFilterBy',
            'extractorResourcesFilterBy',
            'extractorMetadataSortBy',
            'extractorResourcesSortBy',
            'extractorMetadataSortOrder',
            'extractorResourcesSortOrder',
            'extractorMetadataSortByProperty',
            'extractorResourcesSortByProperty',
            'extractorGroupBy',
            'itemLinkProp',
            'mediaLinkProp',
            'mediaUriProp',

        ],
        'tabular' => [
            'thClassName',
            'tdClassName',
        ]
    ];


    /**
     * 
     * for building up view packages. template, not set values
     */


    $fetcherOptions = [
        'general' => [
            'endpoint',
            'fetcherMetadataToShow',
            'getAll',
            'responseFormat',
            'perPage',
            'startPage',
            'resourceIds',
            'query',
            'fetcherGroupBy', 
            'fetcherFilterBy',
            'fetcherSortBy',
            'fetcherSortOrder',
            'fetcherSortByProperty',
        ],
        'wdqs' => [
            'endpoint',
            'responseFormat',

        ],
        'drs' => [
            'endpoint',
            'type',
            'thumbnailSize',

        ]


    ];


    /**
     * 
     * for building up  view packages. template, not set values
     */


    $rendererOptions = [
        'general' => [
            'imageWrap',
            'metadataToShow',
            'altLabelProp',
            'thClass',
        ],

        'tabular' => [
            'thClass',
            'tdClass',
            'trClass',
        ],

        'keyValue' => [
            'separator',
            'keyClass',
            'valueClass',
        ],
        //settings in the surrounding HTML
        'leafletCeres',
        //passthroughs to Leaflet
        'leafletNative',

        
    ];


    $ceresViewPackages = [
        "tabular_wikidata_for_short_metadata" =>
                [
                'humanName' => "Tabular Wikidata For Short Metadata",
                'description' => "Description",
                'parentViewPackage' => null,
                'projectName' => null,
                'renderer' => [
                        'Tabular' => [
                            'fullClassName' => 'Ceres\Renderer\Tabular',
                            'options' => [  //redundant, yes. but helps keep the same patter with fetchers and extractors
                                array_merge(
                                    $rendererOptions['general'],
                                    $rendererOptions['tabular']
                                )
                                //after deduping options in the merge,
                                // stuff in the current values
                            ]
                    ],
                ],

                'fetchers' => 
                    [
                        'Wdqs' => [
                            'fullClassName' => 'Ceres\Fetcher\Wdqs',
                            'options' => array_merge(
                                $fetcherOptions['general'],
                                $fetcherOptions['wdqs']),
                        ]
                    ],
                    
                'extractors' =>
                    [
                        'WdqsToTabular' => [
                            'fullClassName' => 'Ceres\Extractor\WdqsToTabular',
                            'options' => array_merge(
                                $extractorOptions['general'], 
                                $extractorOptions['tabular']),
                            ],
                    ],
                ],
        "leaflet_wikidata_for_public_art_map" =>
            [
                'humanName' => "Leaflet Wikidata for Public Art Map",
                'description' => "Description",
                'parentViewPackage' => null,
                'projectName' => null,
                'renderer' => [
                        'LeafletMap' => [
                            'fullClassName' => 'Ceres\Renderer\LeafletMap',
                            'options' => [  //redundant, yes. but helps keep the same patter with fetchers and extractors
                                array_merge(
                                    $rendererOptions['general'],
                                    $rendererOptions['tabular']
                                )
                                //after deduping options in the merge,
                                // stuff in the current values
                            ]
                        ]
                    ],
        
                'fetchers' => 
                    [
                        'Wdqs' => [
                            'fullClassName' => 'Ceres\Fetcher\Wdqs',
                            'options' => array_merge(
                                $fetcherOptions['general'],
                                $fetcherOptions['wdqs']),
                        ]
                    ],
                    
                'extractors' =>
                    [
                        'WdqsToLeafletMap' => [
                            'fullClassName' => 'Ceres\Extractor\WdqsToLeafletMap',
                            'options' => array_merge(
                                $extractorOptions['general'], 
                               // $extractorOptions['leaflet']
                            ),
                            ],
                    ],
                ],
        "html_dev_test" =>
        [
            'humanName' => "Html Dev Test",
            'description' => "Description",
            'parentViewPackage' => null,
            'projectName' => null,
            'renderer' => [
                    'Html' => [
                        'fullClassName' => 'Ceres\Renderer\Html',
                        'options' => [  //redundant, yes. but helps keep the same patter with fetchers and extractors
                            array_merge(
                                $rendererOptions['general'],
                                $rendererOptions['tabular']
                            )
                            //after deduping options in the merge,
                            // stuff in the current values
                        ]
                    ]

                ],
    
            'fetchers' => 
                [
                ],
                
            'extractors' =>
                [
                ],
            ],

        "tabular_dev_test" =>
        [
            'humanName' => "Tabular Dev Test",
            'description' => "Description",
            'parentViewPackage' => null,
            'projectName' => null,
            'renderer' => [
                    'Tabular' => [
                        'fullClassName' => 'Ceres\Renderer\Tabular',
                        'options' => [  //redundant, yes. but helps keep the same patter with fetchers and extractors
                            array_merge(
                                $rendererOptions['general'],
                                $rendererOptions['tabular']
                            )
                            //after deduping options in the merge,
                            // stuff in the current values
                        ]
                    ]
                ],
    
            'fetchers' => 
                [
                ],
                
            'extractors' =>
                [
                ],
            ],

        "leafletmap_dev_test" =>
        [
            'humanName' => "LeafletMap Dev Test",
            'description' => "Description",
            'parentViewPackage' => null,
            'projectName' => null,
            'renderer' => [
                    'LeafletMap' => [
                        'fullClassName' => 'Ceres\Renderer\LeafletMap',
                        'options' => [  //redundant, yes. but helps keep the same patter with fetchers and extractors
                            array_merge(
                                $rendererOptions['general'],
                                $rendererOptions['tabular']
                            )
                            //after deduping options in the merge,
                            // stuff in the current values
                        ]
                    ]
                ],
    
            'fetchers' => 
                [
                ],
                
            'extractors' =>
                [
                ],
            ],
        "tabular_wdqs_test" => 
        [
            'humanName' => "Tabular Wdqs Test",
            'description' => "Description",
            'parentViewPackage' => null,
            'projectName' => null,
            'renderer' => 
                [
                    'Tabular' => 
                        [
                        'fullClassName' => 'Ceres\Renderer\Tabular',
                        'options' => [  //redundant, yes. but helps keep the same patter with fetchers and extractors
                            array_merge(
                                $rendererOptions['general'],
                                $rendererOptions['tabular']
                            )
                            //after deduping options in the merge,
                            // stuff in the current values
                        ]
                    ],
            ],
    
            'fetchers' => 
                [
                    'Wdqs' => [
                        'fullClassName' => 'Ceres\Fetcher\Wdqs',
                        'options' => array_merge(
                            $fetcherOptions['general'],
                            $fetcherOptions['wdqs']),
                    ]
                ],
                
            'extractors' =>
                [
                ],
            ],
        "tabular_drs_test" =>
        [
            'humanName' => "Tabular Drs Test",
            'description' => "Description",
            'parentViewPackage' => null,
            'projectName' => null,
            'renderer' => [
                    'Tabular' => [
                        'fullClassName' => 'Ceres\Renderer\Tabular',
                        'options' => [  //redundant, yes. but helps keep the same patter with fetchers and extractors
                            array_merge(
                                $rendererOptions['general'],
                                $rendererOptions['tabular']
                            )
                            //after deduping options in the merge,
                            // stuff in the current values
                        ]
                    ]
                ],
    
            'fetchers' => 
                [
                    'Drs' => [
                        'fullClassName' => 'Ceres\Fetcher\Drs',
                        'options' => array_merge(
                            $fetcherOptions['general'],
                            $fetcherOptions['wdqs']),
                    ]
                ],
                
            'extractors' =>
                [
                    'DrsToTabular' => [
                        'fullClassName' => 'Ceres\Extractor\DrsToTabular',
                        'options' => array_merge(
                            $extractorOptions['general'], 
                        //    $extractorOptions['leaflet']
                        ),
                        ],
                ],
            ],

        //"another_view_package" => [],
         
    ];


    return $ceresViewPackages;
}

function getOptionsEnums() {
    $optionsEnums = [
        'imageWrap' => [
            'ceres' => ['left', 'center', 'right'],
            '$projectName' => [],
        ],
        'thumbnailSize' => [
            'ceres' => ['extra small', 'small', 'medium', 'large', 'extra large'],
        ],
        'extractorMetadataSortOrder' => [

        ],
        'extractorResourcesSortOrder' => [

        ],
        'extractorMetadataToShow' => [

        ],
        'fetcherMetadataToShow' => [

        ],


    ];
}

function getPropertyLabels() {
    $propertyLabels = [
        'ceres' => [
            'dcterms:title' => 'Title',
            'dcterms:subject' => 'Subject(s)',
            //etc
    
            // @todo: mods: first, see if @displayLabel is set in Extractors
            'mods:' => '',
    
            'darwincore:' => '',
    
            // @todo: wikidata can be built into the query, but still needs
            //a fallback if rdfs:label isn't present

        ],
        '$projectName' => []
            //ECDA and Thoreau make use of mods:@displayLabel
            //so I need a way to bail out to that, based on whether
            //a project does it's own thing

            // do that in the DataUtil::labelForProperty
        ,
        '$ecda' => [],

    ];

    return $propertyLabels;

}
