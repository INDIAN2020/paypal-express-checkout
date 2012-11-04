<form method="post" action="<?php echo $config->getItem('plugin_form_handler_url'); ?>">
  <input type="hidden" name="AMT" value="<?php echo $atts['amount']; ?>" />
  <input type="hidden" name="CURRENCYCODE" value="<?php echo $atts['currency']; ?>" />
  <?php if ( isset($atts['description']) ) { ?>
    <input type="hidden" name="PAYMENTREQUEST_0_DESC" value="<?php echo $atts['description']; ?>" />
  <?php } ?>
  
  <?php if ( isset($atts['tax']) ) { ?>
    <input type="hidden" name="TAXAMT" value="<?php echo $atts['tax']; ?>" />
  <?php } ?>
  
  <?php if ( isset($atts['shipping']) ) { ?>
    <input type="hidden" name="SHIPPINGAMT" value="<?php echo $atts['shipping']; ?>" />
  <?php } ?>
  
  <?php if ( isset($atts['handling']) ) { ?>
    <input type="hidden" name="HANDLINGAMT" value="<?php echo $atts['handling']; ?>" />
  <?php } ?>
  
  <?php if ( isset($atts['qty']) ) { ?>
    <input type="hidden" name="PAYMENTREQUEST_0_QTY" value="<?php echo $atts['qty']; ?>" />
  <?php } ?>
  
  <input type="hidden" name="func" value="start" />
  <input type="submit" value="Pay with PayPal" />
</form>