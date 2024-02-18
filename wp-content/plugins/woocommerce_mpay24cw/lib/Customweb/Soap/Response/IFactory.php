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


interface Customweb_Soap_Response_IFactory {
	
	/**
	 * Returns a request object based up on the given call object.
	 * 
	 * @return Customweb_Soap_IResponse
	 */
	public function createResponse(Customweb_Soap_ICall $call, Customweb_Core_Http_IResponse $response);
	
}