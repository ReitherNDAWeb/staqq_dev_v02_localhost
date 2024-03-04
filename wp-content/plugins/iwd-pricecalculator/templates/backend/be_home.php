<?PHP 

use Iwd\backendFactory; 
use Iwd\generalFunctions; 

if(!defined("ABSPATH")) { exit(); }
?> 

<?= backendFactory::messages('home'); ?>

<div class="wrap" >
    <h1 class="wp-heading-inline" >Kalkulator <?= backendFactory::component('page_title_action', '', __FILE__) ?></h1> 
    <hr class="wp-header-end" >
    <?= backendFactory::template('tabs'); ?>
    <div class="iwd_clear" ></div>
    <div class="iwd_bw_panel" >
       

        <h2 class="nav-tab-wrapper">
            <a href="#" data-tab="requests" class="nav-tab iwd-nav-tab">Anfragen</a>
            <a href="#" data-tab="settings" class="nav-tab iwd-nav-tab">Einstellungen</a>
        </h2>

        <div id="iwd-tab-requests" class="iwd-tab" style="" >
            <br /> 
            <h2>&Uuml;bersicht</h2>
            <br /> 
            <table id="iwddatatable" class="wp-list-table widefat fixed striped table-view-list posts datatable" style="width:100%;">
                <thead>
                    <tr>
                        <th scope="col" id="" class="manage-column column-title column-primary">
                            Datum
                        </th>
                        <th scope="col" id="" class="manage-column column-title column-primary">
                            Name
                        </th>
                        <th scope="col" id="" class="manage-column column-title column-primary">
                            Firma                          
                        </th>  
                        <th scope="col" id="" class="manage-column column-title column-primary">
                            Telefon                          
                        </th>  
                        <th scope="col" id="" class="manage-column column-title column-primary">
                            Email                          
                        </th>  
                        <th scope="col" id="" class="manage-column column-title column-primary">
                            Anzahl DN
                        </th>            
                        <th scope="col" id="" class="manage-column column-title column-primary">
                            Nachricht
                        </th>            
                    </tr>
                </thead>
                <tbody>
                    <?PHP 
                        if(isset($data['requests']) && count($data['requests'])>0) {
                            foreach($data['requests'] as $_o) {      
                                $date = new \DateTime($_o['datetime'], new \DateTimeZone('EUROPE/BERLIN')); 
                    ?>
                                <tr>
                                    <td><?= $date->format('d.m.Y H:i') ?></td>
                                    <td><?= ($_o['salutation'] ?? '') ?> <?= ($_o['title'] ?? '') ?> <?= ($_o['first_name'] ?? '') ?> <?= ($_o['last_name'] ?? '') ?></td>
                                    <td><?= ($_o['company'] ?? '') ?></td>
                                    <td><?= ($_o['phone'] ?? '') ?></td>
                                    <td><?= ($_o['email'] ?? '') ?></td>
                                    <td><?= ($_o['dn'] ?? '') ?></td>
                                    <td><?= ($_o['msg'] ?? '') ?></td>
                                </tr>
                    <?PHP
                            }
                        } else {
                    ?>
                            <tr>
                                <td colspan="7" >Es wurden keine Anfragen gefunden.</td>
                            </tr>
                    <?PHP          
                        }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col" id="" class="manage-column column-title column-primary">
                            Datum
                        </th>
                        <th scope="col" id="" class="manage-column column-title column-primary">
                            Name
                        </th>
                        <th scope="col" id="" class="manage-column column-title column-primary">
                            Firma                          
                        </th>  
                        <th scope="col" id="" class="manage-column column-title column-primary">
                            Telefon                          
                        </th>  
                        <th scope="col" id="" class="manage-column column-title column-primary">
                            Email                          
                        </th>  
                        <th scope="col" id="" class="manage-column column-title column-primary">
                            Anzahl DN
                        </th>            
                        <th scope="col" id="" class="manage-column column-title column-primary">
                            Nachricht
                        </th>            
                    </tr>
                </tfoot>
            </table>
        </div>   
        <div id="iwd-tab-settings" class="iwd-tab" style="display:none" >
            <br /> 
            <h2 class="nav-tab-wrapper">
                <a href="#" data-tab="packages" class="nav-tab iwd-nav-tab-sub">Pakete</a>
                <a href="#" data-tab="texte" class="nav-tab iwd-nav-tab-sub">Texte</a>
                <a href="#" data-tab="emails" class="nav-tab iwd-nav-tab-sub">Emails</a>
            </h2>

            <br /> 
            <form id="iwd-settings-form" class="iwd-be-form" >
                <input type="hidden" name="iwd-settings" value="<?= wp_create_nonce( 'iwd-pricecalculator-settings' ) ?>" />  
                <input type="hidden" name="action" value="iwd-update-settings" />  

                <!-- Pakete -->
                <div id="iwd-tab-packages-sub" class="iwd-tab-sub" >
                    <h3>Preise FC</h3>
                    
                    <table class="wp-list-table widefat fixed striped table-view-list posts" style="width:100%;">
                        <thead>
                            <tr>
                                <th scope="col" id="" class="manage-column column-title column-primary">
                                    Anzahl der Abrechnungen <br /> (bis Anzahl)
                                </th>
                                <th scope="col" id="" class="manage-column column-title column-primary">
                                    Set Up LV zum Jahresbeginn pP, einmalig in EUR
                                </th>
                                <th scope="col" id="" class="manage-column column-title column-primary">
                                    Grundabrechnung, 14 Mal pa/Person in EUR                         
                                </th>  
                                <th scope="col" id="" class="manage-column column-title column-primary">
                                    Grundabrechnung, pa/Person in EUR
                                </th>  
                                <th scope="col" id="" class="manage-column column-title column-primary">
                                    Personalrückstellungen
                                </th>
                                <th scope="col" id="" class="manage-column column-title column-primary">
                                    BMD Arbeitszeiterfassung via Webtool pP pa in EUR zusätzlich zur Grundabrechnung
                                </th>
                                <th scope="col" id="" class="manage-column column-title column-primary">
                                    BMD Reiskosten Modul pa/DN, der dieses Modul verwendet in EUR zusätzlich zur Grundabrechnung
                                </th>
                                <th scope="col" id="" class="manage-column column-title column-primary">
                                    BMD Auswertungsmanagment
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            <?PHP 
                                $rows = [
                                    10,50,150,300,500,'Fixum'
                                ]; 

                                foreach($rows as $_r) {
                            ?> 
                                <tr>
                                    <td><?= $_r ?><input type="hidden" name="fc_indexes[]" value="<?= $_r ?>" /></td>
                                    <td><input type="number" name="fc[b_<?= $_r ?>]" value="<?= $data['fc']['b_'.$_r] ?? 0 ?>" /></td>
                                    <td><input type="number" name="fc[c_<?= $_r ?>]" value="<?= $data['fc']['c_'.$_r] ?? 0 ?>" /></td>
                                    <td><input type="number" name="fc[d_<?= $_r ?>]" value="<?= $data['fc']['d_'.$_r] ?? 0 ?>" /></td>
                                    <td><input type="number" name="fc[e_<?= $_r ?>]" value="<?= $data['fc']['e_'.$_r] ?? 0 ?>" /></td>
                                    <td><input type="number" name="fc[f_<?= $_r ?>]" value="<?= $data['fc']['f_'.$_r] ?? 0 ?>" /></td>
                                    <td><input type="number" name="fc[g_<?= $_r ?>]" value="<?= $data['fc']['g_'.$_r] ?? 0 ?>" /></td>
                                    <td><input type="number" name="fc[h_<?= $_r ?>]" value="<?= $data['fc']['h_'.$_r] ?? 0 ?>" /></td>
                                </tr>
                            <?PHP 
                                }
                            ?>
                        </tbody>
                    </table>
                    <br /> 
                    <h3>Preise Feliciter</h3>
                    <br /> 
                    <table class="wp-list-table widefat fixed striped table-view-list posts" style="width:100%;">
                        <thead>
                            <tr>
                                <th scope="col" id="" class="manage-column column-title column-primary">
                                    Stundensatz > 49 MA
                                </th>
                                <th scope="col" id="" class="manage-column column-title column-primary">
                                    Stundensatz > 15 MA
                                </th>
                                <th scope="col" id="" class="manage-column column-title column-primary">
                                    Stundensatz < 15 MA                    
                                </th>  
                                <th scope="col" id="" class="manage-column column-title column-primary">
                                    Stundensatz angewandt
                                </th>                                 
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="number" name="feliciter[ma_over_49]" value="<?= $data['feliciter']['ma_over_49'] ?? 0 ?>" /></td>
                                <td><input type="number" name="feliciter[ma_over_15]" value="<?= $data['feliciter']['ma_over_15'] ?? 0 ?>" /></td>
                                <td><input type="number" name="feliciter[ma_under_15]" value="<?= $data['feliciter']['ma_under_15'] ?? 0 ?>" /></td>
                                <td><input type="number" name="feliciter[ma_angewandt]" value="<?= $data['feliciter']['ma_angewandt'] ?? 0 ?>" /></td>
                            </tr>
                        </tbody>
                    </table>
