
<?PHP
if(!defined('ABSPATH')) { exit(); }

$th_pkg_super     	= 'Paket "Super"'; 
$th_pkg_superplus 	= 'Paket "Super Plus"'; 
$td_zws_falcon    	= 'Zwischensumme Compliance (FALCON)'; 
$td_zws_feliciter 	= 'Zwischensumme HR Management (FELICITER)'; 
$td_pkg_price     	= 'Packagekosten'; 
$td_ftes          	= 'Enspricht in FTEs'; 
$form_title       	= 'Schnellanfrage'; 
$label_title 		= 'Titel';
$label_salutation   = 'Anrede';
$option_choose      = 'Anrede';
$option_mr          = 'Herr';
$option_mrs         = 'Frau';
$label_first_name 	= 'Vorname';
$label_last_name 	= 'Nachname';
$label_company 		= 'Firma';
$label_dn 			= 'Anzahl Dienstnehmer';
$label_question  	= 'Woran sind Sie interessiert?';
$radio_question1  	= 'Lohnverrechnung';
$radio_question2  	= 'Personalverwaltung';
$radio_question3  	= 'Beide Positionen';
$label_phone 		= 'Telefon';
$label_email 		= 'E-Mail';
$label_msg 			= 'Ihre Nachricht';
$val_con_sbmt_bnt   = 'Anfragen'; 
?>

<div style="iwd-clear" ></div>
<table>
	<thead>
		<tr>
			<th></th>
			<th><?= $th_pkg_super ?></th>
			<th><?= $th_pkg_superplus ?></th>
		</tr>
	</thead>
	<tbody>
		<!-- Falcon -->
		<tr>
			<td><?= $td_zws_falcon ?></td>
			<td>€ <?= number_format(($data['data']['zws_falcon_basic'] ?? 0),2,',','.') ?></td>
			<td>€ <?= number_format(($data['data']['zws_falcon_plus'] ?? 0),2,',','.') ?></td>
		</tr>
		<!-- Feliciter -->
		<tr>
			<td><?= $td_zws_feliciter ?></td>	
			<td>€ <?= number_format(($data['data']['zws_feliciter_basic'] ?? 0),2,',','.') ?></td>
			<td>€ <?= number_format(($data['data']['zws_feliciter_plus'] ?? 0),2,',','.') ?></td>
		</tr>
		<!-- Package price -->
		<tr>
			<td><?= $td_pkg_price ?></td>	
			<td>€ <?= number_format(($data['data']['pkgs_basic'] ?? 0),2,',','.') ?></td>
			<td>€ <?= number_format(($data['data']['pkgs_plus'] ?? 0),2,',','.') ?></td>
		</tr>
		<!-- FTE`s -->
		<tr>
			<td><?= $td_ftes ?></td>	
			<td><?= number_format(($data['data']['ftes_basic'] ?? 0),2,',','.') ?></td>
			<td><?= number_format(($data['data']['ftes_plus'] ?? 0),2,',','.') ?></td>
		</tr>
	</tbody>
</table>
<div style="iwd-clear" ></div>
<br /> 
<?= $data['data']['txt_formular'] ?? '' ?> 
<br /> 
<div style="iwd-clear" ></div>
<form id="iwd-calculator-contact-form" > 
	<input type="hidden" name="action" value="iwd-send-contactform" /> 
	<input type="hidden" name="iwd-goaway" value="" /> 
	<input type="hidden" name="iwd-nonce" value="<?= wp_create_nonce('iwd_calculator_contact_form_nonce') ?>" /> 
	<div class="iwd-clear"></div>	
	<div class="iwd-form-group iwd-50">
		<label for="iwd-salutation" ><?= $label_salutation ?>*</label>	
		<select name="iwd-salutation" id="iwd-salutation" required> 
			<option value="" ><?= $option_choose ?></option>
			<option value="<?= $option_mr ?>" ><?= $option_mr ?></option>
			<option value="<?= $option_mrs ?>" ><?= $option_mrs ?></option>
		</select> 
	</div>
	<div class="iwd-form-group iwd-50">
		<label for="iwd-title" ><?= $label_title ?></label>	
		<input type="text" id="iwd-title" name="iwd-title" value="" /> 
	</div>
	<div class="iwd-clear"></div>	
	<div class="iwd-form-group iwd-50">
		<label for="iwd-first-name" ><?= $label_first_name ?>*</label>	
		<input type="text" id="iwd-first-name" name="iwd-first-name" value="" required /> 
	</div>
	<div class="iwd-form-group iwd-50">
		<label for="iwd-last-name" ><?= $label_last_name ?>*</label>	
		<input type="text" id="iwd-last-name" name="iwd-last-name" value="" required /> 
	</div>
	<div class="iwd-form-group iwd-50">
		<label for="iwd-company" ><?= $label_company ?></label>	
		<input type="text" id="iwd-company" name="iwd-company" value="" /> 
	</div>
	<div class="iwd-form-group iwd-50">
		<label for="iwd-dn" ><?= $label_dn ?>*</label>	
		<input type="text" id="iwd-dn" name="iwd-dn" value="<?= $data['data']['dn'] ?? 0 ?>" required /> 
	</div>
	<div class="iwd-form-group iwd-50">
		<label for="iwd-phone" ><?= $label_phone ?></label>	
		<input type="text" id="iwd-phone" name="iwd-phone" value="" /> 
	</div>
	<div class="iwd-form-group iwd-50">
		<label for="iwd-email" ><?= $label_email ?>*</label>	
		<input type="email" id="iwd-email" name="iwd-email" value="" required /> 
	</div>
	<div class="iwd-form-group iwd-100">
		<label for="iwd-question" ><?= $label_question ?>*</label>	
	</div>
	<div class="iwd-form-group iwd-100">
		<label for="iwd-question1" > <input type="radio" id="iwd-question1" name="iwd-question" value="<?= $radio_question1 ?>"  />  <?= $radio_question1 ?></label>	
	</div>
	<div class="iwd-form-group iwd-100">
		<label for="iwd-question2" > <input type="radio" id="iwd-question2" name="iwd-question" value="<?= $radio_question2 ?>"  />  <?= $radio_question2 ?></label>	
	</div>
	<div class="iwd-form-group iwd-100">
		<label for="iwd-question3" > <input type="radio" id="iwd-question3" name="iwd-question" checked value="<?= $radio_question3 ?>"  />  <?= $radio_question3 ?></label>	
	</div>
	<div class="iwd-form-group iwd-100">
		<label for="iwd-msg" ><?= $label_msg ?></label>	
		<textarea id="iwd-msg" name="iwd-msg" rows="5" ></textarea> 
	</div>
	<div class="iwd-form-group">				
		<!-- submit -->
		<input type="submit" class="" value="<?= $val_con_sbmt_bnt ?>" /> 
	</div>
</form>
<div style="iwd-clear" ></div>
