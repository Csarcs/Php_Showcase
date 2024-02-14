<?
 

/*-----------------  START SETTINGS --------------



*/
if($_GET['currency']==""){
		if($_SESSION["coin"]!=""){
	$gcurrency = $_SESSION["coin"];
		}


}else{
	
$gcurrency = $_GET['currency'];

	
}


$gln = "";

if(!$_GET['ln']){
if(!isset($_SESSION["lenguage"] )){
	$gln = $_GET['ln'];
}else{
	
	$gln = $_SESSION["lenguage"];
}
}else{
	$gln = strtoupper($_GET['ln']);
}

if($gln == ""){
	$_SESSION["lenguage"] = 'EN';
}

if($gln == 'ES'){
	$_SESSION["lenguage"] = 'ES';
}

if($gln == 'EN'){
	$_SESSION["lenguage"] = 'EN';
}

function sendData_curl( $fields, $url){

		$ch = curl_init();

		
	$instapago_headers = array( 
            "POST /Payment HTTP/1.1", 
            "Content-type: application/x-www-form-urlencoded", 
            "Accept: json", 
            "Cache-Control: no-cache", 
	
        ); 
		
		

		curl_setopt($ch, CURLOPT_HTTPHEADER, $instapago_headers);
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($fields));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


		$server_output = curl_exec ($ch);
		curl_close ($ch);
		return $server_output;


}



if($gcurrency==""){
$_SESSION["coin"] = 'VEF';
}elseif($gcurrency == 'EUR'){
	$_SESSION["coin"] = 'EUR';
}elseif($gcurrency == 'VEF'){
	$_SESSION["coin"] = 'VEF';
}elseif($gcurrency == 'USD'){
	$_SESSION["coin"] = 'USD';
}


/*-----------------  PRICES --------------
*/
/*
global $price_host;
global $currency_value;
*/
//All prices in USD
$price_host['startup'] = '3.59';

$price_host['multimedia'] = '5.65';
$price_host['business'] = '7.00';
$price_host['corporate'] = '8.8';

//Currency values respect USD	

$currency_value['dolar'] = '30000';
$currency_value['euro'] = '1.12';



/*-----------------  FUNCTIONS --------------
*/






function checkPlan($plan){

	global $price_host;
	foreach($price_host as $v => $ph){
		if($v == $plan){
			return true;
		}
	}
	

		
			return false;


}	

function getPricePlan($plan){
	
	global $price_host;
	
	return $price_host[$plan];
	
}
	

// Precios

function getPrice($price){
global $currency_value;

	
	$coin = $_SESSION["coin"];
	
if($coin == 'USD'){
	return 'USD '.number_format($price, 2, ',', '.');
}

if($coin == 'VEF'){
	$price = ceil($price*$currency_value['dolar']);
	$aux = substr($price,-2);
	$price = ($price - $aux);
	if($aux > 50){
	$price = $price+50;
	}
	
	return number_format($price, 0, ',', '.').' Bs.';
}

if($coin == 'EUR'){
	$price = ceil($price*$currency_value['euro']);
	
	return '€ '.number_format($price, 2, ',', '.');
}

}



// Idiomas
function _lg($lna, $lnb){
	$lenguage = $_SESSION["lenguage"];
	
	if($lenguage == 'EN'){
		$ln = $lna;
	}elseif($lenguage == 'ES'){
		$ln = $lnb;
	}

	return $ln;	
	
}

function _ln($lna, $lnb){

	echo _lg($lna, $lnb);
	
}

// Varias...
function loadmore_hostgenopt(){
	
	?>
	<li class="check"><? _ln('24/7 Support','Soporte 24/7'); ?></li>
	<li class="check"><? _ln('<b style="color:orange">cPanel</b>','<b style="color:orange">cPanel</b>'); ?></li>
	<li class="check"><? _ln('Free Instalation','Instalación Gratuita'); ?></li>
	<li class="check"><? _ln('Apps Installer','Instalador de Aplicaciones'); ?></li>
	
	
	
	
	<?
}


