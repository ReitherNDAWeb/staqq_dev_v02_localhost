<?PHP 

if(!defined('IWD_TEMPLATE_PATH')) { exit(); }

if(isset($file) && strlen($file)>0) {
    switch(basename($file)) {
        case 'be_companies.php': 
            echo '<a href="/wp-admin/users.php" id="iwd_add_company" class="page-title-action">Neu hinzufügen</a>'; 
            break; 
        case 'be_settings.php': 
            echo '<a id="iwd-add-zone" href="#" class="page-title-action">Neu hinzufügen</a>'; 
            break; 
        case 'be_editcompany.php': 
            echo '<a href="/wp-admin/admin.php?page='.IWD_PLUGIN_SLUG.'-companies" class="page-title-action">Zur &Uuml;bersicht</a>'; 
            break; 
    }
}