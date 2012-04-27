<?php
session_start();
/*
Plugin Name: PayPal Express Checkout
Plugin URI: http://hccoder.info/
Description: Easy integration of PayPal Express Checkout
Author: hccoder - Sándor Fodor
Version: 1.0
Author URI: http://hccoder.info/
*/

$plugin_title = 'PayPal';
$plugin_url = 'paypal-express-checkout';
$plugin_menu = 'AddMenu';

define( 'PAYPALPLUGIN', 'paypal-express-checkout' );

if ( ! class_exists( 'PluginSkeleton' ) ) {
	if ( ! file_exists( ABSPATH.'wp-content/plugins/'.$plugin_url.'/lib/plugin.skeleton.php' ) )
		die( 'Plugin Skeleton not found!' );
		
	require( ABSPATH.'wp-content/plugins/'.$plugin_url.'/lib/plugin.skeleton.php' );
}

/**
 * PayPal Express Checkout Plugin
 */
class PayPal extends PluginSkeleton {
	/**
	 * admin interface for PayPal settings
	 */
	public function PluginAdmin() {
		
		// saving new configuration
		if ( count($_POST) ) {
			update_option('paypal_user', $_POST['api_user']);
			update_option('paypal_pwd', $_POST['api_pwd']);
			update_option('paypal_signature', $_POST['api_signature']);
			update_option('paypal_url', $_POST['paypal_url']);
			update_option('paypal_redirect_url', $_POST['paypal_redirect_url']);
			update_option('paypal_start_page', $_POST['start_page']);
			update_option('paypal_success_page', $_POST['success_page']);
			update_option('paypal_success_url', $_POST['success_url']);
			update_option('paypal_cancel_page', $_POST['cancel_page']);
			update_option('paypal_cancel_url', $_POST['cancel_url']);
		}
		
		// load admin interface
		require('views/admin.php');
	} // PluginAdmin()
	
	
	/**
	 * start express checkout
	 */
	function StartExpressCheckout() {
		// FIELDS
		$fields = array(
            'USER'=>urlencode(get_option('paypal_user')),
            'PWD'=>urlencode(get_option('paypal_pwd')),
            'SIGNATURE'=>urlencode(get_option('paypal_signature')),
            'VERSION'=>urlencode('72.0'),
            'PAYMENTREQUEST_0_PAYMENTACTION'=>urlencode('Sale'),
            'PAYMENTREQUEST_0_AMT'=>urlencode($_POST['AMT']),
            'RETURNURL'=>urlencode(get_option('paypal_success_url')),
            'CANCELURL'=>urlencode(get_option('paypal_cancel_url')),
            'METHOD'=>urlencode('SetExpressCheckout')
        );
        
    foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string,'&');
		
		// CURL
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, get_option('paypal_url'));
		curl_setopt($ch,CURLOPT_POST,count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		
		//execute post
		$result = curl_exec($ch);
		//close connection
		curl_close($ch);
		
		parse_str($result, $result);
		
		if ( $result['ACK'] == 'Success' ) {
			header('Location: https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token='.$result['TOKEN']);
			exit;
		} else {
			PayPal::LogPPError( $result );
		}
	} // StartExpressCheckout()
	
	
	/**
	 * validate payment
	 */
	function ConfirmExpressCheckout() {
		// FIELDS
		$fields = array(
            'USER'=>urlencode(get_option('paypal_user')),
            'PWD'=>urlencode(get_option('paypal_pwd')),
            'SIGNATURE'=>urlencode(get_option('paypal_signature')),
            'VERSION'=>urlencode('72.0'),
            'TOKEN'=>urlencode($_GET['token']),
            'METHOD'=>urlencode('GetExpressCheckoutDetails')
        );
        
    foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string,'&');
		
		// CURL
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, get_option('paypal_url'));
		curl_setopt($ch,CURLOPT_POST,count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		
		//execute post
		$result = curl_exec($ch);
		//close connection
		curl_close($ch);
		
		parse_str($result, $result);
		
		if ( $result['ACK'] == 'Success' ) {
			PayPal::DoExpressCheckout($result);
		} else {
			PayPal::LogPPError( $result );
		}
	} // ConfirmExpressCheckout()
	
	
	/**
	 * completing payment
	 */
	function DoExpressCheckout($result) {
		// FIELDS
		$fields = array(
            'USER'=>urlencode(get_option('paypal_user')),
            'PWD'=>urlencode(get_option('paypal_pwd')),
            'SIGNATURE'=>urlencode(get_option('paypal_signature')),
            'VERSION'=>urlencode('72.0'),
            'PAYMENTREQUEST_0_PAYMENTACTION'=>urlencode('Sale'),
            'PAYERID'=>urlencode($result['PAYERID']),
            'TOKEN'=>urlencode($result['TOKEN']),
            'PAYMENTREQUEST_0_AMT'=>urlencode($_SESSION['AMT']),
            'METHOD'=>urlencode('DoExpressCheckoutPayment')
        );
        
    foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string,'&');
		
		// CURL
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, get_option('paypal_url'));
		curl_setopt($ch,CURLOPT_POST,count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		
		//execute post
		$result = curl_exec($ch);
		//close connection
		curl_close($ch);
		
		parse_str($result, $result);
		
		if ( $result['ACK'] == 'Success' ) {
			PayPal::LogPPSucces( $result );
			
			$balance = get_user_meta(get_current_user_id(), 'balance', true);
			$balance += $_SESSION['AMT'];
			update_user_meta(get_current_user_id(), 'balance', $balance);
		} else {
			PayPal::LogPPError( $result );
		}
	} // DoExpressCheckout($result)
	
	/**
	 * if we got error log it
	 */
	function LogPPError($msg) {
		
		$log = "";
		foreach ( $msg as $key => $value )
			$log .= "$key = $value\n";
		
		$fn = ABSPATH.'wp-content/plugins/'.PAYPALPLUGIN.'/logs/failed/'.date('Y-m-d H:i').'.php';
		file_put_contents( $fn, $log );
	} // LogPPError()
	
	/**
	 * log the succesfull payments
	 */
	function LogPPSucces($msg) {
		$log = "";
		foreach ( $msg as $key => $value )
			$log .= "$key = $value\n";
			
		$fn = ABSPATH.'wp-content/plugins/'.PAYPALPLUGIN.'/logs/successful/'.date('Y-m-d H:i').'.php';
		file_put_contents( $fn, $log );
	} // LogPPSucces()
	
} // PayPal
$pp = new PayPal( $plugin_url, $plugin_title, $plugin_menu );

// redirect hooks for payment
add_action('template_redirect', 'process_paypal_start');
function process_paypal_start() {
	
	// start checkout
	if ( get_option('paypal_start_page') != FALSE && is_page( get_option('paypal_start_page') ) && isset($_POST['AMT'] ) ) {
		
		$_SESSION['AMT'] = $_POST['AMT'];
 		PayPal::StartExpressCheckout();
 	
	} 
	
	// confirm payment
	if ( get_option('paypal_start_page') != FALSE && is_page( get_option('paypal_success_page') ) ) {
		
 		PayPal::ConfirmExpressCheckout();
 	
	}
	
}