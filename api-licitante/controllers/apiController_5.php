<?php
class apiController extends controller {

	public function index(){

		if((!isset ($_SESSION['tbLogin']) == true) and (!isset ($_SESSION['tb_id']) == true)){
			unset($_SESSION['tbLogin']);
			unset($_SESSION['tb_id']);
			session_destroy();
			header("location:".BASE_URL."home");

		}else{

			$results = [];
			$dadosBanco = new Requestapi();
	
			$results['info'] = $dadosBanco->getRelatorioPncp();
			
			

			$this->loadTemplate("home", $results);

		}
		
	}


    private function fetchDataFromApiPrimeiro($dataFinal, $modalidade, $pagina){

		$firstApiUrl = "https://pncp.gov.br/api/consulta/v1/contratacoes/proposta?dataFinal=$dataFinal&codigoModalidadeContratacao=$modalidade&idUsuario=3&pagina=$pagina&tamanhoPagina=30";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $firstApiUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$response = curl_exec($ch);
		curl_close($ch);
		
		return json_decode($response, true);
					

		
	}

	private function fetchDataFromApiSegundo($cnpj, $sequencialCompra){

		$secondApiUrl = "https://pncp.gov.br/api/pncp/v1/orgaos/$cnpj/compras/2025/$sequencialCompra/itens?pagina=1&tamanhoPagina=10";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $secondApiUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$response = curl_exec($ch);
		curl_close($ch);

		// $material = [];
		// foreach($response as $item){
		// 	if($item['status'] != 404){
		// 		$material[] = $item;
		// 	}
		// }
		
		echo "<pre>";
		print_r($response);
		//return json_decode($material, true);
		echo "</pre>";			

		
	}


	public function selectDados(){

		$fonte 		  = $_POST['fonte'];
		$tipo  		  = $_POST['tipo'];
		$dataIn       = !empty($_POST['dataInicial']) ? str_replace("/", "-", $_POST['dataInicial']) : date('Y-m-01');
		$dataInicial  = date('Ymd', strtotime($dataIn));
		$dataFin      = !empty($_POST['dataFinal']) ? str_replace("/", "-", $_POST['dataFinal']) : date('Y-m-t');
		$dataFinal 	  = date('Ymd', strtotime($dataFin));
		$modalidade   = $_POST['modalidade'];
		$horaAtual = date('H:i');
		//$totalPaginas = 17;

		if($fonte === "3"){
				$dados = array();
				// Monta a URL da primeira API
				//Buscar o tamanho da pagina para iniciar o loop
				$curl = curl_init();
				curl_setopt_array($curl, [
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => 'https://pncp.gov.br/api/consulta/v1/contratacoes/proposta?dataFinal='.$dataFinal.'&codigoModalidadeContratacao='.$modalidade.'&idUsuario=3&pagina=1&tamanhoPagina=10'
				]);
				$response = curl_exec($curl);		
				$dados = json_decode($response, false);
				curl_close($curl);

				$totalPaginas = $dados->totalPaginas; 
				$results = [];
				for ($pagina = 1; $pagina <= $totalPaginas; $pagina++) {

				// Chama a primeira API e armazena a resposta
				$firstApiResponse = $this->fetchDataFromApiPrimeiro($dataFinal, $modalidade, $pagina);

					if (!empty($firstApiResponse['data'])){
						foreach ($firstApiResponse['data'] as $contrato) {
							$cnpj = $contrato['orgaoEntidade']['cnpj'] ?? '';
							$sequencialCompra = $contrato['sequencialCompra'] ?? '';
							$dataEncerramentoProposta = $contrato['dataEncerramentoProposta'] ?? '';
							$dataEncPro = str_replace("-", "/", $dataEncerramentoProposta);
							$dataEncerramentoProposta  = date('Ymd', strtotime($dataEncPro));

								// Verifica se os valores necessários estão presentes
							if (!empty($cnpj) && !empty($sequencialCompra)){
								
								// Monta a URL da segunda API
								//$secondApiUrl = "https://pncp.gov.br/api/pncp/v1/orgaos/$cnpj/compras/2025/$sequencialCompra/itens?pagina=1&tamanhoPagina=5";

								// Chama a segunda API e armazena a resposta
								$secondApiResponse = $this->fetchDataFromApiSegundo($cnpj, $sequencialCompra);

												if($dataEncerramentoProposta === $dataFinal){
													// Adiciona os dados ao array de resultados
													$results[] = [
														'contrato' => $contrato,
														'itens' => $secondApiResponse
													];
													
													//$this->loadTemplate('telaPncp', ['data' => $results]);
					
												}


									
							//var_dump($results);
						//	$this->loadTemplate('telaPncp', ['data' => $results]);

							}

							

						}

						

					}
		 			//echo "<pre>";
		 			//var_dump($results);
					$this->loadTemplate('telaPncp', ['data' => $results]);
					//echo "</pre>";

				}
			
				
				//$this->loadTemplate('telaPncp', ['data' => $results]);
				//$this->loadTemplate('telaPncp', $results);
		}elseif($fonte === "2"){

			$dataInicial = date('Y-m-d');
			$dataInicialFormatada = date("Y-m-d", strtotime($_POST['dataFinal']));				
			$curl = curl_init();
			curl_setopt_array($curl, [
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'https://compras.api.portaldecompraspublicas.com.br/v2/licitacao/processos?codigoModalidade=3&codigoRealizacao=1&dataInicial='.$dataInicialFormatada.'T03:00:00.000Z&dataFinal='.$dataInicialFormatada.'T03:00:00.000Z&tipoData=1&codigoStatus=1'
			]);

			$response = curl_exec($curl);
		
			$dados['data'] = json_decode($response, false);
			
	
			 if($dados) {
				$this->loadTemplate("compras-publicas", $dados);
				 url_close($curl);
			 } else {
				$this->loadTemplate('telaPncpSemDados');
				exit;
			 }
			
		}else{
			$this->loadTemplate('telaPncpSemDados');
			exit;			

		}


	}


}