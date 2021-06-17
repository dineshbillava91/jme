<?php
include_once('library/constants.php');
class DB {
     function DB() {
          $this->db = mysql_connect (HOSTNAME, DBUSERNAME, DBPASS)
           or DIE ("Unable to connect to Database Server");
          mysql_select_db (DBNAME,$this->db) or DIE ("Could not select database");
     }
}
$db=new DB();