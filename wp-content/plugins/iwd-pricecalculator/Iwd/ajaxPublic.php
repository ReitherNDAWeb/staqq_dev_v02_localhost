<?PHP 
 
namespace Iwd; 
use Iwd\generalFunctions; 

class ajaxPublic {

    public function __construct() {}

    public function ajax($action) { 
        
        $a = ['success' => false, 'data' => []]; 

        switch($action) {
            case 'iwd-send-contactform': 
                if(wp_verify_nonce( ($_REQUEST['iwd-nonce'] ?? ''), 'iwd_calculator_contact_form_nonce' )) {

                    if(!isset($_REQUEST['iwd-goaway']) || strlen($_REQUEST['iwd-goaway']) == '') {

                        $settings = json_decode( ((new generalFunctions())->getIwdPostMeta('iwd-settings')[0] ?? '{}'), true); 

                        if(isset($settings['emails']) && count($settings['emails'])>0) {
                            foreach($settings['emails'] as $_e) {
                                if(strlen($_e) == 0) {
                                    return $this->returnJSON($a); 
                                }
                            }
                        }

                        $date = new \DateTime('now', new \DatetimeZone('EUROPE/BERLIN')); 

                        $iwd = [
                            'salutation'    => (string)($_REQUEST['iwd-salutation'] ?? ''), 
                            'title'         => (string)($_REQUEST['iwd-title'] ?? ''), 
                            'first_name'    => (string)($_REQUEST['iwd-first-name'] ?? ''), 
                            'last_name'     => (string)($_REQUEST['iwd-last-name'] ?? ''), 
                            'company'       => (string)($_REQUEST['iwd-company'] ?? ''), 
                            'dn'            => (string)($_REQUEST['iwd-dn'] ?? ''), 
                            'phone'         => (string)($_REQUEST['iwd-phone'] ?? ''), 
                            'email'         => (string)($_REQUEST['iwd-email'] ?? ''), 
                            'question'         => (string)($_REQUEST['iwd-question'] ?? ''), 
                            'msg'           => (string)($_REQUEST['iwd-msg'] ?? ''),
                            'datetime'      => $date->format('Y-m-d H:i:s')
                        ];  

                        $b = [
                            '_SALUTATION_','_TITLE_','_FIRSTNAME_','_LASTNAME_','_COMPANY_','_DN_','_PHONE_','_EMAIL_','_QUESTION_','_MSG_','_DATETIME_'
                        ]; 

                        $subject_user   = str_replace($b,$iwd,$settings['emails']['subject_user'] ?? ''); 
                        $msg_user       = str_replace($b,$iwd,$settings['emails']['msg_user'] ?? ''); 
                        $email_admin    = trim($settings['emails']['msg_user'] ?? ''); 
                        $subject_admin  = str_replace($b,$iwd,$settings['emails']['subject_admin'] ?? ''); 
                        $msg_admin      = str_replace($b,$iwd,$settings['emails']['msg_admin'] ?? ''); 
              
                        $headers = array('Content-Type: text/html; charset=UTF-8');

                        /**
                         * Mail User 
                         */
                        $data['msg'] = $msg_user; 
                        $message = (new frontendFactory())->template('email_admin',$data); 

                        wp_mail( trim($a['email']), $subject_user, $message, $headers);
                      
                        /**
                         * Mail User  
                         */
                        $data['msg'] = $msg_admin; 
                        $message = (new frontendFactory())->template('email_admin',$data); 

                        wp_mail( trim($email_admin), $subject_admin, $message, $headers);

                        /**
                         * Save Request 
                         */
                        $requests = json_decode( ((new generalFunctions())->getIwdPostMeta('iwd-requests')[0] ?? '{}'), true); 
                        $requests[] = $iwd; 
                        (new generalFunctions())->saveIwdPostMeta('iwd-requests', json_encode($requests, JSON_UNESCAPED_UNICODE)); 

                        $a['success'] = true; 
                        $a['html'] = nl2br($settings['txt']['formulardanketext'] ?? '');  
                    }
                }
                break; 
            case 'iwd-calculate': 

                // Teilnehmer 
                $dn = (int)($_REQUEST['dn'] ?? 0); 

                // Compliance (FALCON)
                $falcon_basic = 0; 
                $falcon_plus  = 0; 

                // HR Management (FELICITER)
                // Plus Paket 
                $feliciter_basic = 0; 
                $feliciter_plus  = 0; 

                $settings = json_decode( ((new generalFunctions())->getIwdPostMeta('iwd-settings')[0] ?? '{}'), true); 

                if((int)$dn>0) {

            /**
             * Compliance (FALCON)      
            */ 
                    
                    /*
                     * Set Up Beratung
                     */
                    $setup = 0; 
                    
                    if((int)$dn<=10) {
                        $setup = 10; 
                    } elseif((int)$dn<=50) {
                        $setup = 50; 
                    } elseif((int)$dn<=150) {
                        $setup = 150; 
                    } elseif((int)$dn<=300) {
                        $setup = 300; 
                    } else {
                        // Preis 500
                        $setup = 500; 
                    }

                    $val = $settings['fc']['b_'.$setup] ?? 0; 

                    if((int)$val == 0) {
                        $a['data']['error'] = 'FALCON: Set Up Beratung';  
                        return $this->returnJSON($a); 
                    }

                    $tmp = ((float)$val*(int)$dn)+(float)($settings['fc']['b_Fixum'] ?? 0); 

                    // Basic 
                    $falcon_basic += (float)$tmp;
                    // Plus 
                    $falcon_plus += (float)$tmp;


                    /**
                     * LSt und SV Beratung
                     * currently unused
                     */                   


                    /**
                     * PLB Begleitung
                     * currently unused
                     */


                    /**
                     * Gehaltsverrechnung BMD.com
                     * 
                     * WENN($F$3>'Preise FC'!$A$2;
                     *  WENN($F$3>'Preise FC'!$A$3;
                     *      WENN($F$3>'Preise FC'!$A$4;
                     *          WENN($F$3>'Preise FC'!$A$5;'Preise FC'!$D$6;'Preise FC'!$D$5);
                     *      'Preise FC'!$D$4);
                     *  'Preise FC'!$D$3);
                     * 'Preise FC'!$D$2)   
                     * 
                     * *$F$3
                     * 
                     */

                    $val = $settings['fc']['d_'.$setup] ?? 0; 

                    if((int)$val == 0) {
                        $a['data']['error'] = 'FALCON: Gehaltsverrechnung BMD.com';  
                        return $this->returnJSON($a); 
                    }

                    $tmp = (float)$val*(int)$dn; 

                    // Basic 
                    $falcon_basic += (float)$tmp;
                    // Plus 
                    $falcon_plus += (float)$tmp;


                    /**
                     * Personalrückstellungen
                     * 
                     */

                    /**
                     * Formel ist vollig falsch, wird aber von denn so verwendet 
                     */
                    $val = $this->DnVsGrundabrechnung((int)$dn, (array)$settings, 'e');                     

                    if((int)$val == 0) {
                        $a['data']['error'] = 'FALCON: Personalrückstellungen';  
                        return $this->returnJSON($a); 
                    }

                    $tmp = ((float)$val*(int)$dn)+($settings['fc']['e_Fixum'] ?? 0); 

                    // Basic 
                    // Nur bei plus 
                    //$falcon_basic += (float)$tmp;
                    // Plus 
                    $falcon_plus += (float)$tmp;


                    /**
                     * 
                     * Fringe Benefits Beratung (Betriebspensionen, Gehaltsmodell, etc), Erstberatung
                     *  
                     */
                    $tmp = 270*3; 

                    // Basic 
                    // Nur bei plus 
                    //$falcon_basic += (float)$tmp;
                    // Plus 
                    $falcon_plus += (float)$tmp;



                    /**
                     * Fringe Benefits Beratung (Betriebspensionen, Gehaltsmodell, etc)
                     * currently unused
                     */


                    /**
                     * Zeitmanagement online
                     * Nachc MA (evtl. inkl. Fixum )
                     * 
                     */
                    /**
                     * Formel ist vollig falsch, wird aber von denn so verwendet 
                     */
                    $val = $this->DnVsGrundabrechnung((int)$dn, (array)$settings, 'f'); 
                    
                    if((int)$val == 0) {
                        $a['data']['error'] = 'FALCON: Zeitmanagement online';  
                        return $this->returnJSON($a); 
                    }

                    $tmp = ((float)$val*(int)$dn)+($settings['fc']['f_Fixum'] ?? 0); 

                    // Basic 
                    // Nur bei plus 
                    // $falcon_basic += (float)$tmp;
                    // Plus 
                    $falcon_plus += (float)$tmp;


                    /**
                     * Zeitmanagement online
                     * Nach Stunden 
                     * currently unused
                     */


                    /**
                     * Reisekostenerfassung 
                     * 
                     */
                    $val = $this->DnVsGrundabrechnung((int)$dn, (array)$settings, 'g'); 
                   
                    if((int)$val == 0) {
                        $a['data']['error'] = 'FALCON: Reisekostenerfassung';  
                        return $this->returnJSON($a); 
                    }

                    $tmp = ((float)$val*(int)$dn)+($settings['fc']['g_Fixum'] ?? 0); 

                    // Basic 
                    // Nur bei plus 
                    // $falcon_basic += (float)$tmp;
                    // Plus 
                    $falcon_plus += (float)$tmp;



                    /**
                     * Auswertungsmanagement 
                     */
                    $val = $this->DnVsGrundabrechnung((int)$dn, (array)$settings, 'h'); 
                   
                    if((int)$val == 0) {
                        $a['data']['error'] = 'FALCON: Auswertungsmanagement';  
                        return $this->returnJSON($a); 
                    }

                    $tmp = ((float)$val*(int)$dn)+($settings['fc']['h_Fixum'] ?? 0); 

                    // Basic 
                    // Nur bei plus 
                    // $falcon_basic += (float)$tmp;
                    // Plus 
                    $falcon_plus += (float)$tmp;


                    /**
                     * Personaldienstpläne
                     * currently unused
                     */
                    
                    /**
                     * Der elektronische Personalakt
                     * offen; Nach MA (ev inkl. Fixum)
                     * currently unused
                     */

                     /**
                     * Der elektronische Personalakt
                     * Nach Stunden
                     * currently unused
                     */

                    /**
                     * Online Bewerbung
                     * offen; Nach MA (ev inkl. Fixum)
                     * currently unused
                     */

                     /**
                     * Online Bewerbung
                     * Nach Stunden
                     * currently unused
                     */

                    /**
                     * Zwischensumme
                     */ 
                //    var_dump($falcon_basic); 
                //    var_dump($falcon_plus); 
                //    die(); 


        /**
         * HR Management (FELICITER)
         */ 

                    // Stundensatz angewandt
                    // =WENN(50<15;140;WENN(UND(50>14;50<49);100;L24))
                    $h = 0; 

                    if((int)$dn<15) {
                        $h = (float)$settings['feliciter']['ma_under_15'] ?? 0; 
                    } elseif((int)$dn>14 && (int)$dn<49) {
                        $h = (float)$settings['feliciter']['ma_over_15'] ?? 0; 
                    } else {
                        $h = (float)$settings['feliciter']['ma_over_49'] ?? 0; 
                    }


                    if((int)$h == 0) {
                        $a['data']['error'] = 'FELICITER: Stundensatz angewandt';  
                        return $this->returnJSON($a); 
                    }

                    /**
                     * Personalorganisation 
                     */
                    $tmp = ((int)$dn*(float)($settings['feliciter']['personalorganisation'] ?? 0))*(float)$h; 
                    // Basic 
                    $feliciter_basic += (float)$tmp;
                    // Plus 
                    $feliciter_plus += (float)$tmp;

                    /**
                     * Personalstrategie
                     */
                    $tmp = ((int)$dn*(float)($settings['feliciter']['personalstrategie'] ?? 0))*(float)$h; 
                    // Basic 
                    $feliciter_basic += (float)$tmp;
                    // Plus 
                    $feliciter_plus += (float)$tmp;


                    /**
                     * Personalsuche passiv
                     */
                    $tmp = ((int)$dn*(float)($settings['feliciter']['personalsuche-passiv'] ?? 0))*(float)$h; 
                    // Basic 
                    $feliciter_basic += (float)$tmp;
                    // Plus 
                    $feliciter_plus += (float)$tmp;
         
                    /**
                     * Personalsuche aktiv
                     */
                    $tmp = ((int)$dn*(float)($settings['feliciter']['personalsuche-aktiv'] ?? 0))*(float)$h; 
                    // Basic
                    // Nur plus  
                    //$feliciter_basic += (float)$tmp;
                    // Plus 
                    $feliciter_plus += (float)$tmp;                   
    
                    /**
                     * Bewerberselektion
                     */
                    $tmp = ((int)$dn*(float)($settings['feliciter']['bewerberselektion'] ?? 0))*(float)$h; 
                    // Basic
                    $feliciter_basic += (float)$tmp;
                    // Plus 
                    $feliciter_plus += (float)$tmp;                   

                    /**
                     * Bewerberauswahl
                     */
                    $tmp = ((int)$dn*(float)($settings['feliciter']['bewerberauswahl'] ?? 0))*(float)$h; 
                    // Basic
                    // Nur plus  
                    //$feliciter_basic += (float)$tmp;
                    // Plus 
                    $feliciter_plus += (float)$tmp;
         
                    /**
                     * Onboarding
                     */
                    $tmp = ((int)$dn*(float)($settings['feliciter']['onboarding'] ?? 0))*(float)$h; 
                    // Basic
                    // Nur plus  
                    //$feliciter_basic += (float)$tmp;
                    // Plus 
                    $feliciter_plus += (float)$tmp;
        
                    
                    /**
                     * Personaladministration
                     */
                    $tmp = ((int)$dn*(float)($settings['feliciter']['personaladministration'] ?? 0))*(float)$h; 
                    // Basic  
                    $feliciter_basic += (float)$tmp;
                    // Plus 
                    $feliciter_plus += (float)$tmp;
      

                    /**
                     * Trennungsgespräche
                     */
                    $tmp = ((int)$dn*(float)($settings['feliciter']['trennungsgespraeche'] ?? 0))*(float)$h; 
                    // Basic  
                    $feliciter_basic += (float)$tmp;
                    // Plus 
                    $feliciter_plus += (float)$tmp;

       
                    /**
                     * FK-Entwicklung
                     */
                    $tmp = ((int)$dn*(float)($settings['feliciter']['fk-entwicklung'] ?? 0))*(float)$h; 
                    // Basic  
                    // Nur Plus 
                    //$feliciter_basic += (float)$tmp;
                    // Plus 
                    $feliciter_plus += (float)$tmp;
      

                    /**
                     * MA-Gespräche/Befragung
                     */
                    $tmp = ((int)$dn*(float)($settings['feliciter']['ma-gespraeche-befragung'] ?? 0))*(float)$h; 
                    // Basic 
                    // Nur Plus  
                    //$feliciter_basic += (float)$tmp;
                    // Plus 
                    $feliciter_plus += (float)$tmp;
          

                    /**
                     * MA-Entwicklung (Extra Verrechnung)
                     */
                    $tmp = (int)$dn*((float)$settings['feliciter']['ma-entwicklung-extra-verrechnung'] ?? 0)*(float)$h; 
                    // Basic  
                    $feliciter_basic += (float)$tmp;
                    // Plus 
                    $feliciter_plus += (float)$tmp;

           
                    /**
                     * Outplacement (Extra Verrechnung)
                     */
                    $tmp = (int)$dn*((float)$settings['feliciter']['outplacement-extra-verrechnung'] ?? 0)*(float)$h; 
                    // Basic  
                    $feliciter_basic += (float)$tmp;
                    // Plus 
                    $feliciter_plus += (float)$tmp;

           
                    /**
                     * Pers-Berichtswesen
                     */
                    $tmp = (int)$dn*((float)$settings['feliciter']['pers-berichtswesen'] ?? 0)*(float)$h; 
                    // Basic  
                    $feliciter_basic += (float)$tmp;
                    // Plus 
                    $feliciter_plus += (float)$tmp;

     
                    /**
                     * 1/4-jährl. Pers-Bespr. Mit Gf
                     */
                    $tmp = (int)$dn*((float)$settings['feliciter']['1-4-jaehrl-pers-bespr-mit-gf'] ?? 0)*(float)$h; 
                    // Basic  
                    $feliciter_basic += (float)$tmp;
                    // Plus 
                    $feliciter_plus += (float)$tmp;

   
                    /**
                     * Sparringpartner GF
                     */
                    $tmp = (int)$dn*((float)$settings['feliciter']['sparringpartner-gf'] ?? 0)*(float)$h; 
                    // Basic  
                    $feliciter_basic += (float)$tmp;
                    // Plus 
                    $feliciter_plus += (float)$tmp;
 

                    /**
                     * 6x jährl. Pers-Bespr. Mit Gf
                     */
                    $tmp = (int)$dn*((float)$settings['feliciter']['6x-jaehrl-pers-bespr-mit-gf'] ?? 0)*(float)$h; 
                    // Basic  
                    $feliciter_basic += (float)$tmp;
                    // Plus 
                    $feliciter_plus += (float)$tmp;
  

                    /**
                     * Förderabwicklung 
                     */
                    $tmp = (int)$dn*((float)$settings['feliciter']['6x-jaehrl-pers-bespr-mit-gf'] ?? 0)*(float)$h; 
                    // Basic  
                    $feliciter_basic += (float)$tmp;
                    // Plus 
                    $feliciter_plus += (float)$tmp;
       

                    /**
                     * Zwischensumme
                     */ 
                //    var_dump($feliciter_basic); 
                //    var_dump($feliciter_plus); 
               //     die(); 


        /** 
         * Packagekosten
         */
                    $basic = (float)$falcon_basic+(float)$feliciter_basic; 
                    $plus = (float)$falcon_plus+(float)$feliciter_plus; 

        /**
         * das enspricht in FTEs
         */

                    $ftes_basic = round($basic/(3000*1.3*14),2); 
                    $ftes_plus  = round($plus/(3000*1.3*14),2); 

                    $a['data']    = [
                        'dn'                    => $dn, 
                        'zws_falcon_basic'      => $falcon_basic, 
                        'zws_falcon_plus'       => $falcon_plus, 
                        'zws_feliciter_basic'   => $feliciter_basic, 
                        'zws_feliciter_plus'    => $feliciter_plus, 
                        'pkgs_basic'            => $basic, 
                        'pkgs_plus'             => $plus, 
                        'ftes_basic'            => $ftes_basic, 
                        'ftes_plus'             => $ftes_plus,
                        'txt_formular'          => $settings['txt']['formulartext']
                    ]; 

                    $a['html'] = (new frontendFactory())->template('ajax_calculator_results_and_form',$a); 
                    $a['success'] = true; 
                }


                break;                
        }

        return $this->returnJSON($a); 

    } 

