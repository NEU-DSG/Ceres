<?php

namespace Ceres\Fetcher;


class Rest extends AbstractFetcher {


    /**
     * refers to additional URL path options, generally for a RESTful API pattern
     * @var array
     */

    protected array $queryOptions = [];

    /**
     * The ID of the remote resource (DRS pid, DPLA hash id, etc)
     * @var string
     */

    protected $resourceId;
    
    /**
     * GET params to tack on to the $endpoint + $queryOptions path
     * @var array
     */

    protected $queryParams = array();




    public function __construct(array $queryOptions = array(), array $queryParams = array(), $resourceId = null ) {
        $this->setQueryParams($queryParams);
        $this->setQueryOptions($queryOptions);
        $this->setResourceId($resourceId);
    }
    
    // abstract override
    public function buildQuery($queryOptions = false, $queryParams = false) {
    }

    public function setPaginationData() {
    }

    public function getItemDataById($itemId) {
    }

    public function parseItemsData()
    {
        
    }

    public function detectResponseFormat() {}

    public function fetchPage(int $pageNumber) {
    }

    public function getPageUrl(int $pageNumber) {
    }
    // end abstract override

    public function getQueryParams() {
        return $this->queryParams;
    }

    public function setQueryParam($param, $value = null ) {
        if (is_null(($value))) {
            unset($this->queryParams[$param]);
        } else {
        $this->queryParams[$param] = $value;
        }
    }

    public function getQueryParam($param) {
        return $this->queryParams[$param];
    }

    public function setQueryOptions(array $queryOptions) {
        $this->queryOptions = $queryOptions;
    }

    public function getQueryOptions() {
        return $this->queryOptions;
    }

    public function setQueryOptionValue($option, $value = null) {
        if (is_null($value)) {
            unset($this->queryOptions[$option]);
        } else {
        $this->queryOptions[$option] = $value;
        }
    }

    public function getQueryOption($option) {
        return $this->queryOptions[$option];
    }

    public function setResourceId($resourceId) {
        $this->resourceId = $resourceId;
    }

    public function getResourceId() {
        return $this->resourceId;
    }

}


