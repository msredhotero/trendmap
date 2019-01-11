<?php

include ('../includes/funcionesUsuarios.php');
include ('../includes/funciones.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');
include ('../includes/funcionesNotificaciones.php');
include ('../includes/validadores.php');


$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias		= new ServiciosReferencias();
$serviciosNotificaciones	= new ServiciosNotificaciones();
$serviciosValidador        = new serviciosValidador();


$accion = $_POST['accion'];

$resV['error'] = '';
$resV['mensaje'] = '';



switch ($accion) {
    case 'login':
        enviarMail($serviciosUsuarios);
        break;
	case 'entrar':
		entrar($serviciosUsuarios);
		break;
	case 'insertarUsuario':
        insertarUsuario($serviciosUsuarios);
        break;
	case 'modificarUsuario':
        modificarUsuario($serviciosUsuarios);
        break;
	case 'registrar':
		registrar($serviciosUsuarios);
		break;



   case 'frmAjaxModificar':
      frmAjaxModificar($serviciosFunciones, $serviciosReferencias);
   break;
   case 'frmAjaxNuevo':
      frmAjaxNuevo($serviciosFunciones, $serviciosReferencias);
   break;

   case 'insertarFormularios':
   insertarFormularios($serviciosReferencias, $serviciosValidador);
   break;
   case 'modificarFormularios':
   modificarFormularios($serviciosReferencias);
   break;
   case 'eliminarFormularios':
   eliminarFormularios($serviciosReferencias);
   break;
   case 'traerFormularios':
   traerFormularios($serviciosReferencias);
   break;
   case 'traerFormulariosPorId':
   traerFormulariosPorId($serviciosReferencias);
   break;

   case 'insertarLeyendas':
   insertarLeyendas($serviciosReferencias);
   break;
   case 'modificarLeyendas':
   modificarLeyendas($serviciosReferencias);
   break;
   case 'eliminarLeyendas':
   eliminarLeyendas($serviciosReferencias);
   break;
   case 'traerLeyendas':
   traerLeyendas($serviciosReferencias);
   break;
   case 'traerLeyendasPorId':
   traerLeyendasPorId($serviciosReferencias);
   break;


/* Fin */

}
/* Fin */


