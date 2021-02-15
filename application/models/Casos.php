<?php

class Casos extends CI_Model
{

/*-----------------------------------------------------------------------------------------------
* Constructor
*/
public function __construct()
{
	parent::__construct();
}



/*-----------------------------------------------------------------------------------------------
* Index
*/
function index()
{
	$sql = "
	SELECT 	
	c.id,
	c.usuarios_id,
	c.fecha_inicio,
	c.fecha_cierre,
	c.asunto,
	c.hechos,
	c.num_folios,
	c.num_caja,
	c.estado,
	f.tipo
	FROM casos AS c 
	LEFT JOIN 
	(SELECT fa.tipo, fa.casos_id FROM fallos AS fa WHERE fa.tipo = 'PRIMERA INSTANCIA') AS f ON c.id = f.casos_id";
	$consulta = $this->db->query($sql);
	return $consulta->result();
}

/*-----------------------------------------------------------------------------------------------
* Involucrar
*/
function involucrar()
{
	$this->db->where('estado =', 'ACTIVO');
	$consulta = $this->db->get('casos');
	return $consulta->result();
}

/*-----------------------------------------------------------------------------------------------
* Detalles eventos
*/
function eventos()
{
	$this->db->where('estado !=', 'CERRADO');
	$consulta=$this->db->get('casos');
	return $consulta->result();
}

/*-----------------------------------------------------------------------------------------------
* Detalles
*/
function detalles($id)
{
	$this->db->where('id', $id);
	$consulta=$this->db->get('casos');
	return $consulta->row();
}

/*-----------------------------------------------------------------------------------------------
* Global
*/
function datos_globales($id)
{
	$sql = "SELECT 
	c.id AS id_casos, 
	c.fecha_inicio, 
	c.fecha_cierre, 
	c.asunto, 
	c.hechos, 
	c.num_folios, 
	c.num_caja, 
	c.estado, 
	CONCAT(u.primer_nombre,' ',u.segundo_nombre,' ',u.primer_apellido,' ',u.segundo_apellido) As nombre_usuario,
	i.id AS id_involucrados,
	i.tipo AS tipo_involucrados, 
	i.subtipo, 
	p.id AS id_personas, 
	p.cedula, 
	CONCAT(p.primer_nombre,' ',p.segundo_nombre,' ',p.primer_apellido,' ',p.segundo_apellido) As nombre_persona,
	p.direccion, 
	p.telefono,
	a.nombre_apoderados,
	a.id_apoderados
	FROM casos AS c
	LEFT JOIN usuarios AS u ON u.id = c.usuarios_id 
	LEFT JOIN involucrados AS i ON c.id = i.casos_id 
	LEFT JOIN personas AS p ON i.personas_id = p.id 
	LEFT JOIN
	(
	SELECT 
	r.casos_id AS casos_id,
	r.personas_id,
	CONCAT(ap.primer_nombre,' ',ap.segundo_nombre,' ',ap.primer_apellido,' ',ap.segundo_apellido) AS nombre_apoderados,
	ap.id AS id_apoderados
	FROM casos AS c  
	LEFT JOIN representaciones AS r ON c.id = r.casos_id 
	LEFT JOIN apoderados AS ap ON r.apoderados_id = ap.id
	)AS a ON a.casos_id = c.id AND a.personas_id = p.id
	WHERE c.id = '".$id."' ";

	$consulta = $this->db->query($sql);

	return $consulta->result();
}


/*-----------------------------------------------------------------------------------------------
* ver
*/
function ver($persona)
{
	$sql ="
	SELECT
	p.id,
	c.id AS id_casos,
	c.asunto, 
	c.estado,
	i.tipo, 
	i.subtipo,	
	a.apoderado,
	a.id_apoderado
	FROM personas AS p 
	LEFT JOIN involucrados AS i ON p.id = i.personas_id
	LEFT JOIN casos AS c ON c.id = i.casos_id
	LEFT JOIN (	SELECT 	
	CONCAT(ap.primer_nombre,' ',ap.segundo_nombre,' ',ap.primer_apellido,' ',ap.segundo_apellido) AS apoderado,
	ap.id AS id_apoderado,
	r.casos_id AS casos_r,
	pr.id AS per_id
	FROM personas AS pr
	LEFT JOIN representaciones AS r ON pr.id = r.personas_id
	LEFT JOIN apoderados AS ap ON ap.id = r.apoderados_id
	) AS a ON  c.id = a.casos_r AND a.per_id = p.id
	WHERE p.id ='".$persona."'";

	$consulta = $this->db->query($sql);
	return $consulta->result();
}


/*-----------------------------------------------------------------------------------------------
* apoderados
*/
function ver_apoderados($apoderado)
{
	$sql = "SELECT DISTINCT 
	c.id, 
	c.asunto, 
	c.estado
	FROM apoderados AS a 
	INNER JOIN representaciones AS r ON r.apoderados_id = a.id
	RIGHT JOIN casos AS c ON c.id = r.casos_id
	WHERE a.id ='".$apoderado."' ";

	$consulta = $this->db->query($sql);
	return $consulta->result();
}

/*-----------------------------------------------------------------------------------------------
* Guardar
*/
function guardar(
	$id,
	$usuarios_id,
	$fecha_inicio, 
	$asunto, 
	$hechos, 
	$num_folio,
	$num_caja)
{
	$this->db->where('id', $id);
	$existe_id = $this->db->get('casos');

	if($existe_id->num_rows() > 0)
	{
		$consulta = '2';
	}
	else
	{
		if (empty($num_folio)) 
		{
			$num_folio = NULL;
		}
		if (empty($num_caja)) 
		{
			$num_caja = NULL;
		}

		$data = array(
			'id'=>$id,
			'usuarios_id'=>$usuarios_id,
			'fecha_inicio'=> $fecha_inicio,
			'fecha_cierre'=> '',
			'asunto'=> $asunto,
			'hechos'=> $hechos,				
			'num_folios'=> $num_folio,
			'num_caja'=> $num_caja,
			'estado'=> 'ACTIVO'
		);
		$this->db->insert('casos', $data);
		$consulta = '1';
	}
	return $consulta;
}


/*-----------------------------------------------------------------------------------------------
* Actualizar
*/
function actualizar(
	$id,
	$new_id,
	$asunto, 
	$hechos, 
	$folio,
	$new_folio,
	$caja)
{

	if ($id !== $new_id) 
	{
		$this->db->where('id', $new_id);
		$existe_id = $this->db->get('casos');
		if($existe_id->num_rows() > 0 )
		{
			$consulta = '2';
			return $consulta;
		}
	}

	if ($folio !== $new_folio)
	{
		$this->db->where('num_folios', $new_folio);
		$existe_folio = $this->db->get('casos');
		if($existe_folio->num_rows() > 0 )
		{
			$consulta = '3';
			return $consulta;
		}
	}

	if (empty($new_folio)) 
	{
		$new_folio = NULL;
	}
	if (empty($caja)) 
	{
		$caja = NULL;
	}

	$data = array(
		'id'=>$new_id,
		'asunto'=> $asunto,
		'hechos'=> $hechos,
		'num_folios'=> $new_folio,
		'num_caja'=> $caja
	);
	$this->db->where('id', $id);
	$this->db->update('casos', $data);
	$consulta = '1';	
	return $consulta;
}

/*-----------------------------------------------------------------------------------------------
* Cerrar:
*/
function cerrar($id, $estado, $fecha)
{

	$this->db->where('id', $id);
	$existe_id = $this->db->get('casos');

	if($existe_id->num_rows() > 0 )
	{
		$data = array(
			'fecha_cierre'=>$fecha,
			'estado'=>$estado
		);
		$this->db->where('id', $id);
		$this->db->update('casos', $data);
		$consulta = '1';
	}
	else
	{
		$consulta = '2';
		return $consulta;
	}
	return $consulta;
}

/*-----------------------------------------------------------------------------------------------
* Abrir:
*/
function activar($id)
{

	$this->db->where('id', $id);
	$existe_id = $this->db->get('casos');

	if($existe_id->num_rows() > 0 )
	{
		$data = array(
			'fecha_cierre'=>'0000-00-00',
			'estado'=>'ACTIVO'
		);
		$this->db->where('id', $id);
		$this->db->update('casos', $data);
		$consulta = '1';
	}
	else
	{
		$consulta = '2';
		return $consulta;
	}
	return $consulta;
}

}