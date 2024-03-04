<?PHP 
 
namespace Iwd; 

use Iwd\generalFunctions;

class apiPrivate {

    public function __construct() {}

    public function call(array $options) { 
        
        $a = ['success' => false, 'data' => []]; 

        switch($options['api']) {
            case 'example': 
                $a['data']    = json_decode($this->post('example', []), true); 
                $a['success'] = true; 
                break; 
        }
        return $a;
    } 

    private function post(string $url, array $param) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $r = curl_exec($ch);
        curl_close ($ch);
        return $r; 
        
    }

}
