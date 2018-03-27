<?php 
include "bootstrap.php";
include "csv.php";

// init db, get db name
$db = JFactory::getDBO();
$dbPrices = $db->quoteName("#__multifactories_prices_excel");
$db->setquery( "TRUNCATE $dbPrices");
$db->execute(); 

// 1. parse csv file
$importer = new CsvImporter("data/Capmex-import-price_27.08.17.csv", true); 
$rows = $importer->get();
// var_dump($rows);

// 2. import products
foreach ($rows as $product) {
  $query = "INSERT INTO $dbPrices VALUES"; 
  $product_id = array_shift($product);
  // if($product_id != 0)var_dump($product_id); 
  if ($product_id == 0) continue;
  foreach ($product as $sub => $price ) {
    $query .= "($product_id, '$sub', $price),";
  }
  $db->setquery(substr($query, 0, -1) . " on duplicate key update price=values(price)");
  $db->execute(); 
}
