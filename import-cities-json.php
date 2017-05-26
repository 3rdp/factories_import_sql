<?php 
define( '_JEXEC', 1 );
define( 'DS', DIRECTORY_SEPARATOR );
define( 'JPATH_BASE', "/var/www/html/capmex.dev/public_html" ); 
require_once JPATH_BASE . DS . 'includes'   . DS . 'defines.php';
require_once JPATH_BASE . DS . 'libraries'  . DS . 'import.php';
require_once JPATH_BASE . DS . 'configuration.php'; 
require_once JPATH_BASE . '/includes/framework.php';
// $mainframe =& JFactory::getApplication('site'); // optional. it will generate html, which is not great for console scripts

$db = JFactory::getDBO();
$dbname = $db->quoteName('#__multifactories_crudfactories');

$query = "INSERT INTO $dbname (name, alias) VALUES \n";
$cities = json_decode(file_get_contents("factories.json"));
foreach($cities as $city) {
    $query .= "('$city->name', '$city->alias'),\n";
}
$query = substr_replace($query, ";", -2, -1);
$db->setQuery($query);
$result = $db->execute();
echo $result;
