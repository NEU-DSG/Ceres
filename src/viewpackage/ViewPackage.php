<?php

namespace Ceres\ViewPackage;

use Ceres\Exception\CeresException;
use Ceres\Util\StringUtilities as StrUtil;
use Ceres\Util\DataUtilities as DataUtil;
use Ceres\Config;

class ViewPackage {

    protected $nameId;
    protected $humanName;
    protected $description;
    protected $parentViewPackage;
    protected $projectName;
    protected $currentViewPackageData = [];
    private   $allViewPackagesData = [];

    public function __construct() {
        //@todo: generalize this for different envs
        $this->allViewPackagesData = \Ceres\Config\getViewPackages();
    }


    public function setNameId($humanName) {
        $snakeCasedName = StrUtil::languageToSnakeCase($humanName);
        $existingViewPackageNames = array_keys(self::$allViewPackagesData);
        $nameId = StrUtil::uniquifyName($snakeCasedName, $existingViewPackageNames);
        $this->nameId = $nameId;
    }

    public function setProjectName() {
        //$siteUrl = get_option('siteurl');
        $siteUrl = DataUtil::getWpOption(('siteurl'));
        $siteName = preg_replace("(^https?://)", "", $siteUrl);
        $this->projectName = $siteName;
    }

    /**
     * 
     * filters specific options (e.g., tabular) out
     * of general options
     *
     * @param array $options
     * @return void
     */

    public function filterGeneralOptionsByScope($options) {
        foreach( $options as $scope => $suboptions) {
            // $scope is 'general','tabular' etc for grouping inputs
            if ($scope != 'general') {
                $scopeKeys = array_keys($options[$scope]);
                foreach ($scopeKeys as $key) {
                    if(array_key_exists($key, $options['general'])) {
                        unset($options['general'][$key]);
                    }
                }
            }
        }
        return $options;
    }

    /**
     * loadOptions
     * 
     * reads the data for the vp from the wp_options
     * Sets current values, including overrides
     *
     * @return void
     */
    public function load($nameId) {
        $this->currentViewPackageData = $this->allViewPackagesData[$nameId];
        $rendererData = $this->currentViewPackageData['renderer'];
        $rendererOptions = [];
        foreach ($rendererData as $rendererName => $rendererData) {
            $renderOptions[] = $rendererData['options'];
        }
        foreach ($renderOptions as $optionName) {
            $rendererOptions[$optionName] = DataUtil::valueForOption($optionName, $this->nameId);
        }
    }

/**
 * 
 * For data created by content creator to override the defaults,
 * and the $currentValue
 * 
 * Need currentValues loaded first in order to override them
 */

    function overrideOptionValue($value, $optionArray) {

    }

    function userOptionAccess($user, $option) {
        $userCeresRole = $user->getCeresRole(); //totally fake, need to figure this out
        if(in_array($userCeresRole, $option['access'])) {
            return true;
        }
        return false;
    }

    public function export($includeValues) {
        // toArray() -> addValues
    }

    public function clone(bool $includeValues = false, bool $save = true) {
        // toArray() -> new VP 
        // append something to human name
        // prepend something to description

        $vpArray = [];
        $newViewPackage = new ViewPackage;
        if ($save) {
            $newViewPackage->save();
        } else {
            return $vpArray;
        }
        // save()
    }

    public function save() {
        $vpArray = $this->toArray();
        $vpArray = [];
        $allViewPackages = DataUtil::getWpOption('ceres_view_packages');
        $allViewPackages[] = $vpArray;
        //update_option('ceres_view_packages', $allViewPackages);
        DataUtil::updateWpOption('ceres_view_packages', $allViewPackages);
    }

    /**
     * toArray
     *
     * recreate an export/importable array of all the settings
     * @return array
     */
    public function toArray() {
        //mimic/ recreate the dev template
        // what does PHP native to array do?
        // or just serialize in its current state?

    }
}

