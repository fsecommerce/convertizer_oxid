<?php
/**
 * Convertizer Oxid Modul
 * @link        http://www.fs-ecommerce.com
 * @author      Martin Ketelhut
 * @copyright   (C) FS eCommerce GmbH 2016
 * @module      convertizer
 * @version     03.03.2016 V1.1
 */

class convertizer__oxviewconfig extends convertizer__oxviewconfig_parent {

	public function getConvertizerTrackingId(){
		return oxRegistry::getConfig()->getConfigParam('ConvertizerTrackingId'); 
	}
	
	public function isConvertizerTrackingActive(){
		return oxRegistry::getConfig()->getConfigParam('ConvertizerTracking'); 
	}
}
