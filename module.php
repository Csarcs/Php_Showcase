<? 

$need_admin = true;
$need_login = true;  
include_once('../header.php'); 

if(isset($_GET['serial'])){
		  
		  if(OnlyOne('envios','serial', $_GET['serial'])){
			  
			  header("Location: ".$site_url."panel/");
		  }
}

	 if(isset($_GET['do'])){
		 
		 
		 if($_GET['do'] == 'pntocontrol'){
			 new MainHeader('CHECKPOINTS - Admin Panel'); 
		 }else{
		 new MainHeader(strtoupper($_GET['do']).' - Admin Panel');
		 }

		 
	 }else{
		 new MainHeader('Admin Panel');
		 
	 }
	 

global $site_url;



?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

<body class="admin-panel">
    <header>
        <div class="navbar">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?=$site_url; ?>panel/"></a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
  
					<form id="data" data-action="search">
					
				<div class="main-search-container">
					<label></label>
					<input class="form-control" name="main-search" type="text" placeholder="Buscar" id="autocomplete">
				</div>
			
                    </form>
                </div>

            </div>
        </div> <!-- end of navigation -->

    </header> <!-- end of header -->
<style>
.stadistic-section .load-panel{
	display:none;
}
</style>
	<section class="admin-panel-container col-md-12">

        <div class="col-md-12">						<div class="col-md-12" style="text-align:right;">

			<b><?=$u['name']." ".$u['lastname']; ?> </b> <a href="<?=$site_url; ?>out.php" class="btn btn-danger"> <i class="fa fa-lock"></i> Cerrar Sesión</a>

		</div>
		<div class="menu" id="navbar">
	
		
		<div class="menu-item"><a href="<?=$site_url; ?>panel/"><i class="fa fa-tachometer" aria-hidden="true"></i> Inicio</a></div>
		<? if($u['level'] > 5){ ?>	
		<div class="menu-item"><a href="<?=$site_url; ?>panel/index.php?do=users" class="admin"><i class="fa fa-user"></i> Usuarios</a></div>	
		<? } ?>
	
		</div>
		</div>
		
		
		<? $module = $_GET['do']; load_module_content($module); ?>
 


	</section>

    <footer>


        <div class="row copyright">
            <div class="container">
                <div class="col col-sm-9">
                      <p>Todos los derechos reservados</p>
                </div>

                <div class="col col-sm-3">
                   
                </div>
            </div>
        </div>
    </footer>  
	 
   
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="<?=$site_url; ?>js/owl.carousel.min.js"></script>
    <script src="<?=$site_url; ?>js/nivo-lightbox.min.js"></script>
    <script src="<?=$site_url; ?>js/jquery.appear.js"></script>
    <script src="<?=$site_url; ?>js/common-script.js"></script>
    <script src="<?=$site_url; ?>js/core.script.js"></script>
    <script src="<?=$site_url; ?>js/main.script.js"></script>
	

		

</body>
</html>



