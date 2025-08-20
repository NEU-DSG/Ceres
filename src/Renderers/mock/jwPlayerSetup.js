jwplayer("drs-item-video-neu-m039sg68p").setup(
    {width: "100%",
    height: 400,
    rtmp: {bufferlength: 5},
    image: "https://repository.library.northeastern.edu/downloads/neu:m039sg70q?datastream_id=thumbnail_4",
    provider: "video",
    androidhls: "true",
    primary: primary,
    hlshtml: "true",
    aspectratio: "16:9",
    sources:
    [   {file: "https://repository.library.northeastern.edu/wowza/neu:m039sg68p/plain", 
        type:"mp4"
    },
        { file: "https://repository.library.northeastern.edu/wowza/neu:m039sg68p/playlist.m3u8"}
    ],
    tracks: [{
    file: "https://repository.library.northeastern.edu/downloads/neu:h989s296d?datastream_id=content",
    label: 'English',
    kind: 'captions',
    "default": true
    }]
});