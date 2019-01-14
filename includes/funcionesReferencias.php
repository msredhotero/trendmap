<?php

/**
 * @Usuarios clase en donde se accede a la base de datos
 * @ABM consultas sobre las tablas de usuarios y usarios-clientes
 */

date_default_timezone_set('America/Buenos_Aires');

class ServiciosReferencias {




	function GUID()
	{
		if (function_exists('com_create_guid') === true)
		{
			return trim(com_create_guid(), '{}');
		}

		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}

	function sanear_string($string)
	{

		$string = trim($string);

		$string = str_replace(
			array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
			array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
			$string
		);

		$string = str_replace(
			array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
			array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
			$string
		);

		$string = str_replace(
			array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
			array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
			$string
		);

		$string = str_replace(
			array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
			array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
			$string
		);

		$string = str_replace(
			array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
			array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
			$string
		);

		$string = str_replace(
			array('ñ', 'Ñ', 'ç', 'Ç'),
			array('n', 'N', 'c', 'C',),
			$string
		);



		return $string;
	}

	function borrarDirecctorio($dir) {
        array_map('unlink', glob($dir."/*.*"));

    }

	function borrarArchivos($directorio) {

        $res =  $this->borrarDirecctorio("./".$directorio);

        rmdir("./".$directorio);

        return '';
	}

	function existe($sql) {

	    $res = $this->query($sql,0);

	    if (mysqli_num_rows($res)>0) {
	        return 1;
	    }
	    return 0;
	}

	function existeDevuelveId($sql) {

	    $res = $this->query($sql,0);

	    if (mysqli_num_rows($res)>0) {
	        return $this->mysqli_result($res,0,0);
	    }
	    return 0;
	}



