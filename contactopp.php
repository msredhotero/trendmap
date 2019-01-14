<?php
/**
 * Template Name: Contacto Page
 * @package trendmap_theme
 */

  //response generation function
  $response = "";

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
  $message_sent    = __("Gracias, recibimos tu mensaje. Nos pondremos en contacto..",'trendmap_theme');

  //user posted variables
  $name = $_POST['nombre'];
  $email = $_POST['email'];
  $message = $_POST['message'];
  $human = $_POST['message_human'];

  //php mailer variables
  //$to = get_option('admin_email');
  $to = 'hola@trendmap.es';
  $subject = "Mensaje desde el formulario de contacto de: ".get_bloginfo('name');
  $headers = 'From: '. $email . "\r\n" .
    'Reply-To: ' . $email . "\r\n";

if(isset($_POST['g-recaptcha-response'])){
    $captcha=$_POST['g-recaptcha-response'];
  }
  $secretKey = "6LeZPiQTAAAAAO6c58NHKQphUZks2ZHuQUTxybxL";
  $ip = $_SERVER['REMOTE_ADDR'];
  $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
  $responseKeys = json_decode($response,true);

  if (intval($_POST['submitted'])===1){
    if(intval($responseKeys["success"]) !== 1) {
      my_contact_form_generate_response("error", $not_human); //not human!
    } else {
        // validate email
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
          my_contact_form_generate_response("error", $email_invalid);
        //validate presence of name and message
        if(empty($name) || empty($message)){
           my_contact_form_generate_response("error", $missing_content);
        }
        else //ready to go!
        {
         //send email
        $sent = wp_mail($to, $subject, strip_tags($message), $headers);
        if($sent) my_contact_form_generate_response("success", $message_sent); //message sent!
        else my_contact_form_generate_response("error", $message_unsent); //message wasn't sent
    }
    }
  }
get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<h1 class="page-title"><?php the_title(); ?></h1>

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
            <p><?php _e('Hola, dejanos tu mensaje y nos pondremos en contacto..', 'trendmap_theme') ?></p>
				    <form action="<?php the_permalink(); ?>" method="post">
              <div>
				        <label class="sr-only" for="nombre"><?php _e('Nombre','trendmap_theme') ?> </label><span class="required">*</span>
				        <input type="text" id="nombre" name="nombre" value="" placeholder="<?php _e('Nombre', 'trendmap_theme') ?>" required="required" autofocus="autofocus" />
				      </div>
              <div>
				        <label class="sr-only" for="email"><?php _e('E-mail', 'trendmap_theme') ?> </label><span class="required">*</span>
				        <input type="email" id="email" name="email" value="" placeholder="<?php _e('e-mail', 'trendmap_theme') ?>" required="required" />
				      </div>
              <div>
				        <label class="sr-only" for="telephone"><?php _e('Telefono', 'trendmap_theme') ?></label>
				        <input type="tel" id="telephone" name="telephone" value="" placeholder="<?php _e('Telefono', 'trendmap_theme') ?>"/>
              </div>
				       <!--  <label for="enquiry">Tipo de consulta</label>
				        <select id="enquiry" name="enquiry">
				            <option value="general">General</option>
				            <option value="sales">Comercial</option>
				            <option value="support">Quisiera el numero del peluquero de Flavia..</option>
				        </select> -->
				      <div>
				        <label class="sr-only" for="message"><?php _e('Mensaje', 'trendmap_theme') ?> </label><span class="required">*</span>
				        <textarea id="message" name="message" placeholder="<?php _e('Hola trendmap..', 'trendmap_theme') ?>" required="required" data-minlength="20"></textarea>
				      </div>
				        <input type="hidden" name="submitted" value="1">
                <div class="g-recaptcha" data-sitekey="6LeZPiQTAAAAAKPezpIIe6XFCs5g8JEa7C_lD4Dd"></div>
				        <input type="submit" value= "<?php _e('Enviar', 'trendmap_theme') ?>"></input>
				        <!-- <span id="loading"></span> -->
				        <!-- <input type="submit" value="Holla!" id="submit-button" /> -->
				        <p id="req-field-desc"><span class="required">*</span> <?php _e('Campos requeridos', 'trendmap_theme') ?></p>
				    </form>
				</div>
			</div>
		</div>

	<?php endwhile; // end of the loop. ?>
<?php get_sidebar('ajax'); ?>
<?php get_footer(); ?>