function type_services(){
	$t = array();
	
	$t[10] = _lg('Domains','Dominios');
	$t[11] = _lg('Hosting','Hospedaje Web');
	$t[1] = _lg('Corporate Website','Sitio Web Corporativo');
	$t[2] = _lg('Landing Page','Portal Referencial');
	$t[3] = _lg('eCommerce Shop','Tienda Virtual');
	$t[4] = _lg('Press, Blog & News','Portal de Contenidos');
	$t[5] = _lg('Gallery Website','Galeria de Medios');
	$t[6] = _lg('Multimedia Project','Proyecto Multimedía');
	$t[8] = _lg('Social Media Managment','Manejo de Redes Sociales');
	$t[9] = _lg('Graphic Design','Diseño Grafico');
	$t[12] = _lg('Payment Gateway','Pasarela de Pago');
	
	return $t;
	
}



function html_text($a){
	
	 return $a; 
}



function getCountries(){
	
	include_once('inc.countries.php');
	
	
	$country = new Countries();
	

	
	return $country->paises();
	
	
	
	
}

function RandomString($w, $length){
	if($w && $w = 'num'){
		$characters = '123456789';
	}else{
		$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	}
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}



function getNewEnvioTracking($locker, $w){
	
	$ld = getRow('lockers','id',$locker);
	$ld_data = unserialize($ld['data']);

	$name = $ld_data['name'];

	$n = explode(" ",$name);

	$f = $n[0];

	if($n[1]){
	$l = $n[1];
	}

	$f = strtoupper($f);
	$l = strtoupper($l);

	
    $wl = sizeOf($w);

		do{

			$serial = date('dmyHis')."-".RandomString(0, 5) ."".RandomString('num', 2)."-".$w[0]."".$w[$wl]."".$f[0]."".$l[0];
	
		}while(!OnlyOne('envios', 'serial', $serial));
		
		
		return $serial;
	
}



function getId($t,$tdb, $term){
	
	
	if($t == 'tiny'){
		
		do{
			$id = TinyId();
		}while(!OnlyOne($tdb, $term, $id));
		
	}	
	
	if($t == 'md5'){
		
		do{
			$id = md5(RandomId());
		}while(!OnlyOne($tdb, $term, $id));
		
	}
	
	
	if(!$t){
		
		do{
			$id = RandomId();
		}while(!OnlyOne($tdb, $term, $id));
		
	}
	
	
	
	
	return $id;
}



function resize_image($source_file, $dst_dir,$max_width, $max_height ){
	
	$quality = 80;
	
    $imgsize = getimagesize($source_file);
    $width = $imgsize[0];
    $height = $imgsize[1];
    $mime = $imgsize['mime'];
 
    switch($mime){
        case 'image/gif':
            $image_create = "imagecreatefromgif";
            $image = "imagegif";
            break;
 
        case 'image/png':
            $image_create = "imagecreatefrompng";
            $image = "imagepng";
            $quality = 7;
            break;
 
        case 'image/jpeg':
            $image_create = "imagecreatefromjpeg";
            $image = "imagejpeg";
            $quality = 80;
            break;
 
        default:
            return false;
            break;
    }
     
    $dst_img = imagecreatetruecolor($max_width, $max_height);
    $src_img = $image_create($source_file);
     
    $width_new = $height * $max_width / $max_height;
    $height_new = $width * $max_height / $max_width;
    //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
    if($width_new > $width){
        //cut point by height
        $h_point = (($height - $height_new) / 2);
        //copy image
        imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
    }else{
        //cut point by width
        $w_point = (($width - $width_new) / 2);
        imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
    }
     
    $image($dst_img, $dst_dir, $quality);
 
    if($dst_img)imagedestroy($dst_img);
    if($src_img)imagedestroy($src_img);

	return true;
}





function readPanelData($data){
	$a = explode("&",$data['main']);
	
	$w = array();
	
	foreach($a as $x){
		
	$b = explode("=",$x);
	
	$w[$b[0]] = $b[1];
	
	
	}
	
	return $w;
}



