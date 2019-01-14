<?php
/**
 * Template Name: Concurso Page
 * @package trendmap_theme
 */

  //response generation function
  $response = "";



   function query($sql,$accion) {

      $hostname	= 'localhost';
      $database	= 'trendmap';
      $username	= 'trendm3662';
      $password	= 'ha03fs7ppq88';

      $conex = mysql_connect($hostname,$username,$password) or die ("no se puede conectar".mysql_error());

      mysql_select_db($database);

		        $error = 0;
		mysql_query("BEGIN");
		$result=mysql_query($sql,$conex);
		if ($accion && $result) {
			$result = mysql_insert_id();
		}
		if(!$result){
			$error=1;
		}
		if($error==1){
			mysql_query("ROLLBACK");
			return false;
		}
		 else{
			mysql_query("COMMIT");
			return $result;
		}

	}

   function insertarFormularios($refrespuestas,$nombre,$apellido,$telefono,$email,$aceptacondiciones,$opcion2,$opcion3,$leyenda1,$leyenda2,$leyenda3) {
   $sql = "insert into dbformularios(idformulario,refrespuestas,nombre,apellido,telefono,email,aceptacondiciones,opcion2,opcion3,leyenda1,leyenda2,leyenda3)
   values ('',".$refrespuestas.",'".($nombre)."','".($apellido)."','".($telefono)."','".($email)."',".$aceptacondiciones.",".$opcion2.",".$opcion3.",'".($leyenda1)."','".($leyenda2)."','".($leyenda3)."')";
   $res = query($sql,1);
   return $res;
   }

   function traerLeyendasUna() {
   $sql = "select
   l.idleyenda,
   l.leyenda1,
   l.leyenda2,
   l.leyenda3,
   l.baseslegales
   from tbleyendas l
   order by 1 desc
   limit 1";
   $res = query($sql,0);
   return $res;
   }
   $resLeyendas = traerLeyendasUna();

   $leyenda1 = mysql_result($resLeyendas,0,'leyenda1');
   $leyenda2 = mysql_result($resLeyendas,0,'leyenda2');
   $leyenda3 = mysql_result($resLeyendas,0,'leyenda3');

   $bases = mysql_result($resLeyendas,0,'baseslegales');

 //include ('../../../sistema/includes/funcionesReferencias.php');

  //function to generate response
  function my_contact_form_generate_response($type, $message){

    global $response;

    if($type == "success") $response = "<div class='success'>{$message}</div>";
    else $response = "<div class='error'>{$message}</div>";

  }

  //response messages
  $not_human       = __("Verificaciñon de humano incorrecta.. Estas seguro que no eres un robot?.",'trendmap_theme');
  $missing_content = __("Falta ingresar parte del contenido requerido",'trendmap_theme');
  $email_invalid   = __("Por favor ingresa una direccion de correo valida.",'trendmap_theme');
  $message_unsent  = __("El mensaje no se envió, por favor intenta nuevamente.",'trendmap_theme');
  $message_sent    = __("Gracias, por participar recibimos tu mensaje.",'trendmap_theme');
  $message_opciones= __("Debe aceptar todas las condiciones.",'trendmap_theme');



  $human = $_POST['message_human'];

  //php mailer variables
  //$to = get_option('admin_email');
  $to = 'hola@trendmap.es';
  $subject = "Mensaje desde el formulario de contacto de: ".get_bloginfo('name');
  $headers = 'From: '. $email . "\r\n" .
    'Reply-To: ' . $email . "\r\n";

