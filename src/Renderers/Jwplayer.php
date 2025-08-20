<?php 

namespace Ceres\Renderer;

use Ceres\Data\DataUtilities;

class Jwplayer extends Html {

    protected string $templateFileName = 'jwplayer.html';

    protected array $jwPlayerSetup = 
    [
        'width' => "100%",
        'height' => 400,
        'rtmp' => ['bufferlength' => 5],
        'androidhls' => true,
        'primary' => 'primary',
        'hlshtml' => true,
        'aspectratio' => '16:9',
        'playlist' => [
            'image' => '',
            'sources' => [
                [
                'file' => '',
                'type' => 'video/mp4',
                'default' => true,
                
                ],
            ],
            'tracks' => [
                [
                'file' => '',    
                'label' => 'English',
                'kind' => 'captions',
                'default' => true
                ]
            ]
        ],
    ];


    public function setJwplayerSetup(): void {
        $this->jwPlayerSetup['playlist']['image'] = $this->renderArray['data']['jwPlayerSetup']['imageFile'];
        $this->jwPlayerSetup['playlist']['sources'][0]['file'] = $this->renderArray['data']['jwPlayerSetup']['sourceFile'];
        //$this->jwPlayerSetup['playlist']['sources'][0]['type'] = $this->renderArray['data']['jwPlayerSetup']['sourceFileType'];
        $this->jwPlayerSetup['playlist']['tracks'][0]['file'] = $this->renderArray['data']['jwPlayerSetup']['vttFile'];
    }

    public function getJwplayerSetupAsJson(): string {
        $jsonJwPlayerSetup = "jwPlayerSetup = ";
        $jsonJwPlayerSetup .= stripslashes(json_encode($this->jwPlayerSetup));
        return $jsonJwPlayerSetup;
    }

    public function addScriptTagJson(): void {
        $scriptNode = $this->htmlDom->createElement('script');
        $jsonTextNode = $this->htmlDom->createTextNode($this->getJwplayerSetupAsJson());
        $scriptNode->appendChild($jsonTextNode);
        $this->containerNode->appendChild($scriptNode);
    }

    public function addJwplayerInitJs(): void {
        $jwInitJs = "
        
            document.onreadystatechange = () => {
                console.log(document.readyState);
                if(document.readyState === 'complete') {
                    jwplayerResponse = jwplayer('jwplayer').setup(jwPlayerSetup).setCaptions({'fontSize': 9});
                    console.log(jwplayerResponse);
                }
            };
        ";

        $jwPlayerInitNode = $this->htmlDom->createElement('script');
        $jwPlayerInitNode->$this->htmlDom->createTextNode($jwInitJs);
        $this->containerNode->appendChild($jwPlayerInitNode);
    }

    public function build(): void {
        $this->setJwplayerSetup();
        $this->addScriptTagJson();
    }




    public function old_render(): string {
        
        $jwplayerData = $this->fetcher->parseJwPlayerData($this->resourceId);
        list($plainMediaUrl, $playlistMediaUrl, $type, $imageUrl) = $jwplayerData;
        
        switch ($type) {
        case 'mp3':
            $avProvider = 'sound';
            
            //height below 40 puts jwplayer into audio mode -- no image is shown
            //but the aspect ratio has to be empty, otherwise it overrides and back to video mode
            $playerHeight = '30';
            if ($this->getOption('audioPoster')) {
            $aspectRatio = '16:9';
            } else {
            $aspectRatio = '';
            }
            break;
            
        case 'mp4':
            $avProvider = 'video';
            $aspectRatio = '16:9';
            $playerHeight = '400';
            break;
        }
    
    $playerWidth = $this->getOption('playerWidth', '50%');

    $numericPid = str_replace(":", "-", $this->resourceId);
    $imgId = 'ceres-item-img-' . $numericPid;
    $mediaId = 'ceres-item-media-' . $numericPid;
    
    $html = "<img id='$imgId' src='$imageUrl' class='replace_thumbs'/>";
    $html .= "<div id='$mediaId'></div>";
    
    $scriptHtml = "
      <script type='text/javascript'>
        
      jwplayer.key = '" . JWPLAYER_KEY . "',
      
      jQuery(document).ready(function ($) {
          $('#$imgId').hide();
          jwplayer('$mediaId').setup(
            {
              width: '$playerWidth',
              height: '$playerHeight',
              rtmp: {
                  bufferlength: 5
              },
              image: '$imageUrl',
              provider: '$avProvider',
              androidhls: true,
              primary: 'html5',
              hlshtml: true,
              aspectratio: '$aspectRatio',
              sources:[ {
                  file: '$plainMediaUrl', type: '$type'
              },
              {
                  file: '$playlistMediaUrl'
              }]
            }
          );
          
          jwplayer('$mediaId').on('ready', function () {
                  // Set poster image for video element to avoid black background for audio-only programs.
                  $('$mediaId video').attr('poster', '$imageUrl');
          });
          function errorMessage() {
              $('#$imgId').before('<div>There was a problem playing the media. Refresh the page and try again.</div>');
              $('#$imgId').show();
              $('#$mediaId').hide();
          }
          jwplayer('$mediaId').on('error', function () {
              errorMessage();
          });
          jwplayer('$mediaId').on('setupError', function () {
              errorMessage();
          });
          jwplayer('$mediaId').on('buffer', function () {
              theTimeout = setTimeout(function (e) {
                  errorMessage(e);
              },
              5000);
          });
          jwplayer('$mediaId').on('play', function () {
              clearTimeout(theTimeout);
          });
          $('.replace_thumbs').click(function () {
              jwplayer('$mediaId').play()
          })
      });
      </script>
    ";
    $html .= $scriptHtml;
    return $html;
  }
}
