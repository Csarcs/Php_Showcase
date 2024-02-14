<?

require('../panel/actions.php');
	
if($_POST && $_POST['action']){
	
	    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    
    
        $output = json_encode(
        array(
            'text' => 'Error en el sistema.'
        ));
        
        die($output);
		
		}
		
		
		if(!function_exists( $_POST['action'])){
			failed('Error de acceso.',0);
		}
		
		
		$_POST['action']($_POST);
				
				




		
		
				
}

$m_panel = $_POST['panel'];
if($m_panel){
	loadpanel($_POST);
}

?>
