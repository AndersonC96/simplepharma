<?php
   $database = 'simplepharma';
   $host = 'localhost';
   $user = 'root';
   $pass = '';
   $dbh = new PDO("mysql:dbname={$database};host={$host};port={3306}", $user, $pass);
   if(!$dbh){
      echo "unable to connect to database";
   }
?>