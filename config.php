<?php

$server = ''; //set test

 $datadb = array();

 $datadb['user'] = "";
 $datadb['pass'] = "";
 $datadb['db']  = "";
 $datadb['host'] = "localhost";

 /*$wp_db = mysqli_connect($datadb['host'],$datadb['user'],$datadb['pass'], $datadb['db_wp']);*/

$datadb['MAIN_SQL_CONNECT'] = mysqli_connect($datadb['host'],$datadb['user'],$datadb['pass'],$datadb['db']);
 

 
 ?>