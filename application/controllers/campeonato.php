<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Campeonato extends CI_Controller {
	function __construct(){
		parent::__construct(); /*Ejecuta el constructor del padre*/
		//$this->load->helper('mihelper'); // Primero busca en helper de Application, sino va a System.
		$this->load->database();
		$this->load->library(array('ion_auth','grocery_crud'));
		$this->load->helper('url');
		$this->load->helper('form'); // Viene por defecto con CI. Crear formularios con ese helper.
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
		}
	}

	#or !$this->acl->tienePermisoAcceso('Aplicacion Web Natacion ')
	function index(){
	  	
		$crud = new grocery_CRUD();
		$crud->set_language('spanish');
		$crud->set_table('campeonato');

		//$crud->add_action('<+>', '+','pruebaCampeonato/index');
		$crud->add_action('Pruebas', base_url().'assets/imgs/pruebaIcon.png', 'pruebaCampeonato/index');

		$crud->set_subject('Campeonato');
		$crud->columns('nombre','ClubID','inicio','fin',  'TipoCampeonatoID');
		$crud->fields('ClubID','nombre','inicio','fin',  'TipoCampeonatoID', 'color');

		$crud->display_as('inicio','Fecha de Inicio');
		$crud->display_as('fin','Fecha de Fin');
		$crud->field_type('color','dropdown',
									array('blue' => 'azul', 'pink' => 'rosado','yellow' => 'amarillo' , 'black' => 'negro'));


		$crud->set_relation('TipoCampeonatoID','tipocampeonato','Tipo');
		$crud->set_relation('ClubID','club','Nombre');
		$crud->display_as('TipoCampeonatoID','Tipo');
		$crud->display_as('inicio','Fecha inicio');
		$crud->display_as('fin','Fecha fin');
		$crud->display_as('nombre','Título');
		$crud->display_as('ClubID','Club');
		$crud->unset_read();
		

	/* Generamos la tabla */
	$output = (array)$crud->render();
	//Se carga el titulo a la vista.
	$output['titulo']='Campeonatos';
	$this->load->view('headers');
	$this->load->view('gestion', $output);
		
	}

}