<?php 
include "bootstrap.php";
include "csv.php";

// init db, get db name
$db = JFactory::getDBO();
$dbFactory = $db->quoteName("#__multifactories_crudfactories");
$dbPrices = $db->quoteName("#__multifactories_prices");

// 0. get all the factories
$getFactories_query = "SELECT * FROM $dbFactory";
$db->setQuery($getFactories_query);
$factories = $db->loadObjectList();

// 1. parse csv file
$importer = new CsvImporter("data/import-capmex-price-21-city.csv",true); 
$rows = $importer->get();
// var_dump($rows);

$dataLength = count($rows);
foreach($rows as $prices) {                             // get row - product
    $query = "INSERT INTO $dbPrices VALUES ";
    foreach($factories as $factory) {                   // iterate over columns (factories)
        $price = new stdClass();
        $price->product_id = (int)$prices["product_id"];
        $price->factory_id = (int)$factory->id;
        $price->price      = (int)$prices[$factory->alias];
        $arrPrice = array($price->product_id, $price->factory_id, $price->price);
        $query .= "(" . join(", ", $arrPrice) . "), ";  // form query for that product
    }
    $db->setQuery(substr($query, 0, -2));
    $db->execute();                                     // execute
    echo $dataLength-- . "\n";
}
