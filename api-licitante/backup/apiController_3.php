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
		
		return json_decode($response, true);
					

		
	}


	public function selectDados(){

		$fonte 		  = $_POST['fonte'];
		$tipo  		  = $_POST['tipo'];
		$dataIn  	  = str_replace("/", "-", $_POST["dataInicial"]);
		$dataInicial  = date('Ymd', strtotime($dataIn));
		$dataFin  	  = str_replace("/", "-", $_POST["dataFinal"]);
		$dataFinal 	  = date('Ymd', strtotime($dataFin));
		$modalidade   = $_POST['modalidade'];
		$horaAtual = date('H:i');
		//$totalPaginas = 17;


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

		for ($pagina = 1; $pagina <= $totalPaginas; $pagina++) {

		// Chama a primeira API e armazena a resposta
		$firstApiResponse = $this->fetchDataFromApiPrimeiro($dataFinal, $modalidade, $pagina);

		

			$results = [];

			if (!empty($firstApiResponse['data'])){
				foreach ($firstApiResponse['data'] as $contrato) {
					$cnpj = $contrato['orgaoEntidade']['cnpj'] ?? '';
					$sequencialCompra = $contrato['sequencialCompra'] ?? '';
					$dataEncerramentoProposta = $contrato['dataEncerramentoProposta'] ?? '';

						// Verifica se os valores necessários estão presentes
					if (!empty($cnpj) && !empty($sequencialCompra)){
						
						// Monta a URL da segunda API
						//$secondApiUrl = "https://pncp.gov.br/api/pncp/v1/orgaos/$cnpj/compras/2025/$sequencialCompra/itens?pagina=1&tamanhoPagina=5";

						// Chama a segunda API e armazena a resposta
						$secondApiResponse = $this->fetchDataFromApiSegundo($cnpj, $sequencialCompra);
						    foreach($secondApiResponse as $item){
									//$materialOuServico = $item['materialOuServico'];
            							$dataEncPro = str_replace("-", "/", $dataEncerramentoProposta);
            							$dataEncerramentoProposta  = date('Ymd', strtotime($dataEncPro));
            			
            							if($dataEncerramentoProposta === $dataFinal && $item['materialOuServico'] == $tipo){
            								// Adiciona os dados ao array de resultados
            								$results[] = [
            									'contrato' => $contrato,
            									'itens' => $secondApiResponse,
            									'tipo' => $tipo
            								];
            								
            								$this->loadTemplate('telaPncp', ['data' => $results]);
            
            							}
            							
                            }
						
					//var_dump($results);
					//$this->loadTemplate('telaPncp', ['data' => $results]);

					}

					

				}

				

			}
// 			echo "<pre>";
// 			var_dump($results);
		//$this->loadTemplate('telaPncp', ['data' => $results]);
		//	echo "</pre>";

		}
	
		
		$this->loadTemplate('telaPncp', ['data' => $results]);
		//$this->loadTemplate('telaPncp', $results);


	}


}