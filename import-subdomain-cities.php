<?php 
include 'bootstrap.php';

$db = JFactory::getDBO();
$dbNameFactories = $db->quoteName("#__multifactories_crudfactories");

// 0. get all the factories
$getFactories_query = "SELECT * FROM $dbNameFactories";
$db->setQuery($getFactories_query);
$factories = $db->loadObjectList();
var_dump($factories);

// 1. get all the subdomains. columns: subdomain_name, `[[gorod-samovyvoz]]`
// 2. match gorod… with name of the factory to get its id. if no match, print and skip.
// 3. assemble and execute the query
