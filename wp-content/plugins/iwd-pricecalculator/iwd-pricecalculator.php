<?PHP 
/*
Plugin Name: IWD Price Calculator
Plugin URI: https://www.individual-web.dev
Description:  
Version: 1.0
Author: Jakob Kronsteiner
Author URI: https://www.individual-web.dev
Text Domain: iwd-pricecalculator
*/

use Iwd\generalFunctions; 

class IWDPriceCalculator {

    public static function init() {

        require_once(__DIR__.'/autoload.php'); 
        
        iwdAutoloader::register(); 

        $generalFunctions = new generalFunctions(); 

        $pref = "IWD_PC"; 

        $generalFunctions->iwdConstant($pref.'_PLUGIN_TEXT_DOMAIN', 'iwd-pricecalculator'); 
        $generalFunctions->iwdConstant($pref.'_PLUGIN_SLUG', 'iwd-pricecalculator'); 
        $generalFunctions->iwdConstant($pref.'_PLUGIN_URL', rtrim(plugin_dir_url( __FILE__ ),'/'));         
        $generalFunctions->iwdConstant($pref.'_PLUGIN_PATH', __DIR__); 
        $generalFunctions->iwdConstant($pref.'_STORAGE_PATH', __DIR__.'/storage'); 
        $generalFunctions->iwdConstant($pref.'_TEMPLATE_PATH', __DIR__.'/templates');         
        $generalFunctions->iwdConstant($pref.'_PLUGIN_POSTTYPE', $pref); 
        $generalFunctions->iwdSetup($pref); 
    }
}

IWDPriceCalculator::init(); 
