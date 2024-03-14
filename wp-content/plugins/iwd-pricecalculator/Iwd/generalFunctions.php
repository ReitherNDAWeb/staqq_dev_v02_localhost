<?PHP 
 
namespace Iwd; 

use Iwd\shortCode; 
use Iwd\ajaxPublic; 
use Iwd\ajaxPrivate; 
use Iwd\frontendFactory; 
use Iwd\backendFactory; 
use Iwd\sessionFactory; 
use Iwd\apiPrivate; 

define('IWD_PLUGIN_POSTTYPE', 'mein_post_typ');

class generalFunctions {

    public function __construct() {}

    public static $constPref; 

    public function iwdSetup(string $pref) : void {
 
        self::$constPref = (string)$pref; 

        $this->iwdAction('init', function () { return (new sessionFactory())->sessionStart(); }); 
        $this->iwdAction('init', function () { return $this->iwdPrivatePostType(constant(self::$constPref.'_PLUGIN_POSTTYPE')); }); 

        if(is_admin()) {        
            $this->isBackend(); 
        } else {
            $this->isFrontend(); 
        }
        return; 
    }

    private function isBackend() {

        $this->iwdStyle('admin_enqueue_scripts', constant(self::$constPref.'_PLUGIN_TEXT_DOMAIN').'-styles', constant(self::$constPref.'_PLUGIN_URL') . '/assets/css/be_styles.css'); 
        $this->iwdStyle('admin_enqueue_scripts', constant(self::$constPref.'_PLUGIN_TEXT_DOMAIN').'-dt-styles', 'https://cdn.datatables.net/v/dt/dt-1.10.24/b-1.7.0/datatables.min.css');
        $this->iwdStyle('admin_enqueue_scripts', constant(self::$constPref.'_PLUGIN_TEXT_DOMAIN').'-dt1-styles', 'https://cdn.datatables.net/buttons/1.7.0/css/buttons.jqueryui.min.css'); 
 
        $this->iwdScript('admin_enqueue_scripts', constant(self::$constPref.'_PLUGIN_TEXT_DOMAIN').'-dt-scripts', 'https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js'); 
        $this->iwdScript('admin_enqueue_scripts', constant(self::$constPref.'_PLUGIN_TEXT_DOMAIN').'-dt1-scripts', 'https://cdn.datatables.net/1.10.24/js/dataTables.jqueryui.min.js'); 
        $this->iwdScript('admin_enqueue_scripts', constant(self::$constPref.'_PLUGIN_TEXT_DOMAIN').'-dt2-scripts', 'https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js'); 
        $this->iwdScript('admin_enqueue_scripts', constant(self::$constPref.'_PLUGIN_TEXT_DOMAIN').'-dt3-scripts', 'https://cdn.datatables.net/buttons/1.7.0/js/buttons.jqueryui.min.js'); 
        $this->iwdScript('admin_enqueue_scripts', constant(self::$constPref.'_PLUGIN_TEXT_DOMAIN').'-dt4-scripts', 'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js'); 
        $this->iwdScript('admin_enqueue_scripts', constant(self::$constPref.'_PLUGIN_TEXT_DOMAIN').'-dt5-scripts', 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js'); 
        $this->iwdScript('admin_enqueue_scripts', constant(self::$constPref.'_PLUGIN_TEXT_DOMAIN').'-dt6-scripts', 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js'); 
        $this->iwdScript('admin_enqueue_scripts', constant(self::$constPref.'_PLUGIN_TEXT_DOMAIN').'-dt7-scripts', 'https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js'); 
        $this->iwdScript('admin_enqueue_scripts', constant(self::$constPref.'_PLUGIN_TEXT_DOMAIN').'-dt8-scripts', 'https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js'); 
        $this->iwdScript('admin_enqueue_scripts', constant(self::$constPref.'_PLUGIN_TEXT_DOMAIN').'-dt9-scripts', 'https://cdn.datatables.net/buttons/1.7.0/js/buttons.colVis.min.js'); 

        $this->iwdScript('admin_enqueue_scripts', constant(self::$constPref.'_PLUGIN_TEXT_DOMAIN').'-scripts', constant(self::$constPref.'_PLUGIN_URL') . '/assets/js/be_scripts.js'); 

        $this->iwdAdminMenuPage('Kalkulator', 'manage_options', constant(self::$constPref.'_PLUGIN_SLUG'), function() { echo (new backendFactory())->template('home'); return; } ,'dashicons-media-document', 20); 

        /** BE Ajax */
        $this->iwdAjaxPrivate('iwd-update-settings');        

        /** FE Ajax */
        $this->iwdAjaxPublic('iwd-calculate'); 
        $this->iwdAjaxPublic('iwd-send-contactform'); 

        return; 
    }
    
    private function isFrontend() {

        $this->iwdStyle('wp_enqueue_scripts', constant(self::$constPref.'_PLUGIN_TEXT_DOMAIN').'-styles', constant(self::$constPref.'_PLUGIN_URL') . '/assets/css/fe_styles.css'); 
        $this->iwdScript('wp_enqueue_scripts', constant(self::$constPref.'_PLUGIN_TEXT_DOMAIN').'-scripts', constant(self::$constPref.'_PLUGIN_URL') . '/assets/js/fe_scripts.js'); 

        $this->iwdShortcode('iwd_price_calculator_with_form');
        
        return; 
    }

    public function iwdConstant(string $const, string $val) : void {
        if(!defined($const)) {
            define($const, $val); 
        }
        return; 
    }

    public function iwdShortcode(string $code) : void { 
        add_shortcode($code, function ($atts=[]) use ($code) { return (new shortCode())->$code($atts); }); 
        return;
    } 

    public function iwdAction(string $action, $callback) : void { 
        add_action($action, $callback);
        return;
    } 

    public function iwdRole(string $role, string $name, $options=[]) : void { 
        add_role( $role, $name, $options);
        return;
    } 
    
    public function iwdAdminMenuPage(string $title, string $capability, string $menu_slug, callable $callback, string $dashicon, int $position) { 
        
        return $this->iwdAction('admin_menu', function() use($title,$capability, $menu_slug, $callback, $dashicon, $position) { 
                add_menu_page(
                    $title,      // page title
                    $title,      // menu title
                    $capability, // capability
                    $menu_slug,  // menu slug
                    $callback,   // callback 
                    $dashicon,   // dashicon 
                    $position    // position 
                );
        });         
    } 
    
    public function iwdAdminSubMenuPage( $parent_slug, string $title, string $capability, string $menu_slug, callable $callback) { 
        
        return $this->iwdAction('admin_menu', function() use($parent_slug,$title,$capability, $menu_slug, $callback) { 
                add_submenu_page(
                    $parent_slug,   // parent slug 
                    $title,         // page title
                    $title,         // menu title 
                    $capability,    // capability
                    $menu_slug,     // menu slug
                    $callback       // callback
                );
        }); 
    }

    public function iwdFilter(string $action, $callback) : void { 
        add_filter($action, $callback);
        return;
    } 

    public function iwdStyle(string $action, string $handle, string $url) : void {             
        $this->iwdAction($action, function() use ($handle,$url) { wp_register_style($handle, $url); wp_enqueue_style($handle); }); 
        return;
    } 

    public function iwdScript(string $action, string $handle, string $url) : void { 
        $this->iwdAction($action, function() use ($handle,$url) { wp_enqueue_script($handle, $url, array ( 'jquery' ), 1.1, true); }); 
        return;
    } 

    public function iwdAjaxPublic(string $name) : void { 
        $this->iwdAction("wp_ajax_".$name, function () use ($name) { (new ajaxPublic())->ajax($name); }); 
        $this->iwdAction("wp_ajax_nopriv_".$name, function () use ($name) { (new ajaxPublic())->ajax($name); }); 
        return;
    } 
    
    public function iwdAjaxPrivate(string $name) : void { 
        $this->iwdAction("wp_ajax_".$name, function () use ($name) { (new ajaxPrivate())->ajax($name); });
        return;
    } 

    public function iwdPrivatePostType(string $name) : void { 
        register_post_type( $name, array( 'public' => false ) );
        return;
    } 

    public function getIwdPostMeta($key='') {
        if(strlen($key)>0) {
            return get_post_meta((int)($this->getIwdPrivatePostTypeId()))[$key] ?? '';
        }
        return get_post_meta((int)($this->getIwdPrivatePostTypeId()));
    }

    public function saveIwdPostMeta(string $key, $value) : void {
        update_post_meta( (int)$this->getIwdPrivatePostTypeId(), $key, $value);
        return; 
    }
    
    public function getIwdPrivatePostTypeId($retry=true) {

        if (defined('IWD_PLUGIN_POSTTYPE')) {
            error_log('IWD_PLUGIN_POSTTYPE ist definiert: ' . IWD_PLUGIN_POSTTYPE);
        } else {
            error_log('IWD_PLUGIN_POSTTYPE ist NICHT definiert.');
        }

        $post_type = defined('IWD_PLUGIN_POSTTYPE') ? IWD_PLUGIN_POSTTYPE : 'default_post_type';
        $post = get_posts(array(
                'post_type'       => $post_type,
                'posts_per_page'  => 1,
                'post_status'     => 'private',
                'fields'          => 'ids'
            )
        );

        if(count((array)$post) == 0) {
            // setup 

            if((bool)$retry == true) {
                // prevent loops 
                wp_insert_post( 
                    array(
                        'post_title'   => IWD_PLUGIN_POSTTYPE,
                        'post_content' => 'Used to store some meta-data.',
                        'post_status'  => 'private',
                        'post_type'    => IWD_PLUGIN_POSTTYPE,
                        )
                );
                return $this->getIwdPrivatePostTypeId(false); 
            }
        }
        return $post[0] ?? 0; 
    }


    public static function iwdErrors() { 
        static $wp_error; 

        return isset($wp_error) ? $wp_error : ($wp_error = new \WP_Error(null, null, null));
    } 
}
