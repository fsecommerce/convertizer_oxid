[{$smarty.block.parent}]

[{* Convertizer Tracking Integration *}]

<script type="text/javascript">

[{if $oViewConf->isConvertizerTrackingActive() && $oViewConf->getActiveClassName() == 'thankyou'}]

		[{assign var="order" value=$oView->getOrder()}]
        [{assign var="dTotalOrdersum" value=$order->oxorder__oxtotalbrutsum->value}]
        [{assign var="dTotalOrdersumNetto" value=$order->oxorder__oxtotalnetsum->value}]
        [{assign var="dOrderTax" value=$dTotalOrdersum-$dTotalOrdersumNetto}]

/* FS eCommerce Convertizer Tracking Code*/
//<![CDATA[
	var trackingid 	= '[{$oViewConf->getConvertizerTrackingId()}]'; //CUSTOMER TRACKING ID
	var amount		= '[{$dTotalOrdersum}]'; //GRAND TOTAL - TAX AMOUNT - SHIPPING AMOUNT
	var ordertype	= 1; //ORDER TYPE
        var orderid = '[{$order->oxorder__oxordernr->value}]'; //ORDER ID
	(function(){
		var js = document.createElement('script');
			js.type = 'text/javascript';
			js.async = true;
			js.src = ('https:' == document.location.protocol ?
'https://' : 'http://') + 'app.convertizer.com/static/convertizer.js';
		var tag = document.getElementsByTagName('script')[0];
		tag.parentNode.insertBefore(js, tag);
	})();
//]]>
/* Convertizer Tracking Code*/
 [{/if}]
</script>