function getDayAmount($db_date, $o){
	
	global $u, $datadb;
				$query = "SELECT * FROM pagos WHERE DATE(date) = '$db_date' && parent = ".$o; 
					$sql2 = mysqli_query($datadb['MAIN_SQL_CONNECT'],$query);
						while($l = mysqli_fetch_array($sql2)){	
			
			
							$m += $l['amount'];
							
						}
						
						return $m;
							
}


function tooltip($m){
	
	return ' data-toggle="tooltip" data-placement="top" title="'.$m.'" data-original-title="'.$m.'"';
}


function readResponseBankCode($x){
	

	include('inc.banks.php');
	
	$b = new banksVE();
	$c = $b->getResponseCode();
	
	
	foreach($c as $code => $v){
		
		if($x == $code){
			return $v;
		}
		
		
	}
	
	
	
}

	
	
function checkFill($f){
	
	global $u;

	if(!empty($f['f'])){
			return $f['v'];
		}else{
			return '0';
		}	
}



function createSession(){
	
	session_start();
		
	$sid = getId('md5','sessions','sid');
	
	$ip = getRealIp();
	$date = Now('date');
	$time = Now('time');
	
	
	$phpsid = session_id();
	
	$session = array(
	'sid' => $sid,
	'phpsid' => $phpsid,
	'ip' => $ip,
	'date' => $date,
	'time' => $time,
	'status' => 0,
	);
	
	$_SESSION[$sid] = $session;
	
	return $session;
	
}

function setSession($s){
	
	if(OnlyOne('sessions','sid',$s['sid'])){
		addRow('sessions',$s);
		return true;
	}else{
		return false;
	}
}


function success($m, $aux){
	$f = array();
	$f = readKillArray($aux);
	
	$f['text'] = $m;
	$f['notification'] = true;
	$f['type'] = 'success';
	
	
	
	kill($f);
}


function getBankName($n){
	
	$b = new banksVE();
	$x = $b->banks();
	return $x[$n];
		
		
	
	
}

function getAccountType($n){
	
	$b = new banksVE();
	$x = $b->typeName($n);
	return $x;
		
		
	
	
}



function inputText($e, $t){
	
	if($e){
		return 'value="'.$e.'"'; 
	}else{
		return 'placeholder="'.$t.'"';
	}
	
}


function send_Email($content, $subject, $to){
	
	global $site_url;
	
	
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			
			
			if(is_array($to) && $to['name'] && isValidEmail($to['email'])){ 
			
			$headers .= "To: ".$to['name']." ".$to['lastname']." <".$to['email'].">\r\n"; 
			$recipent = $to['email'];
			
			}else if(isValidEmail($to)){
				
				$headers .= "To: <".$to.">\r\n"; 	
				$recipent = $to;
			
			}
			
			$headers .= "From: Creative Solutions <no-reply@cs.com.ve>\r\n";
			
			
			
			
			$message = "<html style='margin:0;padding:0;'><body style='margin:0;padding:0;'>";
			$message .= "<div style='width:100%;background:#232323;padding:10px 10px;margin-bottom:10px;box-sizing:border-box;'><img alt='Creative Solutions' width='250px' height='auto' src='".$site_url."images/logo.png'>";
			$message .= "</div>";
			
			
			
			$message .= "<div style='padding:20px;width:100%;box-sizing:border-box;'>";
			$message .= $content;
			
			
			$message .= "<p style='color:#ccc;font-weight:bold;font-size:0.9em;'>-----------------------------------------<br>";
			$message .= "Este correo electronico, ha sido generado de manera automatica por nuestra plataforma.<br> Si usted no ha realizado ninguna solicitud desde nuestro sitio web, ignorelo y si lo desea puede comunicarse con nosotros para mas información.<br><br>Creative Solutions C.A. © 2016 - rif. J-40472001-4<br><a href='tel:00584248978276'>+58 414 8063664</a> <a href='tel:00582812812634'>+58 281 2812634</a> / <a href='https://www.cs.com.ve/'>www.cs.com.ve</a> /  <a href='mailto:soporte@cs.com.ve'>soporte@cs.com.ve</a><br> C.C. Mar Pacifico, Nivel 1, ML-02, Lechería, Edo. Anzoategui, Venezuela.</p>";
		
		
			$message .= "</div>";
			
			
			$message .= "</body>";
			$message .= "</html>";
			 


	
	mail($recipent,$subject,$message,$headers);
	
	
	return true;
	
	
}


