<?php
namespace Ceres\Util;

use Ceres\Exception;
use Ceres\Config;


class DataUtilities {

    protected static $allOptions = [];
    protected static $optionValues = [];
    protected static $viewPackages = [];
    protected static $optionsEnums = [];
    protected static $propertyLabels =  [];

    // $scope is ceres, {project_name}, {view_package_name}
    static function valueForOption($optionName, $scope = 'ceres') {
        self::setData();
        if(isset(self::$optionValues[$optionName])) {
            $optionValues = self::$optionValues[$optionName];
            if (!empty($optionValues['currentValue'])) {
                return $optionValues['currentValue'];
            }

            if (!empty($scope)) {
                return $optionValues['defaults'][$scope];
            }

            // no precision to the scope value wanted, so
            // bubble up the hierarchy of default values

            $viewPackageName = ''; //@todo: dig this up
            $projectName = ''; // @todo dig this up

            // @todo this could be handled w/out the multiple ifs somehow
            // to maintain the hierarchy in a more versatile way
            if (!empty($optionValues['defaults'][$viewPackageName])
                && !empty($viewPackageName)
            ) {
                return $optionValues['defaults'][$viewPackageName];
            }

            if (!empty($optionValues['defaults'][$projectName])
                && !empty($projectName)
            ) {
                return $optionValues['defaults'][$projectName];
            }    

            if (!empty($optionValues['defaults']['ceres'])) {
                return $optionValues['defaults']['ceres'];
            }

            // return false or throw a Ceres\Exception
        }
    }

    static function defaultsForOption($optionName, $scope='ceres') {
        self::setData();

        return self::$optionValues[$optionName]['defaults'][$scope];
    }

    static function enumValuesForProperty($property, $scope = 'ceres') {

    }
    static function labelForProperty($property, $scope='ceres') {
        // @todo: mods: first, see if @displayLabel is set in Extractors

        // @todo: wikidata can be built into the query, but still needs
        //a fallback if rdfs:label isn't present
        // wikidata SERVICE:label should be built into SPARQL query

        //ECDA and Thoreau make use of mods:@displayLabel
        //so I need a way to bail out to that, based on whether
        //a project does it's own thing
        // do that in the DataUtil::labelForProperty
        self::setData();
        if (isset(self::$propertyLabels[$scope][$property])) {
            $label = self::$propertyLabels[$scope][$property];
        } else {
            // @todo fallback label and/or Exception
        }

        if(empty($label)) {
            return null; // actually have a fallback and/or exception
        }
        return $label;
    }

    static function userHasAccess($user, $optionName) {
        self::setData();
        $userRole = ''; //@todo: dig this up, or have wp something something something
        if (in_array($userRole, self::$allOptions[$optionName]['access'])) {
            return true;
        }

        return false; // or throw something?

    }

    static function getOption(string $optionName) {
        if (function_exists('get_option')) {
            return get_option($optionName);
        } else {
            //save it all to a file in dev for now
            if ($optionName == 'drstk_collection') {
                return 'https://drs/collectionId';
            }
            $optionData = [];
            return $optionData;
        }
    }

    static function updateOption(string $optionName, array $optionData) {
        if (function_exists('update_option')) {
            update_option($optionName, $optionData);
        } else {
//save it all to a file in dev for now
        }
    }

/**
 * for use to compare option names, vp names, etc to make
 * sure they are unique when set elsewhere
 * 
 */

    static function setData() {
        // todo: an environment variable for wp, dev, etc
//for real WP integration
        // self::$viewTemplates = get_option('ceres_view_templates');
        // self::$allOptions = get_option('ceres_all_options');
        // self::$optionValues = get_option('ceres_option_values');

//for dev/testing
        self::$viewPackages = Config\getViewPackages();
        self::$allOptions = Config\getAllOptions();
        self::$optionValues = Config\getOptionsValues();
        self::$propertyLabels = Config\getPropertyLabels();
        self::$optionsEnums = Config\getOptionsEnums();
    }

}