/*
   if(isset($_POST['g-recaptcha-response'])){
      $captcha=$_POST['g-recaptcha-response'];
   }

  $secretKey = "6LeZPiQTAAAAAO6c58NHKQphUZks2ZHuQUTxybxL";
  $ip = $_SERVER['REMOTE_ADDR'];
  $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
  $responseKeys = json_decode($response,true);
*/

   if (intval($_POST['submitted'])===1){
      //user posted variables
      $nombre = $_POST['nombre'];
      $apellido = $_POST['apellido'];
      $email = $_POST['email'];
      $telefono = $_POST['telefono'];
      $aceptacondiciones = $_POST['baseslegales'];
      $opcion2 = $_POST['opcion2'];
      $opcion3 = $_POST['opcion3'];
      // validate email
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
         my_contact_form_generate_response("error", $email_invalid);
      }
      //validate presence of name and message
      if(empty($nombre) || empty($apellido) || empty($email)){
         my_contact_form_generate_response("error", $missing_content);
      }
      else
      {
         if (!(isset($aceptacondiciones)) && !(isset($opcion2)) && !(isset($opcion3))) {
            my_contact_form_generate_response("error", $message_opciones);
         } else {  //ready to go!
            $dato = insertarFormularios(1,$_POST['nombre'],$_POST['apellido'],$_POST['telefono'],$_POST['email'],1,1,1,$leyenda1,$leyenda2,$leyenda3);

            my_contact_form_generate_response("success", $message_sent);

            //send email
            /*
            $sent = wp_mail($to, $subject, strip_tags($message), $headers);
            if ($sent) my_contact_form_generate_response("success", $message_sent); //message sent!
            else my_contact_form_generate_response("error", $message_unsent); //message wasn't sent

            */


         }

      }


   }

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<h1 class="page-title"><?php the_title(); ?></h1>
      <style>
         /* Customize the label (the container) */
         .container {
           display: block;
           position: relative;
           padding-left: 35px;
           margin-bottom: 12px;
           cursor: pointer;
           font-size: 22px;
           -webkit-user-select: none;
           -moz-user-select: none;
           -ms-user-select: none;
           user-select: none;
         }

         /* Hide the browser's default checkbox */
         .container input {
           position: absolute;
           opacity: 0;
           cursor: pointer;
           height: 0;
           width: 0;
         }

         /* Create a custom checkbox */
         .checkmark {
           position: absolute;
           top: 0;
           left: 0;
           height: 25px;
           width: 25px;
           background-color: #eee;
         }

         /* On mouse-over, add a grey background color */
         .container:hover input ~ .checkmark {
           background-color: #ccc;
         }

         /* When the checkbox is checked, add a blue background */
         .container input:checked ~ .checkmark {
           background-color: #2196F3;
         }

         /* Create the checkmark/indicator (hidden when not checked) */
         .checkmark:after {
           content: "";
           position: absolute;
           display: none;
         }

         /* Show the checkmark when checked */
         .container input:checked ~ .checkmark:after {
           display: block;
         }

         /* Style the checkmark/indicator */
         .container .checkmark:after {
           left: 9px;
           top: 5px;
           width: 5px;
           height: 10px;
           border: solid white;
           border-width: 0 3px 3px 0;
           -webkit-transform: rotate(45deg);
           -ms-transform: rotate(45deg);
           transform: rotate(45deg);
         }
      </style>
		<div class="row">
			<div class="col-sm-5">
				<?php the_content(); ?>
        <p class='social-buttons'>
          <a href="https://www.facebook.com/BcnTrendMap" class='button-facebook-viola'></a>
          <a href="https://twitter.com/BcnTrendmap" class='button-twitter-viola'></a>
          <a href="https://www.instagram.com/bcntrendmap/" class='button-instagram-viola'></a>
        </p>
        <?php the_post_thumbnail('large'); ?>
        <p><?php _e('No te pierdas ni una novedad, inscribite a la Newsletter de Trend map!') ?></p>
        <a onclick="_report('Newsletter', 'inscripcion', 'boton de pag Contacto')" class='btn btn-default btn-lg' target='_blank' href="http://eepurl.com/bOzbpP">Newsletter</a>

			</div>
			<div class="col-sm-7">
				<div id="contact-form" class="clearfix">


            <?php if (intval($_POST['submitted'])===1) echo $response; ?>
				<form action="<?php the_permalink(); ?>" method="post">
               <div>
                  <label class="sr-only" for="nombre">Nombre </label><span class="required">*</span>
                  <input type="text" id="nombre" name="nombre" value="" placeholder="Nombre" required="required" autofocus="autofocus" />
               </div>
               <div>
                  <label class="sr-only" for="apellido">Apellidos </label><span class="required">*</span>
                  <input type="text" id="apellido" name="apellido" value="" placeholder="Apellidos" required="required" />
               </div>
               <div>
                  <label class="sr-only" for="telefono">Número de teléfono </label>
                  <input type="text" id="telefono" name="telefono" value="" placeholder="Número de teléfono"/>
               </div>
               <div>
                  <label class="sr-only" for="email">Correo electrónico </label><span class="required">*</span>
                  <input type="email" id="email" name="email" value="" placeholder="Correo electrónico" required="required" />
               </div>

               <div>
                  <label class="container"><?php echo $leyenda1; ?>
                     <input type="checkbox" name="baseslegales" id="baseslegales" required="required" data-toggle="modal" data-target="#myModal2">
                     <span class="checkmark"></span>
                  </label>
               </div>
               <div>
                  <label class="container"><?php echo $leyenda2; ?>
                     <input type="checkbox" name="opcion2" id="opcion2" required="required">
                     <span class="checkmark"></span>
                  </label>
               </div>
               <div>
                  <label class="container"><?php echo $leyenda3; ?>
                     <input type="checkbox" name="opcion3" id="opcion3" required="required">
                     <span class="checkmark"></span>
                  </label>
               </div>

			       <!--  <label for="enquiry">Tipo de consulta</label>
			        <select id="enquiry" name="enquiry">
			            <option value="general">General</option>
			            <option value="sales">Comercial</option>
			            <option value="support">Quisiera el numero del peluquero de Flavia..</option>
			        </select> -->

			      <input type="hidden" name="submitted" value="1">

			      <input type="submit" value="Enviar"></input>
			        <!-- <span id="loading"></span> -->
			        <!-- <input type="submit" value="Holla!" id="submit-button" /> -->
			      <p id="req-field-desc"><span class="required">*</span> <?php _e('Campos requeridos', 'trendmap_theme') ?></p>
				</form>
				</div>
			</div>
         <div id="myModal2" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Términos Y Condiciones</h4>
          </div>
          <div class="modal-body terminosC">
            <p><?php echo $bases; ?></p>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
          </div>
        </div>

      </div>
    </div>
		</div>

	<?php endwhile; // end of the loop. ?>
<?php get_sidebar('ajax'); ?>
<?php get_footer(); ?>
