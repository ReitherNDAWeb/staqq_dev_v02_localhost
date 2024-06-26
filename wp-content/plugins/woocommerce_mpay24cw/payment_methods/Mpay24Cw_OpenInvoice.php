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

require_once dirname(dirname(__FILE__)) . '/classes/Mpay24Cw/PaymentMethod.php'; 

class Mpay24Cw_OpenInvoice extends Mpay24Cw_PaymentMethod
{
	public $machineName = 'openinvoice';
	public $admin_title = 'Open Invoice';
	public $title = 'Open Invoice';
	
	protected function getMethodSettings(){
		return array(
			'processor' => array(
				'title' => __("Processor", 'woocommerce_mpay24cw'),
 				'default' => 'BILLPAY',
 				'description' => __("Select the processor for open invoice.", 'woocommerce_mpay24cw'),
 				'cwType' => 'select',
 				'type' => 'select',
 				'options' => array(
					'BILLPAY' => __("Billpay", 'woocommerce_mpay24cw'),
 					'KLARNA' => __("Klarna", 'woocommerce_mpay24cw'),
 				),
 			),
 			'status_authorized' => array(
				'title' => __("Authorized Status", 'woocommerce_mpay24cw'),
 				'default' => (defined('WOOCOMMERCE_VERSION') && version_compare(WOOCOMMERCE_VERSION, '2.2.0') >= 0) ? 'wc-processing' : 'processing',
 				'description' => __("This status is set, when the payment was successfull and it is authorized.", 'woocommerce_mpay24cw'),
 				'cwType' => 'orderstatusselect',
 				'type' => 'select',
 				'options' => array(
					'use-default' => __("Use WooCommerce rules", 'woocommerce_mpay24cw'),
 				),
 				'is_order_status' => true,
 			),
 			'status_uncertain' => array(
				'title' => __("Uncertain Status", 'woocommerce_mpay24cw'),
 				'default' => (defined('WOOCOMMERCE_VERSION') && version_compare(WOOCOMMERCE_VERSION, '2.2.0') >= 0) ? 'wc-on-hold' : 'on-hold',
 				'description' => __("You can specify the order status for new orders that have an uncertain authorisation status.", 'woocommerce_mpay24cw'),
 				'cwType' => 'orderstatusselect',
 				'type' => 'select',
 				'options' => array(
				),
 				'is_order_status' => true,
 			),
 			'status_cancelled' => array(
				'title' => __("Cancelled Status", 'woocommerce_mpay24cw'),
 				'default' => (defined('WOOCOMMERCE_VERSION') && version_compare(WOOCOMMERCE_VERSION, '2.2.0') >= 0) ? 'wc-cancelled' : 'cancelled',
 				'description' => __("You can specify the order status when an order is cancelled.", 'woocommerce_mpay24cw'),
 				'cwType' => 'orderstatusselect',
 				'type' => 'select',
 				'options' => array(
					'no_status_change' => __("Don't change order status", 'woocommerce_mpay24cw'),
 				),
 				'is_order_status' => true,
 			),
 			'status_captured' => array(
				'title' => __("Captured Status", 'woocommerce_mpay24cw'),
 				'default' => 'no_status_change',
 				'description' => __("You can specify the order status for orders that are captured either directly after the order or manually in the backend.", 'woocommerce_mpay24cw'),
 				'cwType' => 'orderstatusselect',
 				'type' => 'select',
 				'options' => array(
					'no_status_change' => __("Don't change order status", 'woocommerce_mpay24cw'),
 				),
 				'is_order_status' => true,
 			),
 			'iframe_height' => array(
				'title' => __("IFrame Height", 'woocommerce_mpay24cw'),
 				'default' => '700',
 				'description' => __("This setting defines the absolute height (in pixel) of the IFrame generated during IFrame authorization.", 'woocommerce_mpay24cw'),
 				'cwType' => 'textfield',
 				'type' => 'text',
 			),
 			'authorizationMethod' => array(
				'title' => __("Authorization Method", 'woocommerce_mpay24cw'),
 				'default' => 'PaymentPage',
 				'description' => __("Select the authorization method to use for processing this payment method.", 'woocommerce_mpay24cw'),
 				'cwType' => 'select',
 				'type' => 'select',
 				'options' => array(
					'PaymentPage' => __("Payment Page", 'woocommerce_mpay24cw'),
 					'IframeAuthorization' => __("IFrame Authorization", 'woocommerce_mpay24cw'),
 				),
 			),
 		); 
	}
	
	public function __construct() {
		$this->icon = apply_filters(
			'woocommerce_mpay24cw_openinvoice_icon', 
			Mpay24Cw_Util::getResourcesUrl('icons/openinvoice.png')
		);
		parent::__construct();
	}
	
	public function createMethodFormFields() {
		$formFields = parent::createMethodFormFields();
		
		return array_merge(
			$formFields,
			$this->getMethodSettings()
		);
	}

}