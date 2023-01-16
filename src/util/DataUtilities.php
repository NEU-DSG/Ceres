<?php
namespace Ceres\Util;

use Ceres\Exception\DataException;
use Ceres\Data;


class DataUtilities {

    protected static $allOptions = [];
    protected static $optionsValues = [];
    protected static $viewPackages = [];
    protected static $optionsEnums = [];
    protected static $propertyLabels =  [];

    /**
     * Looks at GET params for overrides coming from 
     * content creator
     * Or parse from shortcode options
     */

    static function overrideForOption($optionName) {
        if (isset($_GET[$optionName])) {
            return $_GET[$optionName];
        }
        return null;
    }


    // $scope is ceres, {project_name}, {view_package_name}
    static function valueForOption($optionName, $scope = 'ceres') {
        self::setData();
        if(isset(self::$optionsValues[$optionName])) {
            $optionValues = self::$optionsValues[$optionName];

            // first, check if content creator has set an override
            $overrideValue = self::overrideForOption($optionName);
            if (!is_null($overrideValue)) {
                return $overrideValue;
            }
            if (!empty($optionValues['currentValue'])) {
                return $optionValues['currentValue'];
            }

            if (!empty($scope)) {
                // @todo what happens if this is empty?
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

        return self::$optionsValues[$optionName]['defaults'][$scope];
    }

    static function enumValuesForProperty($property, $scope = 'ceres') {
        self::setData();
        return self::$optionsEnums[$property][$scope];
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

    /**
     * Gets an option as stored in WP's option table, e.g
     * `ceres_view_packages` or `siteurl`
     * 
     *
     * @param string $optionName
     * @return mixed
     */

    static function getWpOption(string $wpOptionName) {
        if (function_exists('get_option')) {
            return get_option($wpOptionName);
        } else {
            //save it all to a file in dev for now
            switch($wpOptionName) {
                case 'ceres_all_options':
                    return self::$allOptions;
                break;
                case 'ceres_option_values':
                    return self::$optionsValues;
                break;                    
                case 'ceres_view_packages':
                    return self::$viewPackages;
                break;                    
                case 'ceres_options_enums':
                    return self::$optionsEnums;
                break;                    
                case 'ceres_property_labels':
                    return self::$propertyLabels;
                break;                    
                break;
                case 'site_url':
                    return "https://" . $_SERVER['SERVER_NAME'];
                break;
                default:
                
                    throw new DataException("Option $wpOptionName does not exist");

            }
        }
    }

    static function updateWpOption(string $wpOptionName, array $wpOptionData) {
        if (substr($wpOptionName, 0, 6) != 'ceres_') {
            throw new DataException("Cannot update a non-CERES wp option: $wpOptionName");
        }
        if (function_exists('update_option')) {
            update_option($wpOptionName, $wpOptionData);
        } else {
//save it all to a file in dev for now
            $optionDataJson = json_encode($wpOptionData);
            $fileName = CERES_ROOT_DIR . "/devscraps/data/$wpOptionName.json";
            file_put_contents($fileName, $optionDataJson);
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

//@todo switch into data, not config

        self::$viewPackages = json_decode(file_get_contents(CERES_ROOT_DIR . '/devscraps/data/ceres_view_packages.json'), true);
        self::$allOptions = json_decode(file_get_contents(CERES_ROOT_DIR . '/devscraps/data/ceres_all_values.json'), true);
        self::$optionsValues = json_decode(file_get_contents(CERES_ROOT_DIR . '/devscraps/data/ceres_options_values'), true);
        self::$propertyLabels = json_decode(file_get_contents(CERES_ROOT_DIR . '/devscraps/data/ceres_property_labels.json'), true);
        self::$optionsEnums = json_decode(file_get_contents(CERES_ROOT_DIR . '/devscraps/data/ceres_options_enums.json'), true);


        // self::$viewPackages = Config\getViewPackages();
        // self::$allOptions = Config\getAllOptions();
        // self::$optionValues = Config\getOptionsValues();
        // self::$propertyLabels = Config\getPropertyLabels();
        // self::$optionsEnums = Config\getOptionsEnums();
    }

    /**
     * rebuildViewPackages
     * 
     * The scopes for R/E/Fs are kept separate for maintenance,
     * but get merged together in getViewPackages
     * 
     * With the move to json, need to rebuild the merges and update json
     * for updates
     *
     * @return void
     */
    static function rebuildViewPackages() {
        $vpsArrays = self::$viewPackages = Data\getViewPackages();
        self::updateWpOption('ceres_view_packages', $vpsArrays );


    }

}
