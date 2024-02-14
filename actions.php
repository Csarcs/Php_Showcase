<?
include_once('core.php');

function loadpanel($data){
	
	include('datapanel.php');	
	
	$panel = $data['panel'];
	$content = loadcontentpanel($panel, $data);
	
	
	kill(
		array(
		'type'=>'success',
		'content'=>$content,
		));

	
}

function show_data_users($data){
		success('Categoría agregada con exito.',array(
					'modal'=>'#panel-edit-user',
					'update'=>true,
					'reload_loadpanel'=>true,
					));
}

function del_list($data){
	
	
	global $u;
global $datadb;
	
	$id = $data['id'];
	$table = $data['list'];
	
	$row = 'id';
	
	if(!OnlyOne($table,$row,$id)){

	mysqli_query($datadb['MAIN_SQL_CONNECT'],"DELETE FROM ".$table." WHERE $row = '$id'");  	
	success("Registro eliminado con exito.",0);	
	}
}


function contact_request($data){
			
			if(!isValidEmail($data['email'])){
				failed(_lg('Invalid email address','Correo invalido'),0);
			}
			
			
					
		
			if(!$data['name']){
				failed(_lg('Type a name','Coloca un nombre'),0);
			}	
			
			if(!$data['subject']){
				failed(_lg('Type a subject','Coloca un mensaje'),0);
			}		
			
			if(!$data['phone'] && !is_numeric($data['phone'])){
						failed(_lg('Invalid phone number','Numero de telefono invalido'),0);
			}

	
		$s = $data['subject'];
		
		$content = _lg("<h2>Contact Message</h2><p>Thank you <b>".$data['name']."</b>, We are pleased that our services are of your interest .</p><p>Very soon we will be communicating with you to give you more information about your application.<p><p><b>Email:</b><br>".$data['email']."<br><b>Phone:</b><br>".$data['phone']."</p><p><b>Subject:</b><br>".$s."</p><p><b>Message:</b><br>".$data['message']."</p>","<h2>Contacto desde el sitio web</h2><p>Gracias <b>".$data['name']."</b>, estamos complacidos de que nuestros servicios sean de tu interes.</p><p>Muy pronto estaremos comunicandonos contigo para darte más información sobre tu mensaje.<p><b>Email Suministrado:</b><br>".$data['email']."<br><b>Telefono suministrado:</b><br>".$data['phone']."</p><p><b>Asunto:</b><br>".$s."</p><p><b>Mensaje:</b><br>".$data['message']."</p>");
		

		$to = array('name'=>$data['name'],
					'lastname'=>'',
					'email'=>$data['email'],
					);
					
		send_Email($content,_lg("Message from Website - ","Mensaje desde el Sitio Web - ").$s, $to);	
		send_Email($content,_lg("Message from Website - ","Mensaje desde el Sitio Web - ").$s, "cs@cs.com.ve");
		
		success(_lg('Your message was sent successfully','Tu mensaje se ha enviado con exito'),array('update'=>true));
	
}

function request_website($data){
		
		$serv = type_services();
			
			if(!isValidEmail($data['email'])){
				failed(_lg('Invalid email address','Correo invalido'),0);
			}
			
			
					
			if(!$data['type']){
				failed(_lg('Select a services','Selecciona un servicio'),0);
			}		
			
			if(!$data['name']){
				failed(_lg('Type a name','Coloca un nombre'),0);
			}		
			
			if(!$data['phone'] && !is_numeric($data['phone'])){
						failed(_lg('Invalid phone number','Numero de telefono invalido'),0);
			}

		$i = $data['type'];
		$s = $serv[$i];
		
		$content = _lg("<h2>Request Information</h2><p>Thank you <b>".$data['name']."</b>, We are pleased that our services are of your interest .</p><p>Very soon we will be communicating with you to give you more information about your application.<p><p>Services Required:<br><h3>".$s."</h3></p><p><b>Email:</b><br>".$data['email']."<b><br><b>Phone</b>:<br><b>".$data['phone']."<br></p>","<h2>Solicitud de información</h2><p>Gracias <b>".$data['name']."</b>, estamos complacidos de que nuestros servicios sean de tu interes.</p><p>Muy pronto estaremos comunicandonos contigo para darte más información sobre el servicio solicitado.<p><p>Servicio Solicitado:<br><h3>".$s."</h3></p><p><b>Email Suministrado:</b><br>".$data['email']."</b><br><b>Telefono suministrado:</b><br>".$data['phone']."<br></p>");
		
		
		
		
		$to = array('name'=>$data['name'],
					'lastname'=>'',
					'email'=>$data['email'],
					);

		send_Email($content,_lg("Services Request - ","Solicitud de Servicio - ").$s, $to);	
		send_Email($content,_lg("Services Request - ","Solicitud de Servicio - ").$s, "cs@cs.com.ve");
		
		success(_lg('Your request was sent successfully','Tu solicitud se ha enviado con exito'),array('update'=>true));
	
}

