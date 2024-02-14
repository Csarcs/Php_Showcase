<?

function loadcontentpanel($panel,$data){
	

	if($panel == 'data_lockers'){
		
		
		
		
		

			$query = "SELECT * FROM lockers ORDER BY date DESC";

			$result = mysql_query($query);  
			$i=0;
			while($r = mysql_fetch_array($result)){  
			$i++;
			
			}
		
		$content ='';
		$content .= ''.$i;
		
		
		return $content;

	}
	

	if($panel == 'data_envios'){
		
		
		
		
		

			$query = "SELECT * FROM envios ORDER BY date DESC";

			$result = mysql_query($query);  
			$i=0;
			while($r = mysql_fetch_array($result)){  
			$i++;
			
			}
		
		$content ='';
		$content .= ''.$i;
		
		
		return $content;

	}	

	if($panel == 'data_general'){
		
		
		
		
		

			$query = "SELECT * FROM envios WHERE (MONTH(date) > MONTH(".Now('') .")) AND (MONTH(date) < MONTH(".date("Y-m-t", strtotime(Now(''))).")) ORDER BY date";

			$result = mysql_query($query);  
			$i=0;
			while($r = mysql_fetch_array($result)){  
			$i++;
			
			}
		
		$content ='';
		$content .= ''.$i;
		
		
		return $content;

	}
	
	
	



}
?>
