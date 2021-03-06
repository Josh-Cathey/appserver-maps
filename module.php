<?php

use Html\Html as Html;

class MapModule extends Module
{
	public function __construct()
	{
		parent::__construct();

		$this->name = "map";
	}

	function home()
	{
		$tpl = new MapTemplate("map");
		$tpl->addPath(__DIR__ . "/templates");

		return $tpl;
	}

	function getMemberData()
	{
		// From config/config.php
		global $oauth_config;

		$saleforce = new Salesforce($oauth_config);
		$assets = $saleforce->createQueryFromSession('SELECT Name, Ocdla_Member_Status__c, Phone, Email, MailingAddress, Ocdla_Current_Member_Flag__c, Ocdla_Is_Expert_Witness__c ' .
			'FROM Contact WHERE Ocdla_Current_Member_Flag__c = true');	//  AND Ocdla_Member_Status__c = R

		return $assets;
	}

	/**
	 * Need to update courts to this method call,
	 * 	currently using Courts.js -> getCourts()
	 */
	function getCourtData()
	{
		$data = file_get_contents('../modules/maps/assets/data/circuitcourts.json');
		$jsonData = json_decode($data, true);

		return $jsonData;
	}
}
