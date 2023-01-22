<?php 

namespace Ceres\Fetcher;

abstract class AbstractFetcher {

    protected string $endpoint;

    protected object $curlHandler;

    /**
     * The parsed response, including the handling of errors and output message (i.e., not the direct
     * curl response, though that's up for @TODO debate
     * @var array
     */

    protected array $responseData = array();
    
/**
 * expectedSize
 * 
 * either 'single' (0 or 1 results -- basically single item),
 * or 'multiple' (0 or 1+ -- basically search/browse)
 * 
 * A first line of defense for knowing if the results fit expectations
 *
 * @var string
 */
    protected string $expectedSize = 'single';


    /**
     * The number of pages from a large API request. Will depend on the requested items per page,
     * so that's better not changing between requests.
     * 
     * @var integer
     */
    
    protected int $pageCount;
    
    /** 
     * If the API provides the option, the set number of items to return per page. Best not to change this 
     * between requests. Should be set from setQueryParams() or setQueryParam().
     * 
     * @var integer
     */
    
    protected int $perPage = 10;
    
    /**
     * For rolling through multiple requests to the API to gather data, the current page number.
     * Should be set by the fetch*Page() functions.
     * 
     * @var integer
     */
    
    protected int $currentPage;
    


    public function __construct(string $endpoint) {
        $this->endpoint = $endpoint;
    }

    public function setCurlHandler() {
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
    }

    public function fetchPage(int $pageNumber) {

    }
    
    public function getPageUrl(int $pageNumber) {

    }
    
    /**
     * Takes API-specific response to set currentPage, pageCount, and perPage
     * Usually this appears in the response data somewhere, but sometimes
     * needs to use get_headers() when the data is there
     * 
     * @param Array $responseData
     */
    
    public function setPaginationData() {

    }


    /**
     * The params are to to bypass the usual class-based props, e.g. when needing to 
     * query just a snippet that diverges from the 'starting point' of the fetcher,
     * like DRS grabbing content_object data when looping through a search response
     * 
     * @param $url
     * @param boolean $returnWithoutSetting Just send back the data, but don't keep it in the prop
     */

    public function fetchData() {

        $rawResponse = curl_exec($this->curlHandler);
    
        $responseStatus = curl_getinfo($this->curlHandler, CURLINFO_RESPONSE_CODE);
    
        if (! $responseStatus) {
            $responseStatusArray = curl_getinfo($this->curlHandler);
            $responseStatus = $responseStatusArray['http_code'];
        }
      
      
        // shenanigans from https://stackoverflow.com/questions/10384778/curl-request-with-headers-separate-body-a-from-a-header
        // for splitting out just the body from the response
        $header_len = curl_getinfo($this->curlHandler, CURLINFO_HEADER_SIZE);
        $responseBody = substr($rawResponse, $header_len);
        // end shenanigans 
        
        switch ($responseStatus) {
            case 200:
            $statusMessage = 'OK';
            break;
            case 404:
            $responseBody = 'The resource was not found.';
            $statusMessage = 'Not Found';
            break;
            case 302:
            $responseBody = $responseBody;
            $statusMessage = 'The resource has moved or is no longer available';
            break;
            default:
            $responseBody = 'An unknown error occured.' . $responseStatus;
            $statusMessage = 'An unkown error occured. Please try again';
            break;
        }
        $responseData = array(
            'status' => $responseStatus,
            'statusMessage' => $statusMessage,
            // leave it to the instantiated classes to parse the output
            // usually it'll just be json_decode($output, true), but might be XML
            // or something even more funky
            'responseBody' => $responseBody,
        );
        
        $this->responseData = $responseData;
        curl_close($this->curlHandler);
        $this->setPaginationData();
    }
    
    public function hasNextPage() {
      $nextPage = $this->currentPage + 1;
      if ($nextPage > $this->pageCount) {
        return false;
      }
      return true;
    }
    
    public function fetchNextPage() {
        if ($this->hasNextPage()) {
            $nextPage = $this->currentPage + 1;
            $this->fetchPage($nextPage);
        }
    }
    
    public function fetchFirstPage() {
        $this->fetchPage(1);
    }
    
    public function fetchLastPage() {
        $lastPage = $this->pageCount - 1;
        $this->fetchPage($lastPage);
    }

    public function getResponseData() {
        return $this->responseData;
    }

    public function getPageCount() {
        return $this->pageCount;
    }
}