function login_user($data){
	
	
	
	$password = $data['password'];
	$username = $data['username'];
	$backurl = $data['backurl'];

	if(strpos($username,'@')){
		$username_field = 'email';
	}else{
		$username_field = 'username';
	}
	
	
	
	if(empty($username)){
		
		failed("Enter your email o username.",0);
	
	}
	
	if(empty($password)){
		failed("Enter your password.",0);
	}
	
	
	if(getdata('usuarios',$username_field,$username ,'active')){	
	
	failed("Usuario bloqueado.",0);

	}
	
	
	
	
	if(!OnlyOne('usuarios',$username_field,$username)){
		
	$password_db = getdata('usuarios',$username_field,$username ,'password');
		
	if(recrypt($password,$password_db)){
		
	$uid = getdata('usuarios',$username_field,$username ,'id');
				
	$session = createSession();
	
	$session['uid'] = $uid;
	
	setSession($session);
	
	
	
	update('usuarios', array('active_data'=>serialize($session)) ,'id', $uid);
	
	$_SESSION['sid'] = $session['sid'];
	
	if(empty($backurl)){
		
		if(5 < getdata('usuarios',$username_field,$username ,'level')){

		$backurl = 'access.php';
	
		}else{
		
		$backurl = 'access.php';		
			
		}

	}
	
	
	success("Bienvenido/a ".strtoupper($username).".<br><b> Seras redirigido en un se23424gundo...</b>",array('url' => $backurl));

	}else{
	
	failed("Invalid password.",0);
		
	}
		
	}else{
		
	failed("User dont ewqeqwerxist.",0);
		
	}
	
}


function cal_price($data){
	

	
	global $price_host;
	$proceed_host = false;
	
	$plan = $data['plan'];
	
	
	if($data['period'] == 1){
		
		$result_period = 6;
		
	}else if($data['period'] == 2){
		
		$result_period = 12;
		
	}else{
		
		failed('Error estableciendo el periodo de duración del servicio.',0);
		
	}
	
	
	if(!checkPlan($plan)){
				failed('Plan invalido.',0);
	}
			
	

	$plan_price = $price_host[$plan];
	

	$result = array();
	

	
	
	$result['mainprice'] = $plan_price*$result_period;
	$result['plan_price'] = $plan_price;
	
	
		
		
	$result['text_mainprice'] = getPrice($plan_price*$result_period);
	$result['text_plan_price'] = getPrice($plan_price);
	
	
	
	$result['plan'] = $plan;
	$result['period'] = $result_period;
	$result['new_price'] = true;
	
	$_SESSION['checkout_data'] = $result;
	
	success('Calculo exitoso',$result);
	
}



