<?php 

date_default_timezone_set("America/Caracas");

require_once 'config.php';
require_once 'phpMySQLBackup.php';
require_once 'dropboxupload.php';

$filename = backup_tables(DATABASE_URL, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
$result = upload_dropbox($dropbox, APP_DIR_PATH . $filename, sprintf('%s/%s/%s/%s/%s', APP_DOMAIN, DATABASE_NAME, date('Y'), date('m'), $filename ), DELETE_LOCAL);

print_r($result);
