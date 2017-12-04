<?php
class WebLog {

    private static $logInstance;

    public static function getInstance() {
        if (!isset(self::$logInstance)) {
            //change the directory path so its not visible over the web
            $logInstance = KLogger::instance(dirname(__FILE__) . '/log', KLogger::INFO);
        }
        return $logInstance;
    }

}

require_once('../main.inc.php');

function GetDatabaseConnection() {
    global $db_connection;
  //  $db_host = "localhost"; // Host name
  //  $db_username = "root"; // Mysql username
   // $db_password = "whishworks@123"; // Mysql password
  //  $db_name = "dbbaseline"; // Database name

    $db_host = DBHOST; // Host name
    $db_username =DBUSER; // Mysql username
    $db_password = DBPASS; // Mysql password
    $db_name = DBNAME; // Database name

    if ($db_connection)
        return $db_connection;
    $db_connection = mysql_connect($db_host, $db_username, $db_password) or die('Could not connect to server.');
    mysql_select_db($db_name, $db_connection) or die('Could not select database.');
    return $db_connection;
}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
