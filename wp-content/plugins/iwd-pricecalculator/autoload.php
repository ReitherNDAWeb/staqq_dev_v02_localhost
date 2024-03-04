<?PHP 

class iwdAutoloader
{
  public function __construct()
  {
    spl_autoload_register(array($this, 'load_class'));
  }
  
  public static function register()
  {
    new self();
  }
  
  public function load_class($class_name)
  {
    $file = __DIR__.'/'.str_replace('\\','/',$class_name).'.php';

    if(file_exists($file)) {
      require_once($file);
    }
  }
}