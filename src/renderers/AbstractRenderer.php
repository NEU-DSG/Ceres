<?php

  namespace Ceres\Renderer;

  use Ceres\Exception\CeresException;
  use Ceres\Util\StringUtilities as StrUtil;
  use Ceres\Exception\Data as DataException;
  use Ceres\Exception\Data\UnexpectedData as UnexpectedDataException;

  abstract class AbstractRenderer {

    protected array $rendererOptions = [];

    /**
     * The Ceres_Abstract_Fetcher(s) that are handling the data retrieval. Its itemData property
     * holds the data to work with in most simple cases
     * 
     * Child classes' render() method will tell the Fetchers to, yaknow, fetch data
     * as needed for it to put together the page (or page component).
     * 
     * @var array Ceres_Abstract_Fetcher
     */

    protected array $fetchers = [];
    
    /**
     * The Extractor(s) that will be used to wrangle raw responses from the Fetchers
     * 
     * extract() method on extractors will return just the needed data
     * 
     * @var array Ceres_Abstract_Extractor
     * 
     */

    protected array $extractors = [];

    protected array $coreProperties = [];

    protected array $expectedProperties = [];

    //the data coming from an Extractor to render
    protected array $dataToRender = [];

    protected string $jsonToInject = '';

    public function __construct(array $fetchers = [], array $extractors = [], $rendererOptions = []) {
      
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

      if (! empty($rendererOptions)) {
        $this->setRendererOptions($rendererOptions);
      }
      
    }
/**
 * setDataToRenderFromFile
 *
 * Expects a text file with a serialized php array or json string
 * 
 * @param string $fileName
 * @return void
 */
    public function setDataToRenderFromFile(string $fileName) {
        $this->dataToRender = unserialize(file_get_contents($fileName));
    }

    public function setJsonToInjectFromFile(string $fileName, bool $decodeJson = false) {
        $jsonToRender = file_get_contents($fileName);
        if ($decodeJson) {
            $this->jsonToInject = json_decode($jsonToRender, true);
        } else {
            $this->jsonToInject = $jsonToRender;
        }
        //$this->dataToRender = unserialize(file_get_contents($fileName));
    }

    public function setDataToRender(?string $extractorName) {
      if (is_null($extractorName)) {
          $allExtractors = array_values($this->extractors);
          $extractor = $allExtractors[0];
      } else {
          $extractor = $this->extractors[$extractorName];
      }
      $this->dataToRender = $extractor->getDataToRender();
    }

    /* enqueing will have to figure out how to stuff styles and scripts in early in WP rendering.
    Might have to go elsewhere */
    // @todo move these to WP-specific in an adapter?
    protected function enqueStyles() {

    }

    protected function enqueScripts() {
      
    }
    
    abstract function render();

    abstract function build();

    // @TODO this might get moved into a separate Pagination Renderer, likely different for each Fetcher
    //   First thought is that this'd just instantiate a new Renderer and tell it to do its thing
    //   though that'd also mean injecting the relevant Fetcher into _that_ which might be 
    //   getting crazy
    
    // abstract function buildPagination();



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

    public function getRendererOptionValue($option) {
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

    public function renderMissingData($expectedPropName) {

    }

    function injectFetcher($fetcher, $description = null) {
      
      //for if/when I have multiple fetchers
      $name = StrUtil::createNameIdForInstantiation($fetcher, $description);
      $name = StrUtil::uniquifyName($name, $this->fetchers );
      //$this->fetchers[$name] = $fetcher;


      $this->fetchers[] = $fetcher;
      return $name;
    }

    public function injectExtractor($extractor, $description = null) {
      
      //for if/when I have multiple extractors
      $name = StrUtil::createNameIdForInstantiation($extractor, $description);
      $name = StrUtil::uniquifyName($name, $this->extractors );
      //$this->extractors[$name] = $extractor;

      $this->extractors[] = $extractor;
      return $name;
    }

  }
