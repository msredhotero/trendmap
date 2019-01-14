<?php

/**
 * @Usuarios clase en donde se accede a la base de datos
 * @ABM consultas sobre las tablas de usuarios y usarios-clientes
 */

date_default_timezone_set('America/Buenos_Aires');

class ServiciosSeguridad {

	function GUID()
	{
		if (function_exists('com_create_guid') === true)
		{
			return trim(com_create_guid(), '{}');
		}

		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}


	function seguridadRuta($rol, $ruta) {
		$sql = "select idmenu,url,icono, nombre, permiso from predio_menu where permiso like '%".$rol."%' and url = '".$ruta."'";
		$res = $this->query($sql,0);

		if (mysqli_num_rows($res)>0) {
			return '';
		} else {
			header('Location: ../../error.php');
		}


	}

	function enviarEmail($destinatario,$asunto,$cuerpo) {


		# Defina el número de e-mails que desea enviar por periodo. Si es 0, el proceso por lotes
		# se deshabilita y los mensajes son enviados tan rápido como sea posible.
		define("MAILQUEUE_BATCH_SIZE",0);

		//para el envío en formato HTML
		//$headers = "MIME-Version: 1.0\r\n";

		// Cabecera que especifica que es un HMTL
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		//dirección del remitente
		$headers .= "From: Daniel Eduardo Duranti <info@carnesacasa.com.ar>\r\n";

		//ruta del mensaje desde origen a destino
		$headers .= "Return-path: ".$destinatario."\r\n";

		//direcciones que recibirán copia oculta
		$headers .= "Bcc: info@carnesacasa.com.ar,msredhotero@msn.com\r\n";

		mail($destinatario,$asunto,$cuerpo,$headers);
	}






	function query($sql,$accion) {



		require_once 'appconfig.php';

		$appconfig	= new appconfig();
		$datos		= $appconfig->conexion();
		$hostname	= $datos['hostname'];
		$database	= $datos['database'];
		$username	= $datos['username'];
		$password	= $datos['password'];

		//$conex = mysql_connect($hostname,$username,$password) or die ("no se puede conectar".mysql_error());
		$conex = mysqli_connect($hostname,$username,$password, $database);

		if (!$conex) {
		    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
		    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
		    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
		    exit;
		}
		//mysql_select_db($database);

		$error = 0;
		mysqli_query($conex,"BEGIN");
		$result=mysqli_query($conex,$sql);
		if ($accion && $result) {
			$result = mysqli_insert_id($conex);
		}
		if(!$result){
			$error=1;
		}
		if($error==1){
			mysqli_query($conex,"ROLLBACK");
			return false;
		}
		 else{
			mysqli_query($conex,"COMMIT");
			return $result;
		}

		mysqli_close($conex);

	}

}

?>
