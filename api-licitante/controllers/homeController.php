<?php
class homeController extends controller {

	public function index(){

		// $dados = array();
		// $curl = curl_init();
		// curl_setopt_array($curl, [
		// CURLOPT_RETURNTRANSFER => 1,
		// CURLOPT_URL => 'https://pncp.gov.br/api/search/?tipos_documento=edital&ordenacao=-data&pagina=1&tam_pagina=9000&status=recebendo_proposta&modalidades=8&tipo=2&idUsuario=3'
		// ]);

		// $response = curl_exec($curl);
		
		// $dados['info'] = json_decode($response, false);
	
			$this->loadTemplate("home");
			exit;

	}


	/*	public function listarContatos(){

		if((!isset ($_SESSION['cLogin']) == true) and (!isset ($_SESSION['cId']) == true)){
			unset($_SESSION['cLogin']);
	        unset($_SESSION['cId']);
	        session_destroy();
	        header("location:".BASE_URL."authentication");
		}else{

		c
		
		$listaContatos = new ListaDados();

		if($dados['info'] = $listaContatos->getContatos()){

			$this->loadTemplate("listaContatos", $dados);
			exit;

			}else{

			$this->loadTemplate("home");
			exit;				

			}	

		}


	}

		public function listarRegiao(){
			
		if((!isset ($_SESSION['cLogin']) == true) and (!isset ($_SESSION['cId']) == true)){
			unset($_SESSION['cLogin']);
	        unset($_SESSION['cId']);
	        session_destroy();
	        header("location:".BASE_URL."authentication");
		}else{

		$dados = array();
		
		$listaRegiao = new ListaDados();

		if($dados['info'] = $listaRegiao->getRegiao()){

			$this->loadTemplate("listaRegiao", $dados);
			exit;

			}else{

			$this->loadTemplate("home");
			exit;				

			}	

		}


	}


		public function listarRedeSocial(){
			
		if((!isset ($_SESSION['cLogin']) == true) and (!isset ($_SESSION['cId']) == true)){
			unset($_SESSION['cLogin']);
	        unset($_SESSION['cId']);
	        session_destroy();
	        header("location:".BASE_URL."authentication");
		}else{

		$dados = array();
		
		$listaRedeSocial = new ListaDados();

		if($dados['info'] = $listaRedeSocial->getRedeSocial()){

			$this->loadTemplate("listaRedeSociais", $dados);
			exit;

			}else{

			$this->loadTemplate("home");
			exit;				

			}	

		}


	}
	
		public function listaCidades(){
			
		if((!isset ($_SESSION['cLogin']) == true) and (!isset ($_SESSION['cId']) == true)){
			unset($_SESSION['cLogin']);
	        unset($_SESSION['cId']);
	        session_destroy();
	        header("location:".BASE_URL."authentication");
		}else{

		$dados = array();
		
		$listaCidade = new ListaDados();

		if($dados['info'] = $listaCidade->getCidade()){

			$this->loadTemplate("listaCidade", $dados);
			exit;

			}else{

			$this->loadTemplate("home");
			exit;				

			}	

		}


	}	*/		

}




