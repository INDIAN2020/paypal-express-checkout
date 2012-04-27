<div class="wrap">
	<h2>PayPal Express Checkout settings</h2>
	
	<p>Please read the instructions before fill out the form.</p>
	
	<table style="width:100%">
		<tr>
			<td><strong>API username, API password, API signature</strong></td>
			<td>You can request API credentials from your PayPal account. Without these informations you cannot accept payments.</td>
		</tr>
		<tr>
			<td><strong>PayPal NVP URL</strong></td>
			<td>
				This is the URL where the user will be redirected.
				<ul>
					<li>For sandbox payments: https://api.sandbox.paypal.com/nvp</li>
					<li>For live payments: https://api-3t.paypal.com/nvp</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td><strong>PayPal redirect URL</strong></td>
			<td>
				<ul>
					<li>For sandbox payments: https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=</li>
					<li>For live payments: https://www.paypal.com/webscr?cmd=_express-checkout&token=</li>
				</ul>
			</td>
		</tr>
		<tr>
			<td><strong>Start page</strong></td>
			<td>
				Create a page called like "Start PayPal payment". This page will wait the $_POST['AMT'] variable which holds the payable amount. If $_POST['AMT'] is set the page will be redirected to PayPal. Enter page title or slug.
			</td>
		</tr>
		<tr>
			<td><strong>Success page</strong></td>
			<td>
				Create a page called like "Successful PayPal payment". PayPal will redirect the user back to here after successful payment.
			</td>
		</tr>
		<tr>
			<td><strong>Success URL</strong></td>
			<td>
				The URL of "Success page".
			</td>
		</tr>
		<tr>
			<td><strong>Cancel page</strong></td>
			<td>
				Create a page called like "Failed PayPal payment". PayPal will redirect the user back to here after failed payment.
			</td>
		</tr>
		<tr>
			<td><strong>Cancel URL</strong></td>
			<td>
				The URL of "Cancel page".
			</td>
		</tr>
	</table>
	
	<hr />
	
	<h3>Logs</h3>
	<p>
		Every payment logged. You can found the logs in the plugin folder wp-content/plugins/paypal-express-checkout/logs/ here you find 2 folders "failed" will store failed payments, "successful" will store all successful payments.
		<br />Log filename example: 2012-04-26 11:66.php
	</p>
	
	<hr />
	
	<h3>PayPal settings</h3>
	
	<form method="post">
		<table class="form-table">
			<tbody>
				<!-- API USER -->
				<tr valign="top">
					<th scope="row">
						<label for="api_user">API username</label>
					</th>
					<td>
						<input id="api_user" class="regular-text" type="text" value="<?php echo get_option('paypal_user'); ?>" name="api_user" />
					</td>
				</tr>
				
				<!-- API PWD -->
				<tr valign="top">
					<th scope="row">
						<label for="api_pwd">API password</label>
					</th>
					<td>
						<input id="api_pwd" class="regular-text" type="text" value="<?php echo get_option('paypal_pwd'); ?>" name="api_pwd" />
					</td>
				</tr>
				
				<!-- API SIGNATURE -->
				<tr valign="top">
					<th scope="row">
						<label for="api_signature">API signature</label>
					</th>
					<td>
						<input id="api_signature" class="regular-text" type="text" value="<?php echo get_option('paypal_signature'); ?>" name="api_signature" />
					</td>
				</tr>
				
				<!-- PAYPAL NVP URL -->
				<tr valign="top">
					<th scope="row">
						<label for="paypal_url">PayPal NVP URL</label>
					</th>
					<td>
						<input id="paypal_url" class="regular-text" type="text" value="<?php echo get_option('paypal_url'); ?>" name="paypal_url" />
					</td>
				</tr>
				
				<!-- PAYPAL REDIRECT URL -->
				<tr valign="top">
					<th scope="row">
						<label for="paypal_redirect_url">PayPal redirect URL</label>
					</th>
					<td>
						<input id="paypal_redirect_url" class="regular-text" type="text" value="<?php echo get_option('paypal_redirect_url'); ?>" name="paypal_redirect_url" />
					</td>
				</tr>
				
				<!-- START PAGE -->
				<tr valign="top">
					<th scope="row">
						<label for="start_page">Start page<span class="description">(page title or slug)</span></label>
					</th>
					<td>
						<input id="start_page" class="regular-text" type="text" value="<?php echo get_option('paypal_start_page'); ?>" name="start_page" />
					</td>
				</tr>
				
				<!-- SUCCESS PAGE -->
				<tr valign="top">
					<th scope="row">
						<label for="success_page">Success page<span class="description">(page title or slug)</span></label>
					</th>
					<td>
						<input id="success_page" class="regular-text" type="text" value="<?php echo get_option('paypal_success_page'); ?>" name="success_page" />
					</td>
				</tr>
				
				<!-- SUCCESS URL -->
				<tr valign="top">
					<th scope="row">
						<label for="success_url">Success URL</label>
					</th>
					<td>
						<input id="success_url" class="regular-text" type="text" value="<?php echo get_option('paypal_success_url'); ?>" name="success_url" />
					</td>
				</tr>
				
				<!-- CANCEL PAGE -->
				<tr valign="top">
					<th scope="row">
						<label for="cancel_page">Cancel page<span class="description">(page title or slug)</span></label>
					</th>
					<td>
						<input id="cancel_page" class="regular-text" type="text" value="<?php echo get_option('paypal_cancel_page'); ?>" name="cancel_page" />
					</td>
				</tr>
				
				<!-- CANCEL URL -->
				<tr valign="top">
					<th scope="row">
						<label for="cancel_url">Cancel URL</label>
					</th>
					<td>
						<input id="cancel_url" class="regular-text" type="text" value="<?php echo get_option('paypal_cancel_url'); ?>" name="cancel_url" />
					</td>
				</tr>
				
			</tbody>
		</table>
		
		<p class="submit"><input type="submit" value="Save changes" class="button-primary" id="submit" name="submit"></p>
	</form>
	
	<hr />
	
	<h3>HTML Form example</h3>
	<p>The last step is creating a form on a checkout page, here is an example:</p>
	
	<pre>
&lt;form action="##YOUR PAYPAL START PAGE URL - WHICH ACCEPTS $_POST['AMT']##" method="post"&gt;
  &lt;input type="text" name="AMT" value="10" /&gt;
  &lt;input type="submit" value="Pay with PayPal" /&gt;
&lt;/form&gt;
	</pre>
	
</div><!-- .wrap -->