	function insertarConfiguracion($razonsocial,$empresa,$sistema,$direccion,$telefono,$email) {
	$sql = "insert into tbconfiguracion(idconfiguracion,razonsocial,empresa,sistema,direccion,telefono,email)
	values ('','".($razonsocial)."','".($empresa)."','".($sistema)."','".($direccion)."','".($telefono)."','".($email)."')";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarConfiguracion($id,$razonsocial,$empresa,$sistema,$direccion,$telefono,$email) {
	$sql = "update tbconfiguracion
	set
	razonsocial = '".($razonsocial)."',empresa = '".($empresa)."',sistema = '".($sistema)."',direccion = '".($direccion)."',telefono = '".($telefono)."',email = '".($email)."'
	where idconfiguracion =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarConfiguracion($id) {
	$sql = "delete from tbconfiguracion where idconfiguracion =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerConfiguracion() {
	$sql = "select
	c.idconfiguracion,
	c.razonsocial,
	c.empresa,
	c.sistema,
	c.direccion,
	c.telefono,
	c.email
	from tbconfiguracion c
	order by 1";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerConfiguracionPorId($id) {
	$sql = "select idconfiguracion,razonsocial,empresa,sistema,direccion,telefono,email from tbconfiguracion where idconfiguracion =".$id;
	$res = $this->query($sql,0);
	return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: tbconfiguracion*/





	/* PARA Formularios */

	function insertarFormularios($nombre,$apellido,$telefono,$email,$aceptacondiciones,$opcion2,$opcion3,$leyenda1,$leyenda2,$leyenda3) {
	$sql = "insert into dbformularios(idformulario,nombre,apellido,telefono,email,aceptacondiciones,opcion2,opcion3,leyenda1,leyenda2,leyenda3)
	values ('','".($nombre)."','".($apellido)."','".($telefono)."','".($email)."',".$aceptacondiciones.",".$opcion2.",".$opcion3.",'".($leyenda1)."','".($leyenda2)."','".($leyenda3)."')";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarFormularios($id,$nombre,$apellido,$telefono,$email,$aceptacondiciones,$opcion2,$opcion3,$leyenda1,$leyenda2,$leyenda3) {
	$sql = "update dbformularios
	set
	nombre = '".($nombre)."',apellido = '".($apellido)."',telefono = '".($telefono)."',email = '".($email)."',aceptacondiciones = ".$aceptacondiciones.",opcion2 = ".$opcion2.",opcion3 = ".$opcion3.",leyenda1 = '".($leyenda1)."',leyenda2 = '".($leyenda2)."',leyenda3 = '".($leyenda3)."'
	where idformulario =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarFormularios($id) {
	$sql = "delete from dbformularios where idformulario =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerFormulariosajax($length, $start, $busqueda) {

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = "where f.nombre like '%".$busqueda."%' or f.apellido like '%".$busqueda."%' or f.telefono like '%".$busqueda."%' or f.email like '%".$busqueda."%'";
		}

		$sql = "select
		f.idformulario,
		f.nombre,
		f.apellido,
		f.telefono,
		f.email,
		f.aceptacondiciones,
		f.opcion2,
		f.opcion3,
		f.leyenda1,
		f.leyenda2,
		f.leyenda3
		from dbformularios f
		".$where."
		limit ".$start.",".$length;

		$res = $this->query($sql,0);
		return $res;
	}


	function traerFormularios() {
	$sql = "select
	f.idformulario,
	f.nombre,
	f.apellido,
	f.telefono,
	f.email,
	f.aceptacondiciones,
	f.opcion2,
	f.opcion3,
	f.leyenda1,
	f.leyenda2,
	f.leyenda3
	from dbformularios f
	order by f.apellido, f.nombre";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerFormulariosPorId($id) {
	$sql = "select idformulario,nombre,apellido,telefono,email,aceptacondiciones,opcion2,opcion3,leyenda1,leyenda2,leyenda3 from dbformularios where idformulario =".$id;
	$res = $this->query($sql,0);
	return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: dbformularios*/


	/* PARA Leyendas */

function insertarLeyendas($leyenda1,$leyenda2,$leyenda3,$baseslegales) {
$sql = "insert into tbleyendas(idleyenda,leyenda1,leyenda2,leyenda3,baseslegales)
values ('','".($leyenda1)."','".($leyenda2)."','".($leyenda3)."','".($baseslegales)."')";
$res = $this->query($sql,1);
return $res;
}


function modificarLeyendas($id,$leyenda1,$leyenda2,$leyenda3,$baseslegales) {
$sql = "update tbleyendas
set
leyenda1 = '".($leyenda1)."',leyenda2 = '".($leyenda2)."',leyenda3 = '".($leyenda3)."',baseslegales = '".($baseslegales)."'
where idleyenda =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarLeyendas($id) {
$sql = "delete from tbleyendas where idleyenda =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerLeyendasajax($length, $start, $busqueda) {

	$where = '';

	$busqueda = str_replace("'","",$busqueda);
	if ($busqueda != '') {
		$where = "where l.leyenda1 like '%".$busqueda."%' or l.leyenda2 like '%".$busqueda."%' or l.leyenda3 like '%".$busqueda."%'";
	}

	$sql = "select
	l.idleyenda,
	l.leyenda1,
	l.leyenda2,
	l.leyenda3,
	l.baseslegales
	from tbleyendas l
	".$where."
	limit ".$start.",".$length;

	$res = $this->query($sql,0);
	return $res;
}

function traerLeyendas() {
$sql = "select
l.idleyenda,
l.leyenda1,
l.leyenda2,
l.leyenda3,
l.baseslegales
from tbleyendas l
order by 1";
$res = $this->query($sql,0);
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
$res = $this->query($sql,0);
return $res;
}


function traerLeyendasPorId($id) {
$sql = "select idleyenda,leyenda1,leyenda2,leyenda3,baseslegales from tbleyendas where idleyenda =".$id;
$res = $this->query($sql,0);
return $res;
}

/* Fin */
/* /* Fin de la Tabla: tbleyendas*/

	function mysqli_result($res,$row=0,$col=0){
	    $numrows = mysqli_num_rows($res);
	    if ($numrows && $row <= ($numrows-1) && $row >=0){
	        mysqli_data_seek($res,$row);
	        $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
	        if (isset($resrow[$col])){
	            return $resrow[$col];
	        }
	    }
	    return false;
	}


	function query($sql,$accion) {



		require_once 'appconfig.php';

		$appconfig	= new appconfig();
		$datos		= $appconfig->conexion();
		$hostname	= $datos['hostname'];
		$database	= $datos['database'];
		$username	= $datos['username'];
		$password	= $datos['password'];

		//$conex = mysql_connect($hostname,$username,$password) or die ("no se puede conectar".mysqli_error());
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
			$result = mysql_insert_id();
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
