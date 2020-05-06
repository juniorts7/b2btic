<?php
defined('BASEPATH') OR exit('No direct script access allowed');
		
class Buscar_archivo extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_buscar_archivo');
	}
	
	// ejecuta el modelo ingresar_info
	public function ingresar_info()
	{ 
		$this->model_buscar_archivo->ingresar_info();
		return true;
	}
	
	// ejecuta el modelo listar_archivos
	public function listar_archivos()
	{
		$this->model_buscar_archivo->listar_archivos();
		return true;
	}
	
	// ejecuta modelo cantidad de archivos
	public function cantidad_archivos()
	{
		$this->model_buscar_archivo->cantidad_archivos();
		return true;
	}
}
