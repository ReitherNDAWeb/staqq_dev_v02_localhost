<?PHP 
 
namespace Iwd; 

use Iwd\generalFunctions; 

class backendFactory {

    public function __construct() { }

    public function template(string $template) { 

        ob_start();

        switch($template) {
            case 'home': 
                $data = $this->getData($template); 
   
                require constant(generalFunctions::$constPref.'_TEMPLATE_PATH').'/backend/be_'.$template.'.php'; 
                break;                          
            default: 
        }

        return ob_get_clean();
    } 

    public static function messages(string $template) { 

        ob_start();

        switch($template) {
            case 'home': 
                require constant(generalFunctions::$constPref.'_TEMPLATE_PATH').'/messages/home.php'; 
            default: 
        }
        return ob_get_clean();
    } 

    public function getTabs(string $type='') {

        $current = (string)($_REQUEST['page'] ?? ''); 

        switch($type) {
            default: 
            return [
                'home'      => ['title' => 'Angebote',       'current' => ($current == IWD_PLUGIN_SLUG.'-home' || $current == IWD_PLUGIN_SLUG ? 'current' : '')], 
                'settings'  => ['title' => 'Einstellungen',  'current' => ($current == IWD_PLUGIN_SLUG.'-settings' ? 'current' : '')]
            ]; 
        }
    }

    public static function component($type, $msg, $file) {

        ob_start();
        
        switch($type) {
            case 'page_title_action': 
                switch(basename($file)) {
                    case 'be_companies.php': 
                    case 'be_settings.php': 
                    case 'be_editcompany.php': 
                        require IWD_TEMPLATE_PATH.'/backend/components/be_page_title_actions.php';  
                }
                break; 
            case 'alert-info': 
                require IWD_TEMPLATE_PATH.'/backend/components/be_alert_info.php'; 
                break; 
        }

        return ob_get_clean();
    }
   
    public function getData(string $template) :array{

        $a = []; 

        switch($template) {
            case 'home': 
                $a = json_decode( ((new generalFunctions())->getIwdPostMeta('iwd-settings')[0] ?? '{}'), true); 
                $a['requests'] = json_decode( ((new generalFunctions())->getIwdPostMeta('iwd-requests')[0] ?? '{}'), true); 
                break;            
        }
        return $a; 
    }
}
