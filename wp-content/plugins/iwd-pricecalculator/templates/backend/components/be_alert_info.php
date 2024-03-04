<?PHP 

if(!defined('IWD_TEMPLATE_PATH')) { exit(); }

if(isset($msg) && strlen($msg)>0) {
?> 
<div class="alert alert-info"><?= $msg ?></div>

<?PHP
}