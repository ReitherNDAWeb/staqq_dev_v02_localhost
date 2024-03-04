<?PHP 

use Iwd\generalFunctions; 

if(!defined("ABSPATH")) { exit(); }

if($codes = generalFunctions::iwdErrors()->get_error_codes()) {
    echo '<div class="iwd_errors">';
        // Loop error codes and display errors
       foreach($codes as $code){
            $message = generalFunctions::iwdErrors()->get_error_message($code);
            echo '<span class="error"><strong>' . __('Error') . '</strong>: ' . $message . '</span><br/>';
        }
    echo '</div>';
}