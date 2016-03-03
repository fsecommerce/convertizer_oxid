<?php
/**
 * Convertizer Oxid Modul
 * @link        http://www.fs-ecommerce.com
 * @author      Martin Ketelhut
 * @copyright   (C) FS eCommerce GmbH 2016
 * @module      convertizer
 * @version     03.03.2016 V1.1
 */


/**
 * Metadata version
 */
$sMetadataVersion = '1.1';

/**
 * Module information
 */
$aModule = array(
    'id'          => 'skutobasket',
    'title'       => 'Convertizer',
    'description' => 'This module enables your convertizer landingpage to add products directly to cart from the landingpage',
	'thumbnail'    => 'convertizer.png',
    'version'     => '1.1',
	'email'	  => 'mketelhut@fs-ecommerce.com',
	'url'		  => 'www.fs-ecommerce.com',
    'author'      => 'Martin Ketelhut',
    'extend'      => array(
        'oxcmp_basket'        => 'convertizer/skutobasket/components/skutobasket',
		'oxviewconfig'	=> 'convertizer/skutobasket/core/convertizer__oxviewconfig',
    ),
    'files' => array (
    ),
    'templates' => array(
    ),
    'settings' => array(
    	array('group' => 'main', 'name' => 'ConvertizerTrackingId', 'type' => 'str', 'value' => ''),
        array('group' => 'main', 'name' => 'ConvertizerTracking', 'type' => 'bool', 'value' => 'false'),
    ),
    'blocks' => array(
        array('template' => 'layout/base.tpl', 'block' => 'head_css', 'file' => '/views/blocks/convertizer_tracking.tpl' ),
    ),
);