    private function DnVsGrundabrechnung(int $dn, array $settings, string $col) {
        $val = 0; 
        if((int)$dn>(float)($settings['fc']['d_10'] ?? 0)) {
            if((int)$dn>(float)($settings['fc']['d_50'] ?? 0)) {                         
                if((int)$dn>(float)($settings['fc']['d_150'] ?? 0)) {                         
                    if((int)$dn>(float)($settings['fc']['d_300'] ?? 0)) {
                        // Größer als 300
                        $val = $settings['fc'][$col.'_500'] ?? 0; 
                    } else {                       
                        // $dn nicht größer als $settings['fc']['d_300']
                        $val = $settings['fc'][$col.'_300'] ?? 0; 
                    }  
                } else {                       
                    // $dn nicht größer als $settings['fc']['d_150']
                    $val = $settings['fc'][$col.'_150'] ?? 0; 
                }
            } else {                       
                // $dn nicht größer als $settings['fc']['d_50']
                $val = $settings['fc'][$col.'_50'] ?? 0; 
            }
        } else {                       
            // $dn nicht größer als $settings['fc']['d_10']
            $val = $settings['fc'][$col.'_10'] ?? 0; 
        }
        return $val;
    }

    private function returnJSON($a) {
        header('Content-Type: application/json');
        echo json_encode($a);
        wp_die();
    }

}