function addRow($t, $a){
	global $datadb;
	$i = 0;
	
	foreach($a as $x => $v){
		
		if($i){
					
		$l .= ",".$x."";
		$lv .= ",'".$v."'";
		
		}else{
				
		$l .= "".$x."";
		$lv .= "'".$v."'";	
		
		}

		$i++;
		
}

	$query = "INSERT INTO $t ($l) VALUES ($lv)";

	return  mysqli_query($datadb['MAIN_SQL_CONNECT'],$query);

}


function get64($img){
$type = pathinfo($img, PATHINFO_EXTENSION);
$data = file_get_contents($img);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

return $base64;
}


function categories(){

	$cat = array(
		'6156592' => 'Servicios',
		'5648247' => 'Viajes y Turismo',
		'4865652' => 'Moda, vestuario y accesorios',
		'3999569' => 'Repuestos y autopartes',
		'9738712' => 'Liquidos y quimicos',
		'5222271' => 'Animales y Mascotas',
		'3854478' => 'Juegos y Juguetes',
		'2577262' => 'Teléfonos y Tablets',
		'6379526' => 'Computación',
		'4896362' => 'Relojes, Joyas y Bisutería',
		'3141859' => 'Electrónica, Audio y Video',
		'1298333' => 'Libros, Música y Películas',
		'1418247' => 'Consolas y Videojuegos',
		'4898482' => 'Industrias',
		'8516248' => 'Electrodomésticos',
		'4363186' => 'Deportes y Fitness',
	);

	return $cat;

}



function failed($m, $aux){
	
	$f = array();
	
	$f = readKillArray($aux);
	

	$f['text'] = $m;
	$f['notification'] = true;
	$f['type'] = 'failed';
	
	
	
	kill($f);
}



function kill($k){
	
	die(json_encode($k));
	
}

function readKillArray($aux){
	
	if(is_array($aux)){
		foreach($aux as $a => $v){
			$f[$a] = $v;
		}
		
		return $f;
	}
	
	
}


function crypt_cs($password){

        $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
        return crypt($password, $salt);
 
}


function unserializeForm($str) {
    $returndata = array();
    $strArray = explode("&", $str);
    $i = 0;
    foreach ($strArray as $item) {
        $array = explode("=", $item);
        $returndata[$array[0]] = $array[1];
    }

    return $returndata;
}


