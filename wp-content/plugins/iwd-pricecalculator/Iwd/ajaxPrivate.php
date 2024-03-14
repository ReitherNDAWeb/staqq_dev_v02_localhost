<?PHP 
 
namespace Iwd; 

use Iwd\generalFunctions; 

class ajaxPrivate {

    public function __construct() {
        if(!is_user_logged_in()) { die(); }
    }

    public function ajax($action) { 
        
        $a = ['success' => false, 'data' => []]; 

        switch($action) {  
            case 'iwd-update-settings':  
                
                if(isset($_REQUEST['iwd-settings']) && wp_verify_nonce( $_REQUEST['iwd-settings'], 'iwd-pricecalculator-settings' ) ){

                    $b = [
                        // allg. Texte 
                        'txt' => [
                            'einleitungstext' => trim(preg_replace( '/(\r\n)|\n|\r/', '\\n', str_replace('\'','',(($_REQUEST['einleitungstext'] ?? '')) ) ) ) , 
                            'formulartext' => trim(preg_replace( '/(\r\n)|\n|\r/', '\\n', str_replace('\'','',(($_REQUEST['formulartext'] ?? '')) ) ) ),
                            'formulardanketext' => trim(preg_replace( '/(\r\n)|\n|\r/', '\\n', str_replace('\'','',(($_REQUEST['formulardanketext'] ?? '')) ) ) )
                        ],
                        // Emails 
                        'emails' => [
                            'subject_user'  => ($_REQUEST['subject_user'] ?? ''), 
                            'msg_user'      => trim(preg_replace( '/(\r\n)|\n|\r/', '\\n', str_replace('\'','',(($_REQUEST['msg_user'] ?? '')) ) ) ), 
                            'email_admin'   => ($_REQUEST['email_admin'] ?? ''), 
                            'subject_admin' => ($_REQUEST['subject_admin'] ?? ''), 
                            'msg_admin'     => trim(preg_replace( '/(\r\n)|\n|\r/', '\\n', str_replace('\'','',(($_REQUEST['msg_admin'] ?? '')) ) ) )
                        ],
                        // Preise FC
                        'fc' => (array)$_REQUEST['fc'] ?? [], 
                        // Preise Feliciter 
                        'feliciter' => (array)$_REQUEST['feliciter'] ?? []
                    ]; 

                    (new generalFunctions())->saveIwdPostMeta('iwd-settings', json_encode($b, JSON_UNESCAPED_UNICODE)); 

                    $a['data']    = 'something';  
                    $a['success'] = true; 
                }
                break;            
        }

        header('Content-Type: application/json');
        echo json_encode($a);
        wp_die(); 

        return;
    } 

}
