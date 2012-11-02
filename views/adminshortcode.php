<div class="wrap">
  <h2>PayPal Express Checkout - Shortcode</h2>
  
  <?php if ( get_option('paypal_api_username') == '' || get_option('paypal_api_password') == '' || get_option('paypal_api_signature') == '' ) { ?>
    <div class="updated" id="message">
		  <p><strong>Before you can use shortcode you need to set your PayPal API credentials, go to <a href="<?php echo $config->getItem('plugin_configuration_url'); ?>" title="configuration page">the configuration page</a>.</strong></p>
		</div>
  <?php } else { ?>
    <p>
      You can easily add PayPal Express Checkout to your pages with shortcode. Here you can see the shortcode options.<br />
      If you need help visit the <a href="<?php echo $config->getItem('plugin_help_url'); ?>" title="PayPal Help">Help</a> page.
    </p>
    <p>&nbsp;</p>
    <p>
      <strong>Example #1</strong>(pay 30 USD)<br />
      [paypal amount=30 currency=USD]
    </p>
    
    <p>
      Here you can found the supported currencies and currency codes. <a href="https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_api_nvp_currency_codes" target="_blank" title="Supported currencies">Supported currencies</a>.
    </p>
    <p>&nbsp;</p>
    <p>
      <strong>Example #2</strong>(pay 30 EUR + add description)<br />
      [paypal amount=30 currency=USD description="Buying item SKU:TEST_ITEM_SKU"]
    </p>
  <?php } ?>
</div><!-- .wrap -->