<form method="post" action="<?php echo $config->getItem('plugin_form_handler_url'); ?>">
  <input type="hidden" name="AMT" value="<?php echo $atts['amount']; ?>" />
  <input type="hidden" name="CURRENCYCODE" value="<?php echo $atts['currency']; ?>" />
  <?php if ( isset($atts['description']) ) { ?>
    <input type="hidden" name="PAYMENTREQUEST_0_DESC" value="<?php echo $atts['description']; ?>" />
  <?php } ?>
  <input type="hidden" name="func" value="start" />
  <input type="submit" value="Pay with PayPal" />
</form>