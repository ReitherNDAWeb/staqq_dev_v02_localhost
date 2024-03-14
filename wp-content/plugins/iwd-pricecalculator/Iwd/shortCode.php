<?PHP 
 
namespace Iwd; 

use Iwd\frontendFactory; 
use Iwd\generalFunctions; 

class shortCode {

    public function __construct() {}

    public function iwd_price_calculator_with_form($atts) { 
        return (new frontendFactory())->template('shortcode_price_calculator_with_form', $atts);     
    } 
    
}
