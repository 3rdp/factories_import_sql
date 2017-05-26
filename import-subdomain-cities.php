<?php 
include 'bootstrap.php';

$db = JFactory::getDBO();
$dbNameFactories = $db->quoteName("#__multifactories_crudfactories");
$getFactories_query = "SELECT * FROM $dbNameFactories";
$db->setQuery($getFactories_query);
$factories = $db->loadObjectList();
var_dump($factories);
