<?php

  namespace Ceres\Renderer;

  use Ceres\Exception\CeresException;
  use Ceres\Util\StringUtilities as StrUtil;
  use Ceres\Exception\Data as DataException;
  use Ceres\Exception\Data\UnexpectedData as UnexpectedDataException;

  abstract class AbstractRenderer {

    protected $rendererOptions = array();

    /**
     * The Ceres_Abstract_Fetcher(s) that are handling the data retrieval. Its itemData property
     * holds the data to work with in most simple cases
     * 
     * Child classes' render() method will tell the Fetchers to, yaknow, fetch data
     * as needed for it to put together the page (or page component).
     * 
     * @var array Ceres_Abstract_Fetcher
     */

    protected $fetchers = array();
    
    /**
     * The Extractor(s) that will be used to wrangle raw responses from the Fetchers
     * 
     * extract() method on extractors will return just the needed data
     * 
     * @var array Ceres_Abstract_Extractor
     * 
     */

    protected $extractors = [];

    protected $coreProperties = [];

    protected $expectedProperties = [];

    //the data coming from an Extractor to render
    protected array $dataToRender = [];

    public function __construct(array $fetchers = [], array $extractors = [], $renderOptions = []) {
      
      foreach ($fetchers as $classObj) {
        if (! is_a($classObj, 'Fetcher')) {
          throw new CeresException("not a fetcher");
        }
        $this->injectFetcher($classObj);
      }

      foreach ($extractors as $classObj) {
        if (! is_a($classObj, 'Extractor')) {
          throw new CeresException("not an extractor");
        }
        $this->injectExtractor($classObj);
      }

      $this->setRendererOptions($renderOptions);
    }

    public function setDataToRender() {
      foreach ($this->extractors as $extractorName=>$extractor ) {
          $this->dataToRender[$extractorName] = $extractor->getDataToRender();
      }
  }

    /* enqueing will have to figure out how to stuff styles and scripts in early in WP rendering.
    Might have to go elsewhere */

    protected function enqueStyles() {

    }

    protected function enqueScripts() {
      
    }
    
    abstract function render();
    
      /*
        foreach ($this->extractors as $name=>$extractor) {
          fire up extractor(s) to get what's needed
        }



      */

    // @TODO this might get moved into a separate Pagination Renderer, likely different for each Fetcher
    //   First thought is that this'd just instantiate a new Renderer and tell it to do its thing
    //   though that'd also mean injecting the relevant Fetcher into _that_ which might be 
    //   getting crazy
    
    // abstract function buildPagination();

    // @todo move to utils?
    public function linkify($linkData) {
      $label = $linkData['label'];
      $url = $linkData['url'];

      // @todo What to do about other <a> atts? a closure or lambda?
      return "<a href='$url'>$label</a>";
    }

    public function setRendererOptions(array $options) {
      $this->rendererOptions = $options;
    }

    /**
     * Returns the entire options array
     * 
     * @return array
     */

    public function getRendererOptions() {
      return $this->rendererOptions;
    }

    /**
     * Set or unset an option value. Not passing a value unsets the option.
     * 
     * @param string $option
     * @param string $value
     */

    public function setRendererOptionValue($option, $value = '') {
      if ($value == '') {
        unset($this->rendererOptions[$option]);
      } else {
        $this->rendererOptions[$option] = $value;
      }
    }

    public function getRenderOptionValue($option) {

    }

    public function getRendererOption($option) {
      if (isset($this->rendererOptions[$option])) {
        return $this->rendererOptions[$option];
      }
      // throw something
    }
    
    public function setFetcherOptionsValues(string $fetcherName, array $optionValues) {


    }

    public function setExtractorOptionsValues(string $extractorName, array $optionValues) {

      
    }

    public function setFetcherOptionValue(string $fetcherName, $optionName, $optionValue) {


    }

    public function setExtractorOptionValue(string $extractorName, $optionName, $optionValue) {


    }

    public function getDefaultPropertyValue(array $propValData) {

    }

    public function renderMissingData($expectedPropName) {

    }

    protected function injectFetcher($fetcher, $description = null) {
      $name = StrUtil::createNameIdForInstantiation($fetcher, $description);
      $name = StrUtil::uniquifyName($name, $this->fetchers );
      $this->fetchers[$name] = $fetcher;
    }

    protected function injectExtractor($extractor, $description = null) {
      $name = StrUtil::createNameIdForInstantiation($extractor, $description);
      $name = StrUtil::uniquifyName($name, $this->extractors );
      $this->extractors[$name] = $extractor;
    }
  }
