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


	private function fetchDataFromApi($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Tempo limite de 10s para evitar travamentos
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($response, true);
    }


	public function getContratos($dataFinal, $modalidade, $totalPaginas) {
		$baseUrl = "https://pncp.gov.br/api/consulta/v1/contratacoes/proposta";
		$idUsuario = 3;
		$tamanhoPagina = 30;

		$mh = curl_multi_init(); // Inicializa o manipulador de múltiplas requisições
		$curlHandles = [];
		$responses = [];
		$results = [];

	    // Criar e adicionar múltiplas requisições
		for ($pagina = 1; $pagina <= $totalPaginas; $pagina++) {
			$url = "$baseUrl?dataFinal=$dataFinal&codigoModalidadeContratacao=$modalidade&idUsuario=$idUsuario&pagina=$pagina&tamanhoPagina=$tamanhoPagina";
	
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Desativar verificação SSL se necessário
	
			curl_multi_add_handle($mh, $ch);
			$curlHandles[$pagina] = $ch; // Armazena cada handle para depois pegar a resposta
		}	

		// Executa todas as requisições simultaneamente
		$running = null;
		do {
			curl_multi_exec($mh, $running);
		} while ($running);

		// Obter as respostas
		foreach ($curlHandles as $pagina => $ch) {
			$responses[$pagina] = json_decode(curl_multi_getcontent($ch), true);
			curl_multi_remove_handle($mh, $ch);
			curl_close($ch);
		}

		// foreach($responses as $contratos){
		// 	foreach ($contratos['data'] as $contrato) {
		// 				 $cnpj = $contrato['orgaoEntidade']['cnpj'] ?? '';
		// 				 $sequencialCompra = $contrato['sequencialCompra'] ?? '';

		// 				if (!empty($cnpj) && !empty($sequencialCompra)) {
		// 					$cnpjs[] = $cnpj;
		// 					$sequenciais[] = $sequencialCompra;
		// 				}
		// 			}
		// 		}
				

		// $itensRespostas = $this->getItensCompra($cnpjs, $sequenciais);
		// $results[] = [
		// 	'contrato' => $responses,
		// 	'itens' => $itensRespostas
		// ];


		curl_multi_close($mh); // Fecha o manipulador multi-cURL
		// echo "<pre>";
		// print_r($results);
		// echo "</pre>";
		return $responses; // Retorna todas as respostas em um array

    }

	public function getItensCompra($cnpj, $sequencialCompra){
      $multiCurl = [];
        $resultados = [];
        $mh = curl_multi_init();

	        // Criar requisições para todos os contratos simultaneamente
        foreach ($cnpj as $index => $cnpjs) {
             $sequencialCompras = $sequencialCompra[$index];
              $url = "https://pncp.gov.br/api/pncp/v1/orgaos/$cnpjs/compras/2025/$sequencialCompras/itens?pagina=1&tamanhoPagina=10";

            $multiCurl[$index] = curl_init();
            curl_setopt($multiCurl[$index], CURLOPT_URL, $url);
            curl_setopt($multiCurl[$index], CURLOPT_RETURNTRANSFER, true);
            curl_setopt($multiCurl[$index], CURLOPT_TIMEOUT, 10);
            curl_multi_add_handle($mh, $multiCurl[$index]);
        }

        // Executar todas as requisições simultaneamente
        $running = null;
        do {
            curl_multi_exec($mh, $running);
        } while ($running);

        // Coletar as respostas
        foreach ($multiCurl as $index => $ch) {
            $response = curl_multi_getcontent($ch);
            $resultados[$index] = json_decode($response, true);
            curl_multi_remove_handle($mh, $ch);
            curl_close($ch);

        }
		$material = [];
		foreach($resultados as $item){
			if($item['status'] != 404){
				$material[] = $item;
			}
		}

        curl_multi_close($mh);
		



		// echo "<pre>";
		//print_r($material);
       return $material;
	    // echo "</pre>";

		
	}

    public function getAllData($dataFinal, $modalidade, $totalPaginas, $tipo){

		
        	$firstApiResponse = $this->getContratos($dataFinal, $modalidade, $totalPaginas);
	
			$results = [];

			if (!empty($firstApiResponse)) {
				$cnpjs = [];
				$sequenciais = [];

				// foreach($firstApiResponse as $contratos){
				// 	foreach ($contratos['data'] as $contrato) {
				// 		 $cnpj = $contrato['orgaoEntidade']['cnpj'] ?? '';
				// 		 $sequencialCompra = $contrato['sequencialCompra'] ?? '';

				// 		if (!empty($cnpj) && !empty($sequencialCompra)) {
				// 			$cnpjs[] = $cnpj;
				// 			$sequenciais[] = $sequencialCompra;
				// 		}
				// 	}
				// }
				
				//Chamar a API de itens em paralelo
				//$itensRespostas = $this->getItensCompra($cnpjs, $sequenciais);

				// foreach($firstApiResponse as $contratos){
				// 	foreach ($contratos['data'] as $contrato) {
				// 		$dataEncerramentoProposta = $contrato['dataEncerramentoProposta'] ?? '';
				// 		$dataEncPro = str_replace("-", "/", $dataEncerramentoProposta);
				// 		$dataEncerramentoProposta  = date('Ymd', strtotime($dataEncPro));

				// 			foreach($itensRespostas as $item){
				// 				foreach($item as $itens){
				// 					 $materialOuServico = $itens['materialOuServico'];
				// 				}

				// 			}
				// 				if($dataEncerramentoProposta === $dataFinal && $materialOuServico === $tipo){
					
				// 					$results[] = [
				// 						'contrato' => $contrato,
				// 						'itens' => $itensRespostas
				// 					];

				// 				}
				// 	}
					
				// }
// 				echo "<pre>";
// print_r($firstApiResponse);
// echo "<pre>";
				// foreach($firstApiResponse as $contratos){
				// 	foreach ($contratos['data'] as $contrato) {
				// 		$dataEncerramentoProposta = $contrato['dataEncerramentoProposta'] ?? '';
				// 		$dataEncPro = str_replace("-", "/", $dataEncerramentoProposta);
				// 		$dataEncerramentoProposta  = date('Ymd', strtotime($dataEncPro));

				// 		if($dataEncerramentoProposta === $dataFinal){
				// 			$results[] = [
				// 				'contrato' => $contrato,
				// 				'itens' => $itensRespostas
				// 			];
				// 		}
				// 	}
				// }

			}
		//   echo "<pre>";
		// //print_r($item);
       return $firstApiResponse;
	  	//  echo "</pre>";
	}

	public function selectDados(){

		$fonte 		  = $_POST['fonte'];
		$tipo  		  = $_POST['tipo'];
		$dataIn  	  = str_replace("/", "-", $_POST["dataInicial"]);
		$dataInicial  = date('Ymd', strtotime($dataIn));
		$dataFin  	  = str_replace("/", "-", $_POST["dataFinal"]);
		$dataFinal 	  = date('Ymd', strtotime($dataFin));
		$modalidade   = $_POST['modalidade'];


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

			$resultado = $this->getAllData($dataFinal, $modalidade, $totalPaginas, $tipo);
			
			if(!empty($resultado)){
			$this->loadTemplate('telaPncp', ['data' => $resultado]);
			// Exibir os resultados
			//   echo "<pre>";
			// print_r($resultado);
			//   echo "</pre>";

			
			}else{
				$this->loadTemplate('telaPncpSemDados');
				exit;
			}
		

		//Quando a opção for o COMPRAS NET	
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