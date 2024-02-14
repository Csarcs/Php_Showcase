<?
session_start();


$site_url = ""; 
/*------------------ MAIN VARS ------------------*/

/*
$currency_value = array();
$currency_value['dolar'] = '200';
$currency_value['euro'] = '1.12';
$currency_value['mul'] = ((((15/5)+(21/7))*2)/4);
*/

setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8');


$actual_sub_page = "";

include_once('config.php');
include_once('functions.php');



$sid = $_SESSION['sid'];
$do = $_GET['do'];

if(isset($sid)){	

$active_session = true;
$userid = getData('sessions','sid',$sid,'uid');
$sidStatus = getData('sessions','sid',$sid,'status');
$u = getRow('usuarios','id', $userid);
$u['sid'] = $sid;


class U{
	public function u(){
		global $u;
		return $u;
	}
	
}

}

if($need_admin && $u['level'] < 5){
	
	header("Location: ../out.php");

}

include_once('actions.php');


	if($notlogin && isset($sid)){	

		
			header("Location: panel/");	
	}else{		
		if($need_login && (!isset($sid) OR $sidStatus==1 OR !isset($sidStatus))){	
			$back = "../access.php?back=".$_SERVER['REQUEST_URI'];	
			header("Location: $back");
		}
	}	

?>