function checkout_my_form($data){
	
	
	global $price_host;
	
	
	$cd = $_SESSION['checkout_data'];
	
	
	$period = $data['period_value'];
/*	
	
	if($period == 12 && $data['period'] != 2){
		failed('Plan invalido.',0);
		
	}
		
	if($period == 6 && $data['period'] != 1){
		failed('Plan invalido.',0);
		
	}
*/
			
			if(!checkPlan($data['plan'])){
				failed('Plan invalido.',0);
			}
			
		
		
	$mp = getPricePlan($data['plan']);
	$tp = $mp*$data['period_value'];
		
		

	
	if(!($data['name']) or !($data['phone']) or !($data['cardnumber']) or !($data['cardname']) or !($data['exp_month']) or !($data['exp_year']) or !($data['domain']) or !($data['document']) or !($data['_document'])){
		

		failed("Todos los campos son requeridos para continuar.",0);
		
		
	}else if(!$data['email']){
		
		failed("Ingresa un correo electronico.",0);

	}else if(!$data['cvc']){
		
		failed("Ingresa el codigo secreto de la tarjeta.",0);

	}else{
		
	if(!isValidEmail($data['email'])){
		
		failed('Correo electronico invalido.',0);
		
		
	}
				
	if(!is_numeric($data['phone'])){
		
		failed('Numero telefonico invalido.',0);
		
		
	}
						
	if(!is_numeric($data['document']) && $data['document']!='NA'){
		
		failed('Documento de identidad invalido.',0);
		
		
	}	
	
	if(!is_numeric($data['cardnumber'])){
		
		failed('Numero de tarjeta de credito invalido.',0);
		
		
	}

	
	if(!detectCardType($data['cardnumber'])){
		
		failed('Tarjeta de credito invalida o no aceptada.',0);
		
	}
	
		
	if(!is_numeric($data['exp_year']) or !is_numeric($data['exp_month']) ){
		
		failed('Numero de tarjeta de credito invalido.',0);
		
		
	}
		

	
	$date = $data['exp_year'].'-'.$data['exp_month'];
	
	
	$date1 = date("Y-m", strtotime($date));
	$date2 = date("Y-m");
	
 
	if($date1 <= $date2) { 
 
					failed('Tarjeta de credito vencida.',0);
			
 
	}
	
		
	if(strlen($data['cvc']) != 3 or !is_numeric($data['cvc'])){
			
		failed('Codigo secreto de la tarjeta invalido.',0);
			
	}
	
	$token = md5(date("dmYhmsi"));
	$main_data = array();
	$main_data['document'] = $data['document'];
	$main_data['name'] = $data['name'];
	$main_data['email'] = $data['email'];
	$main_data['phone'] = $data['phone'];
	$main_data['domain'] = $data['domain'];
	$main_data['period_value'] = $data['period_value'];
	$main_data['period'] = $data['period'];
	$main_data['plan'] = $data['plan'];
	$main_data['plan_price'] = $mp;
	$main_data['total'] = $tp;
	$main_data['date'] = Now('');
	$main_data['cardtype'] = detectCardType($data['cardnumber']);
	$main_data['cardnumber'] = $data['cardnumber'];
	$main_data['cardname'] = $data['cardname'];
	$main_data['cvc'] = $data['cvc'];
	$main_data['expiration'] = $data['exp_month'].'/'.$data['exp_year'];
	$main_data['token'] = $token;
	$_SESSION['main_data_checkout'] = $main_data;
	
	
	success("Datos procesados con exito, confirma tu orden.",
															array('url'=>'confirm?token='.$token));
		
		
		
	}
	
	
}


function confirm_this_checkout($data){
	
	global $currency_value;
	
	
	$data = $_SESSION['main_data_checkout'];
	
	
	
	$fields = array(
	"KeyID" => "01A46EC3-A1F5-4C50-8477-4A77461CA1DE",
	"PublicKeyId" => "c34fb1ddc9efd4a953271302d8de8b1f", 
	"Amount" => $data['total']*$currency_value['dolar'],
	"Description" => "Pago Hospedaje ".strtoupper($data['plan'])." / ".strtoupper($data['email'])." - Creative Solutions C.A.",
	"CardHolder"=> strtoupper($data['cardname']),
	"CardHolderId"=> $data['document'],
	"CardNumber" => $data['cardnumber'],
	"CVC" => $data['cvc'],
	"ExpirationDate" => $data['expiration'],
	"StatusId" => 1,
	"IP" => getRealIp(),
	);
	
	
	
	 $responde = sendData_curl( $fields, 'https://api.instapago.com/payment');
	 $response = json_decode($responde);
	 
	 
	 if($response->{success}){
		 
		 
		 
	$_SESSION['main_data_checkout'] = null;
	$_SESSION['checkout_data'] = null;
	 
	
	 $t = $data['token'];
	 $_SESSION['token']  = $t;
	 $_SESSION['data_'.$t]  = $data;
	 $_SESSION['payment_'.$t]  = $response;
	 
	 
		success("Pago aprobado con exito.",array(
												'url'=>'done?action=success&token='.$t,
																						));
	
	 }else{
		  
		failed($response->{message},0);
		
	 }
	 
	 
	
}


function checkCardType($data){
	
	
	
	if(!$data['val']){
		
		failed('Ingresa un numero de tarjeta de credito',array(
								'card'=> 'credit-card-alt'));
		
		
	}
	
	
	$c = detectCardType($data['val']);
	
	if($c == 'mastercard'){
		
		
		$card_text = 'cc-mastercard';
		$text_alert = 'Tarjeta Mastercard';
		
		
		
	}else if($c == 'visa'){
		
		$card_text = 'cc-visa';
		$text_alert = 'Tarjeta Visa';
		
	}else{
		
		
		failed('Tarjeta de credito invalida o no aceptada.',array(
																	'card'=> 'credit-card-alt'));
		
	}
	
	
	success(0,array(
								'card'=> $card_text));
	
}

?>