<?php 

//Dropbox Parameters
define('DROPBOX_APP_KEY', 'a12bcde3fgh4567');
define('DROPBOX_APP_SECRET', '1abcdefg23ghijkl');

//MySQL Database parameters
define('DATABASE_URL', 'localhost');
define('DATABASE_USER', 'user');
define('DATABASE_PASSWORD', 'password');
define('DATABASE_NAME', 'mydatabase');

/** ******************* 
 * DON'T TOUCH ABOVE *
 ******************* */
define('APP_DIR_PATH', dirname(__FILE__) . '/backups/');
define('APP_DOMAIN', str_replace('www.', '', $_SERVER['HTTP_HOST']););