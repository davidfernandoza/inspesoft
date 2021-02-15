<?php

class Personas extends CI_Model
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
	$consulta = $this->db->get('personas');
	return $consulta->result();
}



/*-----------------------------------------------------------------------------------------------
* Detalles
*/
function detalles($id)
{
	$this->db->where('id', $id);
	$consulta=$this->db->get('personas');
	return $consulta->row();
}

/*-----------------------------------------------------------------------------------------------
* apoderados
*/
function ver_apoderados($apoderado)
{
	$sql = "SELECT 	DISTINCT
	p.id, 
	p.cedula,
	CONCAT(p.primer_nombre,' ',p.segundo_nombre,' ',p.primer_apellido,' ',p.segundo_apellido) As nombre_persona
	FROM apoderados AS a 
    INNER JOIN representaciones AS r ON r.apoderados_id = a.id
    RIGHT JOIN personas AS p ON p.id = r.personas_id
    WHERE a.id ='".$apoderado."' ";

	$consulta = $this->db->query($sql);
	return $consulta->result();
}


/*-----------------------------------------------------------------------------------------------
* Guardar
*/
function guardar(
	$id,
	$cedula,
	$primer_nombre, 
	$segundo_nombre, 
	$primer_apellido, 
	$segundo_apellido, 
	$direccion, 
	$telefono)
{
	$this->db->where('id',$id);
	$existe_id = $this->db->get('personas');


	$this->db->where('cedula',$cedula);
	$existe_cedula = $this->db->get('personas');


	if($existe_id->num_rows() > 0 )
	{
		$consulta = '2';
	}
	else if($existe_cedula->num_rows() > 0 && $cedula != NULL)
	{
		$consulta = '2';
	}
	else
	{
		if (empty($cedula)) 
		{
			$cedula = NULL;
		}
		if (empty($telefono)) 
		{
			$telefono = NULL;
		}
		$data = array(
			'id'=>$id,
			'cedula'=>$cedula,
			'primer_nombre'=>$primer_nombre, 
			'segundo_nombre'=>$segundo_nombre, 
			'primer_apellido'=>$primer_apellido,
			'segundo_apellido'=>$segundo_apellido,
			'direccion'=>$direccion,
			'telefono'=>$telefono,
			'estado'=>'ACTIVO'
		); 
		$this->db->insert('personas', $data);
		$consulta = '1';
	}
	return $consulta;
}



/*-----------------------------------------------------------------------------------------------
* Actualizar
*/
function actualizar(
	$id,
	$cedula,
	$new_cedula,
	$primer_nombre, 
	$segundo_nombre, 
	$primer_apellido,
	$segundo_apellido,
	$direccion,
	$telefono)
{

	if ($cedula !== $new_cedula) 
	{
		$this->db->where('cedula', $new_cedula);
		$existe_id = $this->db->get('personas');
		if($existe_id->num_rows() > 0 )
		{
			$consulta = '2';
			return $consulta;
		}
	}
	

if (empty($cedula)) 
{
	$cedula = NULL;
}
if (empty($telefono)) 
{
	$telefono = NULL;
}

$data = array(
	'cedula'=>$new_cedula,
	'primer_nombre'=>$primer_nombre, 
	'segundo_nombre'=>$segundo_nombre, 
	'primer_apellido'=>$primer_apellido,
	'segundo_apellido'=>$segundo_apellido,
	'direccion'=>$direccion,
	'telefono' =>$telefono
);
$this->db->where('id', $id);
$this->db->update('personas', $data);
$consulta = '1';

return $consulta;
}
}