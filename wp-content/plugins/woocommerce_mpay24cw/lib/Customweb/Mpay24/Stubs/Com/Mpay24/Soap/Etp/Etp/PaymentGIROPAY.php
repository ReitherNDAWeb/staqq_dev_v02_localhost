<?php
/**
 * You are allowed to use this API in your web application.
 *
 * Copyright (C) 2016 by customweb GmbH
 *
 * This program is licenced under the customweb software licence. With the
 * purchase or the installation of the software in your application you
 * accept the licence agreement. The allowed usage is outlined in the
 * customweb software licence which can be found under
 * http://www.sellxed.com/en/software-license-agreement
 *
 * Any modification or distribution is strictly forbidden. The license
 * grants you the installation in one application. For multiuse you will need
 * to purchase further licences at http://www.sellxed.com/shop.
 *
 * See the customweb software licence agreement for more details.
 *
*/

require_once 'Customweb/Mpay24/Stubs/Org/W3/XMLSchema/String.php';
require_once 'Customweb/Mpay24/Stubs/Com/Mpay24/Soap/Etp/Etp/Payment.php';
/**
 * Giropay online bank transfer specific payment parameters
 * 
 * @XmlType(name="PaymentGIROPAY", namespace="https://www.mpay24.com/soap/etp/1.5/ETP.wsdl")
 */ 
class Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentGIROPAY extends Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_Payment {
	/**
	 * @XmlNillable
	 * @XmlValue(name="iban", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $iban;
	
	/**
	 * @XmlValue(name="bic", simpleType=@XmlSimpleTypeDefinition(typeName='string', typeNamespace='http://www.w3.org/2001/XMLSchema', type='Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String'))
	 * @var string
	 */
	private $bic;
	
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentGIROPAY
	 */
	public static function _() {
		$i = new Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentGIROPAY();
		return $i;
	}
	/**
	 * Returns the value for the property iban.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getIban(){
		return $this->iban;
	}
	
	/**
	 * Sets the value for the property iban.
	 * 
	 * @param string $iban
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentGIROPAY
	 */
	public function setIban($iban){
		if ($iban instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->iban = $iban;
		}
		else if (is_object($iban) && get_class($iban) == "Customweb_Xml_Nil") {
			$this->iban = $iban;
		}
		else {
			$this->iban = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($iban);
		}
		return $this;
	}
	
	
	/**
	 * Returns the value for the property bic.
	 * 
	 * @return Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String
	 */
	public function getBic(){
		return $this->bic;
	}
	
	/**
	 * Sets the value for the property bic.
	 * 
	 * @param string $bic
	 * @return Customweb_Mpay24_Stubs_Com_Mpay24_Soap_Etp_Etp_PaymentGIROPAY
	 */
	public function setBic($bic){
		if ($bic instanceof Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String) {
			$this->bic = $bic;
		}
		else {
			$this->bic = Customweb_Mpay24_Stubs_Org_W3_XMLSchema_String::_()->set($bic);
		}
		return $this;
	}
	
	
	
}