function frmAjaxModificar($serviciosFunciones, $serviciosReferencias) {
   $tabla = $_POST['tabla'];
   $id = $_POST['id'];

   switch ($tabla) {
      case 'tbleyendas':
         $modificar = "modificarLeyendas";
         $idTabla = "idleyenda";

         $lblCambio	 	= array("leyenda1","leyenda2","leyenda3","baseslegales");
         $lblreemplazo	= array("Leyenda 1","Leyenda 2","Leyenda 3",'Bases Legales');

         $cadRef 	= '';

         $refdescripcion = array();
         $refCampo 	=  array();
         break;
      case 'dbformularios':
         $modificar = "modificarFormularios";
         $idTabla = "idformulario";

         $resLeyendas = $serviciosReferencias->traerLeyendasUna();
         $resultado = $serviciosReferencias->traerFormulariosPorId($id);

         $leyenda1 = mysql_result($resLeyendas,0,'leyenda1');
         $leyenda2 = mysql_result($resLeyendas,0,'leyenda2');
         $leyenda3 = mysql_result($resLeyendas,0,'leyenda3');

         $lblCambio	 	= array("refrespuestas",'telefono','apellido','email','nombre','aceptacondiciones','opcion2','opcion3');
         $lblreemplazo	= array("¿Qué mar baña Barcelona? *",'Número de teléfono','Apellidos *','Correo Electrónico *','Nombre *',$leyenda1,$leyenda2,$leyenda3);
         $cadRef = '';

         switch (mysql_result($resultado,0,'refrespuestas')) {
            case 'Atlantico':
               $cadRef = '<option value="1" selected>Atlántico</option><option value="2">Cantábrico</option><option value="3">Mediterráneo</option>';
               break;
            case 'Cantabrico':
               $cadRef = '<option value="1">Atlántico</option><option value="2" selected>Cantábrico</option><option value="3">Mediterráneo</option>';
               break;
            case 'Mediterraneo':
               $cadRef = '<option value="1">Atlántico</option><option value="2">Cantábrico</option><option value="3" selected>Mediterráneo</option>';
               break;
            default:
               // code...
               break;
         }


         $refdescripcion = array(0=>$cadRef);
         $refCampo 	=  array('refrespuestas');
         break;


      default:
         // code...
         break;
   }

   $formulario = $serviciosFunciones->camposTablaModificar($id, $idTabla,$modificar,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

   echo utf8_encode($formulario);
}


function frmAjaxNuevo($serviciosFunciones, $serviciosReferencias) {
   $tabla = $_POST['tabla'];
   $id = $_POST['id'];

   switch ($tabla) {
      case 'dbplantas':

         $insertar = "insertarPlantas";
         $idTabla = "idplanta";

         $lblCambio	 	= array("reflientes");
         $lblreemplazo	= array("Cliente");

         $resVar1 = $serviciosReferencias->traerClientesPorId($id);
         $cadRef1 	= $serviciosFunciones->devolverSelectBoxActivo($resVar1,array(1),'', $id);

         $refdescripcion = array(0=>$cadRef1);
         $refCampo 	=  array('refclientes');
         break;
      case 'dbsectores':
         $insertar = "insertarSectores";
         $idTabla = "idsector";

         $lblCambio	 	= array("refplantas");
         $lblreemplazo	= array("Planta");

         $resVar1 = $serviciosReferencias->traerPlantasPorCliente($id);
         $cadRef1 	= $serviciosFunciones->devolverSelectBox($resVar1,array(2),'');

         $refdescripcion = array(0=>$cadRef1);
         $refCampo 	=  array('refplantas');
         break;
      case 'dbcontactos':
         $insertar = "insertarContactos";
         $idTabla = "idcontacto";

         $lblCambio	 	= array("refsectores");
         $lblreemplazo	= array("Sector");

         $resVar1 = $serviciosReferencias->traerSectoresPorCliente($id);
         $cadRef1 	= $serviciosFunciones->devolverSelectBox($resVar1,array(3,2),' - ');

         $refdescripcion = array(0=>$cadRef1);
         $refCampo 	=  array('refsectores');
         break;


      default:
         // code...
         break;
   }

   $formulario = $serviciosFunciones->camposTablaViejo($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

   echo $formulario;
}




function insertarFormularios($serviciosReferencias, $serviciosValidador) {
   $error = '';

   $refrespuestas = $_POST['refrespuestas'];

   if ($_POST['nombre'] == '') {
      $error .= 'Es obligatorio el campo Nombre.
      ';
   } else {
      $nombre = $_POST['nombre'];
   }

   if ($_POST['apellido'] == '') {
      $error .= 'Es obligatorio el campo Apellidos.
      ';
   } else {
      $apellido = $_POST['apellido'];
   }

   if ($_POST['email'] == '') {
      $error .= 'Es obligatorio el campo Email.
      ';
   } else {
      $email = ($serviciosValidador->validaEmail( trim($_POST['email']) ) == true ? trim($_POST['email']) : $error .= 'Email invalido.
      ');
   }

   $telefono = $_POST['telefono'];

   if (isset($_POST['aceptacondiciones'])) {
      $aceptacondiciones	= 1;
   } else {
      $aceptacondiciones = 0;
   }

   if (isset($_POST['opcion2'])) {
      $opcion2	= 1;
   } else {
      $opcion2 = 0;
   }

   if (isset($_POST['opcion3'])) {
      $opcion3	= 1;
   } else {
      $opcion3 = 0;
   }

   $leyenda1 = $_POST['leyenda1'];
   $leyenda2 = $_POST['leyenda2'];
   $leyenda3 = $_POST['leyenda3'];

   if ($error == '') {
      $res = $serviciosReferencias->insertarFormularios($refrespuestas,$nombre,$apellido,$telefono,$email,$aceptacondiciones,$opcion2,$opcion3,$leyenda1,$leyenda2,$leyenda3);

      if ((integer)$res > 0) {
         echo '';
      } else {
         echo 'Huvo un error al insertar datos';
      }
   } else {
      echo $error;
   }

}


function modificarFormularios($serviciosReferencias) {
$id = $_POST['id'];
$refrespuestas = $_POST['refrespuestas'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
if (isset($_POST['aceptacondiciones'])) {
$aceptacondiciones	= 1;
} else {
$aceptacondiciones = 0;
}
if (isset($_POST['opcion2'])) {
$opcion2	= 1;
} else {
$opcion2 = 0;
}
if (isset($_POST['opcion3'])) {
$opcion3	= 1;
} else {
$opcion3 = 0;
}
$leyenda1 = $_POST['leyenda1'];
$leyenda2 = $_POST['leyenda2'];
$leyenda3 = $_POST['leyenda3'];
$res = $serviciosReferencias->modificarFormularios($id,$refrespuestas,$nombre,$apellido,$telefono,$email,$aceptacondiciones,$opcion2,$opcion3,$leyenda1,$leyenda2,$leyenda3);
if ($res == true) {
echo '';
} else {
echo 'Huvo un error al modificar datos';
}
}

function eliminarFormularios($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->eliminarFormularios($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Huvo un error al modificar datos';
   }
}


function traerFormularios($serviciosReferencias) {
$res = $serviciosReferencias->traerFormularios();
$ar = array();
while ($row = mysql_fetch_array($res)) {
array_push($ar, $row);
}
$resV['datos'] = $ar;
header('Content-type: application/json');
echo json_encode($resV);
}

function insertarLeyendas($serviciosReferencias) {
$leyenda1 = $_POST['leyenda1'];
$leyenda2 = $_POST['leyenda2'];
$leyenda3 = $_POST['leyenda3'];
$baseslegales = $_POST['baseslegales'];
$res = $serviciosReferencias->insertarLeyendas($leyenda1,$leyenda2,$leyenda3,$baseslegales);
if ((integer)$res > 0) {
echo '';
} else {
echo 'Huvo un error al insertar datos';
}
}
function modificarLeyendas($serviciosReferencias) {
$id = $_POST['id'];
$leyenda1 = $_POST['leyenda1'];
$leyenda2 = $_POST['leyenda2'];
$leyenda3 = $_POST['leyenda3'];
$baseslegales = $_POST['baseslegales'];
$res = $serviciosReferencias->modificarLeyendas($id,$leyenda1,$leyenda2,$leyenda3,$baseslegales);
if ($res == true) {
echo '';
} else {
echo 'Huvo un error al modificar datos';
}
}

function eliminarLeyendas($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->eliminarLeyendas($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Huvo un error al modificar datos';
   }
}


function traerLeyendas($serviciosReferencias) {
$res = $serviciosReferencias->traerLeyendas();
$ar = array();
while ($row = mysql_fetch_array($res)) {
array_push($ar, $row);
}
$resV['datos'] = $ar;
header('Content-type: application/json');
echo json_encode($resV);
}

////////////////////////// FIN DE TRAER DATOS ////////////////////////////////////////////////////////////

//////////////////////////  BASICO  /////////////////////////////////////////////////////////////////////////

function toArray($query)
{
    $res = array();
    while ($row = @mysql_fetch_array($query)) {
        $res[] = $row;
    }
    return $res;
}


function entrar($serviciosUsuarios) {
	$email		=	$_POST['email'];
	$pass		=	$_POST['pass'];
	echo $serviciosUsuarios->loginUsuario($email,$pass);
}


function registrar($serviciosUsuarios) {
	$usuario			=	$_POST['usuario'];
	$password			=	$_POST['password'];
	$refroll			=	$_POST['refroll'];
	$email				=	$_POST['email'];
	$nombre				=	$_POST['nombrecompleto'];

	$res = $serviciosUsuarios->insertarUsuario($usuario,$password,$refroll,$email,$nombre);
	if ((integer)$res > 0) {
		echo '';
	} else {
		echo $res;
	}
}


function insertarUsuario($serviciosUsuarios) {
	$usuario			=	$_POST['usuario'];
	$password			=	$_POST['password'];
	$refroll			=	$_POST['refroles'];
	$email				=	$_POST['email'];
	$nombre				=	$_POST['nombrecompleto'];

	$res = $serviciosUsuarios->insertarUsuario($usuario,$password,$refroll,$email,$nombre);
	if ((integer)$res > 0) {
		echo '';
	} else {
		echo $res;
	}
}


function modificarUsuario($serviciosUsuarios) {
	$id					=	$_POST['id'];
	$usuario			=	$_POST['usuario'];
	$password			=	$_POST['password'];
	$refroll			=	$_POST['refroles'];
	$email				=	$_POST['email'];
	$nombre				=	$_POST['nombrecompleto'];

	echo $serviciosUsuarios->modificarUsuario($id,$usuario,$password,$refroll,$email,$nombre);
}


function enviarMail($serviciosUsuarios) {
	$email		=	$_POST['email'];
	$pass		=	$_POST['pass'];
	//$idempresa  =	$_POST['idempresa'];

	echo $serviciosUsuarios->login($email,$pass);
}


function devolverImagen($nroInput) {

	if( $_FILES['archivo'.$nroInput]['name'] != null && $_FILES['archivo'.$nroInput]['size'] > 0 ){
	// Nivel de errores
	  error_reporting(E_ALL);
	  $altura = 100;
	  // Constantes
	  # Altura de el thumbnail en píxeles
	  //define("ALTURA", 100);
	  # Nombre del archivo temporal del thumbnail
	  //define("NAMETHUMB", "/tmp/thumbtemp"); //Esto en servidores Linux, en Windows podría ser:
	  //define("NAMETHUMB", "c:/windows/temp/thumbtemp"); //y te olvidas de los problemas de permisos
	  $NAMETHUMB = "c:/windows/temp/thumbtemp";
	  # Servidor de base de datos
	  //define("DBHOST", "localhost");
	  # nombre de la base de datos
	  //define("DBNAME", "portalinmobiliario");
	  # Usuario de base de datos
	  //define("DBUSER", "root");
	  # Password de base de datos
	  //define("DBPASSWORD", "");
	  // Mime types permitidos
	  $mimetypes = array("image/jpeg", "image/pjpeg", "image/gif", "image/png");
	  // Variables de la foto
	  $name = $_FILES["archivo".$nroInput]["name"];
	  $type = $_FILES["archivo".$nroInput]["type"];
	  $tmp_name = $_FILES["archivo".$nroInput]["tmp_name"];
	  $size = $_FILES["archivo".$nroInput]["size"];
	  // Verificamos si el archivo es una imagen válida
	  if(!in_array($type, $mimetypes))
		die("El archivo que subiste no es una imagen válida");
	  // Creando el thumbnail
	  switch($type) {
		case $mimetypes[0]:
		case $mimetypes[1]:
		  $img = imagecreatefromjpeg($tmp_name);
		  break;
		case $mimetypes[2]:
		  $img = imagecreatefromgif($tmp_name);
		  break;
		case $mimetypes[3]:
		  $img = imagecreatefrompng($tmp_name);
		  break;
	  }

	  $datos = getimagesize($tmp_name);

	  $ratio = ($datos[1]/$altura);
	  $ancho = round($datos[0]/$ratio);
	  $thumb = imagecreatetruecolor($ancho, $altura);
	  imagecopyresized($thumb, $img, 0, 0, 0, 0, $ancho, $altura, $datos[0], $datos[1]);
	  switch($type) {
		case $mimetypes[0]:
		case $mimetypes[1]:
		  imagejpeg($thumb, $NAMETHUMB);
			  break;
		case $mimetypes[2]:
		  imagegif($thumb, $NAMETHUMB);
		  break;
		case $mimetypes[3]:
		  imagepng($thumb, $NAMETHUMB);
		  break;
	  }
	  // Extrae los contenidos de las fotos
	  # contenido de la foto original
	  $fp = fopen($tmp_name, "rb");
	  $tfoto = fread($fp, filesize($tmp_name));
	  $tfoto = addslashes($tfoto);
	  fclose($fp);
	  # contenido del thumbnail
	  $fp = fopen($NAMETHUMB, "rb");
	  $tthumb = fread($fp, filesize($NAMETHUMB));
	  $tthumb = addslashes($tthumb);
	  fclose($fp);
	  // Borra archivos temporales si es que existen
	  //@unlink($tmp_name);
	  //@unlink(NAMETHUMB);
	} else {
		$tfoto = '';
		$type = '';
	}
	$tfoto = utf8_decode($tfoto);
	return array('tfoto' => $tfoto, 'type' => $type);
}


?>