<br /> 
<br /> 

                    <table class="wp-list-table widefat fixed striped table-view-list posts" style="width:100%;">
                        <thead>
                            <tr>
                                <th scope="col" id="" class="manage-column column-title column-primary">
                                   Leistung
                                </th>
                                <th scope="col" id="" class="manage-column column-title column-primary">
                                    Stunden
                                </th>                                                       
                            </tr>
                        </thead>
                        <tbody>

                            <?PHP 
                                $a = [
                                    'Personalorganisation',
                                    'Personalstrategie',
                                    'Personalsuche passiv',
                                    'Personalsuche aktiv',
                                    'Bewerberselektion',
                                    'Bewerberauswahl',
                                    'Onboarding',
                                    'Personaladministration',
                                    'Trennungsgespräche',
                                    'FK-Entwicklung',
                                    'MA-Gespräche/Befragung',
                                    'MA-Entwicklung (Extra Verrechnung)',
                                    'Outplacement (Extra Verrechnung)',
                                    'Pers-Berichtswesen',
                                    '1/4-jährl. Pers-Bespr. Mit Gf',
                                    'Sparringpartner GF',
                                    '6x jährl. Pers-Bespr. Mit Gf',
                                    'Förderabwicklung'
                                ]; 

                                foreach($a as $_a) {
                            ?>
                                <tr>
                                    <td><?= $_a ?></td>
                                    <td><input type="number" name="feliciter[<?= sanitize_title($_a) ?>]" value="<?= $data['feliciter'][sanitize_title($_a)] ?? 0 ?>" step="0.05" min="0" /></td>
                                </tr>
                            <?PHP 
                                }
                            ?>
                        </tbody>
                    </table>
 
                </div>
                <!-- Texte -->
                <div id="iwd-tab-texte-sub" class="iwd-tab-sub" style="display:none" >
                    <h3>Einleitungstext</h3>
                    <?php wp_editor( ($data['txt']['einleitungstext'] ?? ''), 'einleitungstext', ['textarea_rows'=> '30'] );?>     
                    <br /> 
                    <h3>Text vor Kontaktformular</h3>
                    <?php wp_editor( ($data['txt']['formulartext'] ?? ''), 'formulartext', ['textarea_rows'=> '30'] );?>     
                    <br /> 
                    <h3>Text nach Formularabsendung (Dankestext)</h3>
                    <?php wp_editor( ($data['txt']['formulardanketext'] ?? ''), 'formulardanketext', ['textarea_rows'=> '30'] );?>     
                    <br /> 
                </div>
                <br /> 
                <!-- Emails -->
                <div id="iwd-tab-emails-sub" class="iwd-tab-sub" style="display:none" >


                    <div class="alert alert-info" >
                    
                        <p>
                            Es stehen folgende Platzhalter zur Verf&uuml;gung:
                            <br /> 
                        </p>
                        <table class="wp-list-table widefat fixed striped table-view-list posts" >
                            <tr>
                                <th>_SALUTATION_</th>
                                <td>Anrede des Users</td>
                            </tr>
                            <tr>
                                <th>_TITLE_</th>
                                <td>Akad. Titel des Users</td>
                            </tr>
                            <tr>
                                <th>_FIRSTNAME_</th>
                                <td>Vorname des Users</td>
                            </tr>
                            <tr>
                                <th>_LASTNAME_</th>
                                <td>Nachname des Users</td>
                            </tr>
                            <tr>
                                <th>_COMPANY_</th>
                                <td>Firma des Users</td>
                            </tr>
                            <tr>
                                <th>_DN_</th>
                                <td>DN - Eingabe des Users</td>
                            </tr>
                            <tr>
                                <th>_PHONE_</th>
                                <td>Telefonnummer des Users</td>
                            </tr>
                            <tr>
                                <th>_EMAIL_</th>
                                <td>E-Mail Adresse des Users</td>
                            </tr>
                            <tr>
                                <th>_QUESTION_</th>
                                <td>Antwort der Frage nach dem Interesse des Users</td>
                            </tr>
                            <tr>
                                <th>_MSG_</th>
                                <td>Nachricht des Users</td>
                            </tr>
                        </table>
                    </div>
                    <h3>Betreffzeile - User</h3>                    
                    <div class="iwd-form-group iwd-50">
                        <input type="text" placeholder="Betreffzeile - User" class="iwd-input" id="subject_user" name="subject_user" value="<?= ($data['emails']['subject_user'] ?? '') ?>" /> 
                    </div>
                    <br /> 
                    <h3>Emailtext - User</h3>
                    <?php wp_editor( ($data['emails']['msg_user'] ?? ''), 'msg_user', ['textarea_rows'=> '30'] );?>     
                    <br /> 
                    <hr /> 
                    <h3>Email Empfänger - Admin</h3>                    
                    <div class="iwd-form-group iwd-50">
                        <input type="email" placeholder="Email - Admin" class="iwd-input" id="email_admin" name="email_admin" value="<?= ($data['emails']['email_admin'] ?? '') ?>" /> 
                    </div>
                    <br /> 
                    <h3>Betreffzeile - Admin</h3>                    
                    <div class="iwd-form-group iwd-50">
                        <input type="text" placeholder="Betreffzeile - Admin" class="iwd-input" id="subject_admin" name="subject_admin" value="<?= ($data['emails']['subject_admin'] ?? '') ?>" /> 
                    </div>
                    <br /> 
                    <h3>Emailtext - Admin</h3>
                    <?php wp_editor( ($data['emails']['msg_admin'] ?? ''), 'msg_admin', ['textarea_rows'=> '30'] );?>     
                    <br /> 
                </div>
                <br /> 
                <br />
                <input type="submit" class="button button-primary button-large" value="Speichern" />   
            </form>
            <div style="clear:both;" ></div>
            <br /> 
            <br />
        </div>
    </div>
</div>
<div id="iwd-success" >Erfolgreich!</div>