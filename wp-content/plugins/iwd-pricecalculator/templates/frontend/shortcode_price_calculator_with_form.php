
<?PHP
if(!defined('ABSPATH')) { exit(); }

$label_anzahl_dn = 'Anzahl der Dienstnehmer:'; 
$val_dn_sbmt_bnt    = 'Berechnen'; 
?>

<div style="clear:both" ></div>
<div id="iwd-calculator">
	<div class="iwd-clear"></div>
	<!-- row -->
	<div class="iwd-calculator-row">			
		<?= $data['txt']['einleitungstext'] ?? '' ?> 
	</div>
	<div class="iwd-clear"></div>
	<!-- row -->
	<div class="iwd-calculator-row">
		<!-- calculator-form -->
		<form id="iwd-calculator-form" >	
			<input type="hidden" name="action" value="iwd-calculate" />  
 			<strong><?= $label_anzahl_dn ?></strong>	
			<div class="iwd-clear"></div>	
			<div class="iwd-form-group iwd-80">
				<!-- DN-Input -->
				<input type="number" name="dn" min="1" step="1" value="0" /> 
			</div>
			<div class="iwd-form-group iwd-20">				
				<!-- submit -->
				<input type="submit" class="" value="<?= $val_dn_sbmt_bnt ?>" /> 
			</div>
		</form>
	</div>
	<div style="iwd-clear" ></div>
	<!-- row -->
	<div class="iwd-calculator-row">
		<!-- ajax -->
		<div id="iwd-ajax-container"><!-- Hier wird alles nachgeladen --></div>
	</div>
</div>
<div style="iwd-clear" ></div>