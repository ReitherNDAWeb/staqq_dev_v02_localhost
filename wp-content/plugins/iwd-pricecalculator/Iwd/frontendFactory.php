<?PHP 
 
namespace Iwd; 

use Iwd\backendFactory; 
use Iwd\sessionFactory; 
use Iwd\generalFunctions; 

class frontendFactory {

    public function __construct() { }

    public function template(string $template, $data=[]) { 

        ob_start();

        switch($template) {
            case 'email_admin':                
                require constant(generalFunctions::$constPref.'_TEMPLATE_PATH').'/frontend/emails/default.php'; 
                break; 
            case 'email_user':                
                require constant(generalFunctions::$constPref.'_TEMPLATE_PATH').'/frontend/emails/default.php'; 
                break; 
            case 'shortcode_price_calculator_with_form': 
                $data = json_decode( ((new generalFunctions())->getIwdPostMeta('iwd-settings')[0] ?? '{}'), true); 
                require constant(generalFunctions::$constPref.'_TEMPLATE_PATH').'/frontend/shortcode_price_calculator_with_form.php'; 
                break; 
            case 'ajax_calculator_results_and_form':                
                require constant(generalFunctions::$constPref.'_TEMPLATE_PATH').'/frontend/ajax_calculator_results_and_form.php'; 
                break; 
            
            default: 
        }
        return ob_get_clean();
    } 
    
}
