<?php

/**
 *  * You are allowed to use this API in your web application.
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

require_once 'Mpay24Cw/Util.php';
require_once 'Customweb/Database/Migration/IScript.php';

class Mpay24Cw_Migration_2_3_0 implements Customweb_Database_Migration_IScript {

	public function execute(Customweb_Database_IDriver $driver){
		
		$entityManager = Mpay24Cw_Util::getEntityManager();
		
		$tableNameTransaction = $entityManager->getTableNameForEntityByClassName('Mpay24Cw_Entity_Transaction');
		
		$driver->query("ALTER TABLE `" . $tableNameTransaction . "` ADD COLUMN  `postId` VARCHAR( 255 )")->execute();

		
		return true;
	}
}