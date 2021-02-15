<?php

class Impresiones extends CI_Model
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
	$this->db->where('id',1);
	$consulta = $this->db->get('impresiones');
	return $consulta->row();
}

/*-----------------------------------------------------------------------------------------------
* Actualizar
*/
function actualizar(
	$secretaria, 
	$titulo, 
	$juramento, 
	$nombre, 
	$lema, 
	$direccion, 
	$telefono, 
	$fax, 
	$email, 
	$web)
{
	$data = array(
		'secretaria'=> $secretaria,
		'titulo'=> $titulo,
		'juramento'=> $juramento, 
		'nombre'=> $nombre,
		'lema'=> $lema, 
		'direccion'=>$direccion, 
		'telefono'=>$telefono, 
		'fax'=>$fax, 
		'email'=>$email, 
		'web'=>$web
	);
	$this->db->where('id', 1);
	$this->db->update('impresiones', $data);
	$consulta = '1';	
	return $consulta;
}
}