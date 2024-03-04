<?PHP 
 
namespace Iwd; 

use Iwd\generalFunctions; 

class sessionFactory {

    public function __construct() {
		$this->sessionStart(); 
	}

    public function sessionStart() : void { 
		if(!session_id() && !headers_sent()) {
			session_start();
		}
		return;         
	} 
	
    public function checkForSession() : bool { 
		return session_id() ? true : false;         
	} 
	
	public function refresh() {		
		$_SESSION[generalFunctions::$constPref] = []; 
		return; 
	}

	public function set(string $key, $value) {
		if(!isset($_SESSION[generalFunctions::$constPref])) { $_SESSION[generalFunctions::$constPref] = []; }
		$_SESSION[generalFunctions::$constPref][$key] = $value; 
		return; 
	}

	public function get(string $key) {
		if(!isset($_SESSION[generalFunctions::$constPref])) { $_SESSION[generalFunctions::$constPref] = []; }
		return $_SESSION[generalFunctions::$constPref][$key] ?? []; 
	}

	public function merge(string $key, array $value) {
		$_SESSION[generalFunctions::$constPref][$key] = array_merge_recursive((array)$this->get($key), (array)$value); 
		return; 
	}

}
