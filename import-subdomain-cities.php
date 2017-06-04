<?php 
include 'bootstrap.php';

$db = JFactory::getDBO();
$dbNameFactories = $db->quoteName("#__multifactories_crudfactories");
$dbMultidomen_excel = $db->quoteName("#__multidomen_excel");
$dbCity = $db->quoteName("#__multifactories_city");

// 0. get all the factories
$getFactories_query = "SELECT * FROM $dbNameFactories";
$db->setQuery($getFactories_query);
$factories = $db->loadObjectList();
// var_dump($factories);

// 1. get all the subdomains. columns: subdomain_name, `[[gorod-samovyvoz]]`
$query = "SELECT subdomain_name, `[[gorod-samovyvoz]]` FROM $dbMultidomen_excel";
$db->setQuery($query);
$subdomains = $db->loadAssocList();
// var_dump($subdomains);

// 2. match gorod… with name of the factory to get its id. if no match, print and skip.
$factoriesLength = count($factories);
$cityArray = array();
$failed = array();
foreach ($subdomains as $subdomain) { // for each subdomain
    $subdomain_gorod = $subdomain["[[gorod-samovyvoz]]"];
    $subdomain_name = $subdomain["subdomain_name"];
    for ($i = 0; $i < $factoriesLength; $i++) {// iterate factories
        $factory = $factories[$i];
        if ($factory->name == $subdomain_gorod) {// if match, push to array. index: sub, value: factory_id
            // echo $factory->name . " " . $subdomain["subdomain_name"] . "\n";
            // echo "success\n";
            $cityArray[$subdomain_name] = $factory->id;
        }
    }
    if (!isset($cityArray[$subdomain_name])) // if no match, print and skip
        // array_push($failed, $subdomain_gorod);
        $cityArray[$subdomain_name] = 2;
}
// var_dump($cityArray);
// $countFailed = count($failed);
// $failed = array_unique($failed);
// var_dump($failed);
// var_dump($countFailed);
// var_dump(count($cityArray));


// 3. assemble and execute the query
$query = "INSERT INTO $dbCity VALUES ";
foreach($cityArray as $sub => $factory_id) {
    $query .= "('$sub', $factory_id), ";
}
$query = substr($query, 0, -2);
$db->setQuery($query);
$db->execute();
