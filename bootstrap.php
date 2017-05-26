<?php 
define( '_JEXEC', 1 );
define( 'DS', DIRECTORY_SEPARATOR );
define( 'JPATH_BASE', "/var/www/html/capmex.dev/public_html" ); 
require_once JPATH_BASE . DS . 'includes'   . DS . 'defines.php';
require_once JPATH_BASE . DS . 'libraries'  . DS . 'import.php';
require_once JPATH_BASE . DS . 'configuration.php'; 
require_once JPATH_BASE . '/includes/framework.php';
// $mainframe =& JFactory::getApplication('site'); // optional. it will generate html, which is not great for console scripts
