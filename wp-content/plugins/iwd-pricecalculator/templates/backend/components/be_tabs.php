<?PHP 

if(!defined('IWD_TEMPLATE_PATH')) { exit(); }

if(isset($tabs) && count($tabs)>0) {
    echo '<div class="iwd_tabs" >';
        echo '<ul class="subsubsub">';
        $i=0;  
        foreach($tabs as $_k => $_t) {
            $i++; 
            $sep = $i == count($tabs) ? '' : '&ensp;|&ensp;'; 
            echo '<li><a href="/wp-admin/admin.php?page='.IWD_PLUGIN_SLUG.'-'.$_k.'" class="'.($_t['current'] ?? '').'" >'.($_t['title'] ?? '').'</a>'.$sep.'</li>'; 
        }
        echo '</ul>'; 
    echo '</div>'; 
}