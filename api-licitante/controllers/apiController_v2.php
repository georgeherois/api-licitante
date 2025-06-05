<?php
class apiController extends controller {

	public function index(){

		if((!isset ($_SESSION['tbLogin']) == true) and (!isset ($_SESSION['tb_id']) == true)){
			unset($_SESSION['tbLogin']);
			unset($_SESSION['tb_id']);
			session_destroy();
			header("location:".BASE_URL."home");

		}else{

			$dados = array();
			$dadosBanco = new Requestapi();
			$dados['info'] = $dadosBanco->getRelatorioPncp();
			$this->loadTemplate("home", $dados);

		}
		
	}

	public function insertDadosBanco(){

		// if((!isset ($_SESSION['tbLogin']) == true) and (!isset ($_SESSION['tb_id']) == true)){
		// 	unset($_SESSION['tbLogin']);
		// 	unset($_SESSION['tb_id']);
		// 	session_destroy();
		// 	header("location:".BASE_URL."home");

		// }else{

			$dataAtual = date('Y-m-d');
			$dados = array();
			$dadosBanco = new Requestapi();

			//$dadosBanco->zeraId();
			if($dadosBanco->insertDados()){
				//$dados = $dadosBanco->selectDadosBanco($dataAtual);
				//$dadosBanco->updateDados($dados);
				$this->loadTemplate("inicialTela");
				exit;
			}
		//}


	}


	public function selectDados(){


	
		if($_POST['fonte'] == 3){ 
			$tipo 		  = $_POST['tipo'];
			$dataInicial = date('Ymd');
			$dataFinal   = date('Ymd', strtotime($_POST['dataFinal']));
			$status 	  =$_POST['status'];
			$modalidade  = $_POST['modalidade'];


			$curl = curl_init();
			curl_setopt_array($curl, [
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'https://pncp.gov.br/api/consulta/v1/contratacoes/proposta?dataFinal='.$dataFinal.'&codigoModalidadeContratacao='.$modalidade.'&idUsuario=3&pagina=1'
			//CURLOPT_URL => 'https://pncp.gov.br/api/consulta/v1/contratacoes/publicacao?dataInicial='.$dataInicial.'&dataFinal='.$dataFinal.'&codigoModalidadeContratacao='.$modalidade.'&idUsuario=3&pagina=1'
			//CURLOPT_URL => 'https://pncp.gov.br/api/search/?tipos_documento=edital&ordenacao=-data&pagina=1&tam_pagina=1000&status=recebendo_proposta&modalidades='.$modalidade.'&tipo='.$tipo.'&idUsuario=3'
			//CURLOPT_URL => 'https://pncp.gov.br/api/search/?tipos_documento=edital&ordenacao=-data&pagina=1&tam_pagina=1000&status=recebendo_proposta&idUsuario=3&modalidades='.$modalidade.'&tipos=2'
			]);

			$response = curl_exec($curl);
			$dados['values'] = json_decode($response, false);
			//url_close($curl);

			if($dados) {
				$dados['dtFinal'] = date('d/m/Y', strtotime($dataFinal));
				$this->loadTemplate("telaPncp", $dados);
				
			} else {
				return false;
			}


		}
		if($_POST['fonte'] == 2){

			$dataInicial = date('Y-m-d');
			$dataInicialFormatada = date("Y-m-d", strtotime($_POST['dataFinal']));				
			$curl = curl_init();
			curl_setopt_array($curl, [
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'https://compras.api.portaldecompraspublicas.com.br/v2/licitacao/processos?codigoModalidade=3&codigoRealizacao=1&dataInicial='.$dataInicialFormatada.'T03:00:00.000Z&dataFinal='.$dataInicialFormatada.'T03:00:00.000Z&tipoData=1&codigoStatus=1'
			]);

			$response = curl_exec($curl);
		
			$dados['resp'] = json_decode($response, false);
			
	
			 if($dados) {
				$this->loadTemplate("telaComprasNet", $dados);
				 url_close($curl);
			 } else {
				 return false;
			 }
			




		}

		
		exit;	
	}

	public function selectDadosProximo($dtFinal, $numPagina){

		 //$dataInicial = date('Ymd');
		  $dtFinal;

		if($numPagina >= 2){
			$numPagina += 1;
		}else{
			$numPagina += 1;
		}
		$modalidade  =  8;

		$curl = curl_init();
		curl_setopt_array($curl, [
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => 'https://pncp.gov.br/api/consulta/v1/contratacoes/proposta?dataFinal='.$dtFinal.'&codigoModalidadeContratacao='.$modalidade.'&idUsuario=3&pagina='.$numPagina.''
		//CURLOPT_URL => 'https://pncp.gov.br/api/consulta/v1/contratacoes/publicacao?dataInicial=20250129&dataFinal=20250203&codigoModalidadeContratacao='.$modalidade.'&idUsuario=3&pagina='.$numPagina.''
		//CURLOPT_URL => 'https://pncp.gov.br/api/search/?tipos_documento=edital&ordenacao=-data&pagina=1&tam_pagina=1000&status=recebendo_proposta&modalidades='.$modalidade.'&tipo='.$tipo.'&idUsuario=3'
		//CURLOPT_URL => 'https://pncp.gov.br/api/search/?tipos_documento=edital&ordenacao=-data&pagina=1&tam_pagina=1000&status=recebendo_proposta&idUsuario=3&modalidades='.$modalidade.'&tipos=2'
		]);

		$response = curl_exec($curl);
		$dados['values'] = json_decode($response, false);
		//url_close($curl);
		//var_dump($dados);

		if($dados) {
			$dados['dtFinal'] = date('d/m/Y', strtotime($dtFinal));
			$this->loadTemplate("telaPncp", $dados);
			
		} else {
			return false;
		}

	}


	
}