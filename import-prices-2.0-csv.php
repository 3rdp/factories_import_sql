<?php 
include "bootstrap.php";
include "csv.php";

// init db, get db name
$db = JFactory::getDBO();
$dbPrices = $db->quoteName("#__multifactories_prices_excel");

// 1. parse csv file
$importer = new CsvImporter("data/Capmex-import-price_13.08.17.csv", true); 
$rows = $importer->get();
// var_dump($rows);

// 2. import this s**t
foreach ($rows as $product) {
  $query = "INSERT INTO $dbPrices VALUES"; 
  $product_id = array_shift($product);
  // if($product_id != 0)var_dump($product_id); 
  if ($product_id == 0) continue;
  foreach ($product as $sub => $price ) {
    $query .= "($product_id, '$sub', $price),";
  }
  $db->setQuery(substr($query, 0, -1) );
  $db->execute(); 
}