function is_serialized2( $data ) {
    // if it isn't a string, it isn't serialized
    if ( !is_string( $data ) )
        return false;
    $data = trim( $data );
    if ( 'N;' == $data )
        return true;
    if ( !preg_match( '/^([adObis]):/', $data, $badions ) )
        return false;
    switch ( $badions[1] ) {
        case 'a' :
        case 'O' :
        case 's' :
            if ( preg_match( "/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data ) )
                return true;
            break;
        case 'b' :
        case 'i' :
        case 'd' :
            if ( preg_match( "/^{$badions[1]}:[0-9.E-]+;\$/", $data ) )
                return true;
            break;
    }
    return false;
}

function paises(){
	

$paises = array(
		"Afghanistan",
		"Albania",
		"Algeria",
		"Andorra",
		"Angola",
		"Antigua and Barbuda",
		"Argentina",
		"Armenia",
		"Australia",
		"Austria",
		"Azerbaijan",
		"Bahamas",
		"Bahrain",
		"Bangladesh",
		"Barbados",
		"Belarus",
		"Belgium",
		"Belize",
		"Benin",
		"Bhutan",
		"Bolivia",
		"Bosnia and Herzegovina",
		"Botswana",
		"Brazil",
		"Brunei",
		"Bulgaria",
		"Burkina Faso",
		"Burundi",
		"Cambodia",
		"Cameroon",
		"Canada",
		"Cape Verde",
		"Central African Republic",
		"Chad",
		"Chile",
		"China",
		"Colombia",
		"Comoros",
		"Congo (Brazzaville)",
		"Congo",
		"Costa Rica",
		"Cote d'Ivoire",
		"Croatia",
		"Cuba",
		"Cyprus",
		"Czech Republic",
		"Denmark",
		"Djibouti",
		"Dominica",
		"Dominican Republic",
		"East Timor (Timor Timur)",
		"Ecuador",
		"Egypt",
		"El Salvador",
		"Equatorial Guinea",
		"Eritrea",
		"Estonia",
		"Ethiopia",
		"Fiji",
		"Finland",
		"France",
		"Gabon",
		"Gambia, The",
		"Georgia",
		"Germany",
		"Ghana",
		"Greece",
		"Grenada",
		"Guatemala",
		"Guinea",
		"Guinea-Bissau",
		"Guyana",
		"Haiti",
		"Honduras",
		"Hungary",
		"Iceland",
		"India",
		"Indonesia",
		"Iran",
		"Iraq",
		"Ireland",
		"Israel",
		"Italy",
		"Jamaica",
		"Japan",
		"Jordan",
		"Kazakhstan",
		"Kenya",
		"Kiribati",
		"Korea, North",
		"Korea, South",
		"Kuwait",
		"Kyrgyzstan",
		"Laos",
		"Latvia",
		"Lebanon",
		"Lesotho",
		"Liberia",
		"Libya",
		"Liechtenstein",
		"Lithuania",
		"Luxembourg",
		"Macedonia",
		"Madagascar",
		"Malawi",
		"Malaysia",
		"Maldives",
		"Mali",
		"Malta",
		"Marshall Islands",
		"Mauritania",
		"Mauritius",
		"Mexico",
		"Micronesia",
		"Moldova",
		"Monaco",
		"Mongolia",
		"Morocco",
		"Mozambique",
		"Myanmar",
		"Namibia",
		"Nauru",
		"Nepa",
		"Netherlands",
		"New Zealand",
		"Nicaragua",
		"Niger",
		"Nigeria",
		"Norway",
		"Oman",
		"Pakistan",
		"Palau",
		"Panama",
		"Papua New Guinea",
		"Paraguay",
		"Peru",
		"Philippines",
		"Poland",
		"Portugal",
		"Qatar",
		"Romania",
		"Russia",
		"Rwanda",
		"Saint Kitts and Nevis",
		"Saint Lucia",
		"Saint Vincent",
		"Samoa",
		"San Marino",
		"Sao Tome and Principe",
		"Saudi Arabia",
		"Senegal",
		"Serbia and Montenegro",
		"Seychelles",
		"Sierra Leone",
		"Singapore",
		"Slovakia",
		"Slovenia",
		"Solomon Islands",
		"Somalia",
		"South Africa",
		"Spain",
		"Sri Lanka",
		"Sudan",
		"Suriname",
		"Swaziland",
		"Sweden",
		"Switzerland",
		"Syria",
		"Taiwan",
		"Tajikistan",
		"Tanzania",
		"Thailand",
		"Togo",
		"Tonga",
		"Trinidad and Tobago",
		"Tunisia",
		"Turkey",
		"Turkmenistan",
		"Tuvalu",
		"Uganda",
		"Ukraine",
		"United Arab Emirates",
		"United Kingdom",
		"United States",
		"Uruguay",
		"Uzbekistan",
		"Vanuatu",
		"Vatican City",
		"Venezuela",
		"Vietnam",
		"Yemen",
		"Zambia",
		"Zimbabwe"
	);
	 
	
	$a = array();
	$i = 0;
	foreach($paises as $p => $v){
		$a[$i++] = $v;
	}
	
	return $a;
}
	 
function detectCardType($num){

    $re = array(
        "visa"       => "/^4[0-9]{12}(?:[0-9]{3})?$/",
        "mastercard" => "/^5[1-5][0-9]{14}$/",
        "amex"       => "/^3[47][0-9]{13}$/",
        "discover"   => "/^6(?:011|5[0-9]{2})[0-9]{12}$/",
    );

    if (preg_match($re['visa'],$num)){
		return 'visa';
    }else if (preg_match($re['mastercard'],$num)){
		return 'mastercard';
    }else{
        return false;
    }
	
 }
  
 	
function getCC_IMG($name){
	global $site_url;
	
	return ' <img width="30px" height="auto" src="'.$site_url .'images/'.$name.'-icon.png">';
	
 }
	
	
function bankVoucher($v){
		return htmlspecialchars_decode($v);
			
}

function recrypt($a, $b){
	return crypt($a, $b) == $b;
}

function getActive($a,$b){
	if($a==$b) return 'active';
}

function getActive_sb($a,$b){
//	if($a==$b) return 'data-open-after="true"';
}

function showDay($m){
	switch ($m){
		case 1:
			return "Lunes";
		break;
		
				case 2:
			return "Martes";
		break;
		
				case 3:
			return "Miercoles";
		break;
				
				case 4:
			return "Jueves";
		break;
		
				case 5:
			return "Viernes";
		break;
		
				case 6:
			return "Sabado";
		break;
		
				case 7:
			return "Domingo";
		break;
	}
	
}

function showMonth($m){
	
	switch ($m){
		
		case 1:
			return "Enero";
		break;
		
				case 2:
			return "Febrero";
		break;
		
				case 3:
			return "Marzo";
		break;
				
				case 4:
			return "Abril";
		break;
		
				case 5:
			return "Mayo";
		break;
		
				case 6:
			return "Junio";
		break;
		
				case 7:
			return "Julio";
		break;
		
				case 8:
			return "Agosto";
		break;
		
				case 9:
			return "Septiembre";
		break;
		
				case 10:
			return "Octubre";
		break;
		
				case 11:
			return "Noviembre";
		break;
		
				case 12:
			return "Diciembre";
		break;
		
	}
	
}

function admin_checkMaster(){
	
		global $u;
			
		if($u['level'] < 7){
				failed("Nivel de acceso no autorizado.",0);
			
		}
		
}


function isValidEmail($email){ 
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}


function showTrackingStatus($a){
	
	$m = array();
	
	switch ($a){
		case 1:
			$m['status'] = 'Guía Creada';
			$m['label'] = '<span class="label label-success">'.$m['status'].'</span>';
		break;
		
		case 2:
			$m['status'] = 'Revisión';
			$m['label'] = '<span class="label label-warning">'.$m['status'].'</span>';
		break;
		
		case 3:
			$m['status'] = 'En Transito';
			$m['label'] = '<span class="label label-success">'.$m['status'].'</span>';
		break;	
		
		case 4:
			$m['status'] = 'En Deposito';
			$m['label'] = '<span class="label label-success">'.$m['status'].'</span>';
		break;		
		
		case 5:
			$m['status'] = 'Aduana';
			$m['label'] = '<span class="label label-warning">'.$m['status'].'</span>';
		break;		

		case 6:
			$m['status'] = 'Disponible';
			$m['label'] = '<span class="label label-success">'.$m['status'].'</span>';
		break;	
		
		case 7:
			$m['status'] = 'Despachado';
			$m['label'] = '<span class="label label-success">'.$m['status'].'</span>';
		break;	

		
		case 8:
			$m['status'] = 'Retirado por el cliente';
			$m['label'] = '<span class="label label-success">'.$m['status'].'</span>';
		break;	
		
		case 9:
			$m['status'] = 'Esperando Confirmaci&oacute;n';
			$m['label'] = '<span class="label label-danger">'.$m['status'].'</span>';
		break;		
		
	}
	
	return $m;
	
}

function showEnvioType($a){
	
	$m = array();
	
	switch ($a){
		case 1:
			$m['status'] = 'Aereo';
			$m['label'] = '<span class="label label-primary">'.$m['status'].'</span>';
		break;
		
		case 2:
			$m['status'] = 'Maritimo';
			$m['label'] = '<span class="label label-success">'.$m['status'].'</span>';
		break;
	
		
	}
	
	return $m;
	
}

function showOpenedNoti($a){
	
	$m = array();
	
	switch ($a){
		case 1:
			$m['status'] = 'En Espera';
			$m['label'] = '<span class="label label-primary">'.$m['status'].'</span>';
		break;
		
		case 2:
			$m['status'] = 'Confirmada';
			$m['label'] = '<span class="label label-success">'.$m['status'].'</span>';
		break;	
		
		case 0:
			$m['status'] = 'Por Revisar';
			$m['label'] = '<span class="label label-danger">'.$m['status'].'</span>';
		break;
	
		
	}
	
	return $m;
	
}




function getDatetimeNow() {
	
	setlocale(LC_TIME, 'es_VE', 'es_VE.utf-8', 'es_VE.utf8');
    $tz_object = new DateTimeZone('America/Caracas');
    $datetime = new DateTime();
    $datetime->setTimezone($tz_object);
    return $datetime->format('Y-m-d H:i:s');
}




function Now($w){	

	
	switch($w){
		
		case 'date':
		
		$now_date = dateTerm(Now(''),'date');
		
		break;
		
		case 'time':

		$now_date = dateTerm(Now(''),'time');
		break;
		
		default:
		
		$now_date = getDatetimeNow();
	}
	
	
	return $now_date;
}

function noContent($c){
	
	return '<div class="no-content">'.$c.'</div>';
}


function divContent($style, $cn,$c){
	
	return '<div class="'.$cn.'" '.$style.'>'.$c.'</div>';
}

function dateTerm($a, $b){
	
	switch($b){

	case 'date':
	return date("Y-m-d", strtotime($a)); 
	break;	
	
	case 'date_b':
	return showDay(date('N', strtotime($a))).' '.date('d', strtotime($a)).', '.showMonth(date('n', strtotime($a))).' '.date('Y', strtotime($a)); 
	break;	
	
	case 'time_b':
	return date('h:i A', strtotime($a)); 
	break;
	
	case 'time':
	return date("h:m:s", strtotime($a));
	break;

	case 'onlym':
	return date("m", strtotime($a));
	break;
	
	case 'onlyd':
	return date("d", strtotime($a));
	break;
	
	default:
	 return date($b, strtotime($a));
	}
	
	
}

function createFolder(){

if (!file_exists("../uploads/".date('m-Y')."/")) {
    mkdir("../uploads/".date('m-Y')."/", 0755);

}

}

function checkImg($file_type){
	
	$file_type = strtolower($file_type);
	if($file_type == 'image/jpeg' OR $file_type == 'image/png' OR  $file_type == 'image/gif' OR $file_type == 'image/jpg'){
		return true;
	}else{
		return false;
	}
	
}

function revertDate($a){
	$a = explode("-", $a);
	
	return $a = $a[2] . '-' . $a[1] . '-' . $a[0];
}

function timeFormat($a){
	
	return date('h:ia', strtotime($a));
	
}

function dateFormat($a){
	return date("h:ma d/m/Y", strtotime($a));
}

function md5Id($z){
	
	$a = substr($z,0,4); 
	$b = substr($z,-5);
	$reference_id = $a."...".$b;
										
										
	return '<button title="Referencia" data-original-title="" type="button" class="btn btn-default popovers"  data-toggle="popover" data-placement="top" data-content="'.$z.'">'.$reference_id.'</button>';
}
 
function readLvl($a){
	
	switch ($a){
		
		case 7: $lvl = "Administrador"; break;		
		case 6: $lvl = "Gerente"; break;
		case 5: $lvl = "Encargado/a"; break;
		case 4: $lvl = "VIP"; break;
		case 3: $lvl = "Asistente"; break;
		case 2: $lvl = "Moderador"; break;
		case 1: $lvl = "Usuario"; break;
		default: $lvl = "Bloqueado/a";
		
	} 
	
	return $lvl;
	
}

 


function OnlyOne($table,$a,$b){
	global $datadb;
			$query = "SELECT * FROM $table WHERE $a = '$b'";
            $existe = mysqli_num_rows(mysqli_query($datadb['MAIN_SQL_CONNECT'], $query));
			if($existe == 0 ){ 
				return true; 
			}else{
				return false; 
			}
}

function countRows($table,$a,$b,$opt){
	global $datadb;
			if($opt){
			$query = "SELECT * FROM ".$table;
			}else{
			$query = "SELECT * FROM $table WHERE $a = '$b'";
			}
			

	       return  mysqli_num_rows(mysqli_query($datadb['MAIN_SQL_CONNECT'], $query));
					
}


function getRealIp(){
	if (!empty($_SERVER['HTTP_CLIENT_IP']))
			return $_SERVER['HTTP_CLIENT_IP'];
		
	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
	
		return $_SERVER['REMOTE_ADDR'];
}


function RandomId(){
	$rand = 7;	
	$r = rand(1, 9);
	for($i=0; $i<$rand-2 ; $i++){
		$r .= "".rand(1, 9);
	}
	$r.="".rand(1, 9);	
	return $r;
}

function TinyId(){
	$rand = 5;	
	$r = rand(1, 9);
	for($i=0; $i<$rand-2 ; $i++){
		$r .= "".rand(1, 9);
	}
	$r.="".rand(1, 9);	
	return $r;
}


function getSelected($a,$b){
	
	if($a == $b) return "selected";
	
	}

	
function update($z,$array,$c,$d){	
	
	global $ve_db,$datadb;
	
	$sql = array();		
	foreach($array as $field => $value){	
	$sql[] = "\n".$field."" ." = "."'".$value."'";
	}		
		
	$sql = implode(",",$sql);
	
	$query = "UPDATE $z SET $sql WHERE $c = '$d'" ;
	
	
	if($z == 'estados' || $z == 'ciudades'){
			
	 mysqli_query($ve_db,$query);
		
	}else{
		
		
	mysqli_query($datadb['MAIN_SQL_CONNECT'],$query);
	
	}
}	

function getData($table,$setfield, $field, $showfield){	

			global $datadb;	
			
			$query = "SELECT * FROM $table WHERE $setfield = '$field'"; 
			
       		$show = mysqli_fetch_array(mysqli_query($datadb['MAIN_SQL_CONNECT'], $query));
			
			return $show[$showfield];
			
}

function getRow($table,$setfield, $field){	
global $datadb;	
			$query = "SELECT * FROM $table WHERE $setfield = '$field'"; 
			
       		$show = mysqli_fetch_array(mysqli_query($datadb['MAIN_SQL_CONNECT'], $query));
			
			return $show;
			
}

function checkText($field){
 $permitidos = "nñNÑáéíóúüöäëïÁÉÍÓÚabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ "; 
for ($i=0; $i<strlen($field); $i++){ 
if (strpos($permitidos, substr($field,$i,1))===false){ 
//no es válido; 
return false; 
} 
}  
//si estoy aqui es que todos los caracteres son validos 
return true; 

}


function checkTextNum($field){
 $permitidos = "nñNÑáéíóúüöäëïÁÉÍÓÚabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ 0123456789,."; 
for ($i=0; $i<strlen($field); $i++){ 
if (strpos($permitidos, substr($field,$i,1))===false){ 
//no es válido; 
return false; 
} 
}  
//si estoy aqui es que todos los caracteres son validos 
return true; 

}
			
			


?>