<?
 function load_module_content($module){
	 global $u, $site_url;
	 		global $datadb;
	 switch($module){

		 case 'users':
		 
		 ?>
		 		<div class="header">

		
		
		<div class="title">
		<h2><i class="fa fa-user"></i> Usuarios</h2>
		</div>
		 </div>
		 
		        <div class="col-md-12 users-list">

		<a class="btn btn-default pull-right"  data-toggle="modal" data-target="#panel-add-user" style="margin-bottom:10px;"> <i class="fa fa-plus" aria-hidden="true"></i> Crear Usuario</a>
	

	
	
		

		

			<?  

	

			$query = "SELECT * FROM usuarios ORDER BY date DESC";

			$result = mysqli_query($datadb['MAIN_SQL_CONNECT'],$query);  

			while($r = mysqli_fetch_array($result)){  

			?>

	

	

	<div style="display:block;width:100%;height:200px" class="profile-item-list <?=$r['id']; ?>" id="<?=$r['id']; ?>">

	<div class="pull-left">

	<h3></h3>

	<b>ID:</b> <?=$r['id']; ?><br>

	<b>Name and lastname:</b> <?=$r['name']; ?> <?=$r['lastname']; ?><br>

	<b>Email:</b> <?=$r['email']; ?><br>

	<b>Phone:</b> <a href="tel:<?=$r['phone']; ?>"><?=$r['phone']; ?></a><br>

	</div>	

	<div class="pull-right">

	<a href="#" class="btn btn-success item-details"  data-id="<?=$r['id']; ?>"  data-panel="show_data_users" data-modal="#panel-edit-user">Editar</a>
	
	<a href="#" class="btn btn-primary add-password" data-id="<?=$r['id']; ?>">Cambiar Clave</a>

	<a href="#" class="btn btn-warning contact_user" data-id="<?=$r['id']; ?>">Contactar</a>

	<a href="#" class="btn btn-danger delete-item" data-id="<?=$r['id']; ?>" data-panel="usuarios">Borrar</a>

	</div>

	</div>

	

			<? load_form_modal("Editar Usuario","panel-edit-user","Editar Usuario","edit_exist_users"); }?>

			
		

		</div>
			
	<div class="modal fade" id="panel-add-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
   <form id="data" data-action="register">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Crear Usuario</h4>
      </div>
	  
	  
      <div class="modal-body">




		
		<div class="form-group">
			<div class="col-md-4">
							<label>Nombre: </label>
							</div>
							<div class="col-md-8">
							<input type="text" name="name" class="form-control" placeholder="Nombre">
							
			</div>
		</div>		
		
		<div class="form-group">
			<div class="col-md-4">
							<label>Correo: </label>
							</div>
							<div class="col-md-8">
							<input type="text" name="email" class="form-control" placeholder="Correo electronico">
							
			</div>
		</div>
		
				
		<div class="form-group">
			<div class="col-md-4">
							<label>Telefono: </label>
							</div>
							<div class="col-md-8">
							<input type="text" name="phone" class="form-control" placeholder="Telefono">
							
			</div>
		</div>
		
		


		<div class="form-group">
			<div class="col-md-4">
							<label>Clave: </label>
							</div>
							<div class="col-md-8">
						<input type="password" name="password" class="form-control" placeholder="Ingresa la clave">
							
			</div>
		</div>		
		
		
		<div class="form-group">
			<div class="col-md-4">
							<label>Repetir la clave: </label>
							</div>
							<div class="col-md-8">
				<input type="password" name="repassword" class="form-control" placeholder="Repite la contraseña">
							
			</div>
		</div>		
					


					<div class="form-group">
			<div class="col-md-4">
							<label>Nivel: </label>
							</div>
							<div class="col-md-8">
					<select name="level" class="form-control" placeholder="Seleccione...">
			<option value="0">Seleccione...</option>
				<?
		
		for($i=5;$i<8;$i++){
			
			?>
			<option value="<?=$i; ?>"><?=readLvl($i);?></option>
			
			<?
		}
			?>
		
		</select>
							
			</div>
		</div>		

		
		
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Crear Usuario</button>
      </div>
    </div>
	</form>
  </div>
</div>
	


		 
		 <?
		 
		 
		 break;
		 
		 
	
		 	 default:
		 
		 
		 ?>
		<div class="header">

		
			<div class="title">
					<h2><i class="fa fa-tachometer" aria-hidden="true"></i> Home</h2>
					</div>
		 </div>
		 
		 <div id="index-main-home" class="col-md-12">
		 
		 
	
		 
		 
		 
		 
		 
		 </div>
		 
		 
		 <?
		 
	 }
	 
	 
	 
 }

 
 

function load_form_modal($title,$e, $btn, $action){ ?>
	

<div class="modal fade" id="<?=$e; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
   <form id="data" data-action="<?=$action; ?>">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?=$title; ?><span  id="title"></span></h4>
      </div>
	  
	  
      <div class="modal-body">
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary"><?=$btn; ?></button>
      </div>
    </div>
	</form>
  </div>
</div>

	<? } 

function load_info_modal($title,$e){ ?>
	
	<div class="modal fade" id="panel-info<?=$e; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?=$title; ?><span  id="title"></span></h4>
      </div>
	  
	  
      <div class="modal-body">


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar Ventana</button>

      </div>
    </div>

  </div>
</div>
	<? } ?>
