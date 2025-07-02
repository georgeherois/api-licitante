<?php
class apiController extends controller
{

	public function getContratos($dataFinal, $modalidade, $totalPaginas, $dataInicial, $consultarMesInteiro)
	{

		$baseUrl = "https://pncp.gov.br/api/consulta/v1/contratacoes/proposta";
		$idUsuario = 3;
		$tamanhoPagina = 30;

		$mh = curl_multi_init(); // Inicializa o manipulador de múltiplas requisições
		$curlHandles = [];
		$responses = [];
		$results = [];

		// Criar e adicionar múltiplas requisições
		for ($pagina = 1; $pagina <= $totalPaginas; $pagina++) {

			if ($consultarMesInteiro === 2) {

				$url = "$baseUrl?dataFinal=$dataFinal&codigoModalidadeContratacao=$modalidade&idUsuario=$idUsuario&pagina=$pagina&tamanhoPagina=$tamanhoPagina";
			}
			if ($consultarMesInteiro === 1) {

				$url = "$baseUrl?dataInicial=$dataInicial&dataFinal=$dataFinal&codigoModalidadeContratacao=$modalidade&idUsuario=$idUsuario&pagina=1";
			}


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

		if ($consultarMesInteiro === 2) {

			foreach ($responses as $contrato) {
				foreach ($contrato['data'] as $value) {
					$dataEncerramentoProposta = $value['dataEncerramentoProposta'] ?? '';
					$dataEncPro = str_replace("-", "/", $dataEncerramentoProposta);
					$dtEncerramentoProposta  = date('Ymd', strtotime($dataEncPro));
					if ($dtEncerramentoProposta === $dataFinal) {

						$results[] = $value;
					}
				}
			}
		} else {

			foreach ($responses as $contrato) {
				foreach ($contrato['data'] as $value) {

					$results[] = $value;
				}
			}
		}



		curl_multi_close($mh); // Fecha o manipulador multi-cURL
		// echo "<pre>";
		// print_r($results);
		// echo "</pre>";
		return $results; // Retorna todas as respostas em um array

	}


	public function getAllData($dataFinal, $modalidade, $totalPaginas, $dataInicial, $consultarMesInteiro)
	{


		$firstApiResponse = $this->getContratos($dataFinal, $modalidade, $totalPaginas, $dataInicial, $consultarMesInteiro);

		//echo "<pre>";
		//print_r($firstApiResponse);
		return $firstApiResponse;
		//echo "</pre>";
	}

	public function consultar()
	{

		$fonte 		  = $_POST['fonte'];
		$tipo  		  = $_POST['tipo'];
		$modalidade   = $_POST['modalidade'];
		$status  	  = $_POST['status'];
		$modoComprasPublicas   = $_POST['modoModalidade'];

		if ($fonte === "3") {

			if (!empty($_POST['dataInicial']) && !empty($_POST['dataFinal'])) {
				$dataIn  	  = !empty($_POST['dataInicial']) ? str_replace("/", "-", $_POST['dataInicial']) : date('Y-m-01');
				$dataInicial  = date('Ymd', strtotime($dataIn));
				$dataFin  	  = !empty($_POST['dataFinal']) ? str_replace("/", "-", $_POST['dataFinal']) : date('Y-m-t');
				$dataFinal 	  = date('Ymd', strtotime($dataFin));
				$dados = [];
				$resultado = [];
				// Monta a URL da primeira API
				//Buscar o tamanho da pagina para iniciar o loop
				$curl = curl_init();
				curl_setopt_array($curl, [
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'https://pncp.gov.br/api/consulta/v1/contratacoes/publicacao?dataInicial=' . $dataInicial . '&dataFinal=' . $dataFinal . '&codigoModalidadeContratacao=' . $modalidade . '&idUsuario=3&pagina=1'
				]);

				$consultarMesInteiro = 1;
			}

			if (empty($_POST['dataInicial']) && empty($_POST['dataFinal'])) {
				$dataIn  	  = !empty($_POST['dataInicial']) ? str_replace("/", "-", $_POST['dataInicial']) : date('Y-m-01');
				$dataInicial  = date('Ymd', strtotime($dataIn));
				$dataFin  	  = !empty($_POST['dataFinal']) ? str_replace("/", "-", $_POST['dataFinal']) : date('Y-m-t');
				$dataFinal 	  = date('Ymd', strtotime($dataFin));
				$dados = [];
				$resultado = [];
				// Monta a URL da primeira API
				//Buscar o tamanho da pagina para iniciar o loop
				$curl = curl_init();
				curl_setopt_array($curl, [
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'https://pncp.gov.br/api/consulta/v1/contratacoes/publicacao?dataInicial=' . $dataInicial . '&dataFinal=' . $dataFinal . '&codigoModalidadeContratacao=' . $modalidade . '&idUsuario=3&pagina=1'
				]);

				$consultarMesInteiro = 1;
			}

			if (empty($_POST['dataInicial']) && !empty($_POST['dataFinal'])) {
				$dataFin  	  = !empty($_POST['dataFinal']) ? str_replace("/", "-", $_POST['dataFinal']) : date('Y-m-t');
				$dataFinal 	  = date('Ymd', strtotime($dataFin));
				$dados = [];
				$resultado = [];
				// Monta a URL da primeira API
				//Buscar o tamanho da pagina para iniciar o loop
				$curl = curl_init();
				curl_setopt_array($curl, [
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'https://pncp.gov.br/api/consulta/v1/contratacoes/proposta?dataFinal=' . $dataFinal . '&codigoModalidadeContratacao=' . $modalidade . '&idUsuario=3&pagina=1&tamanhoPagina=10'
				]);

				$consultarMesInteiro = 2;
			}

			$response = curl_exec($curl);
			curl_close($curl);

			$dados = json_decode($response, false);
			$totalPaginas = $dados->totalPaginas;

			$resultado['data'] = $this->getAllData($dataFinal, $modalidade, $totalPaginas, $dataInicial, $consultarMesInteiro);

			if (!empty($resultado['data'])) {
				$resultado['tipo'] = $tipo;
				$this->loadTemplate('telaPncp', $resultado);
				exit;
				//Exibir os resultados
				// echo "<pre>";
				// print_r($resultado);
				// echo "</pre>";
			} else {
				$this->loadTemplate('telaPncpSemDados');
				exit;
			}
		}

		if ($_POST['fonte'] === "2") {

			$dataFin  	  = !empty($_POST['dataFinal']) ? str_replace("/", "-", $_POST['dataFinal']) : date('Y-m-t');
			$dataFinal 	  = date('Ymd', strtotime($dataFin));

			//Chamar a função compras Publicas se todos os campos forem preenchidos
			$this->getComprasPublicas($status, $dataFinal, $modoComprasPublicas);
		}
	}

	public function getComprasPublicas($status, $dataFinal, $modoComprasPublicas)
	{


		//$dataInicial = date('Y-m-d');
		$dataInicialFormatada = date("Y-m-d", strtotime($dataFinal));
		$dados = [];
		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'https://compras.api.portaldecompraspublicas.com.br/v2/licitacao/processos?codigoModalidade=' . $modoComprasPublicas . '&codigoRealizacao=' . $status . '&dataInicial=' . $dataInicialFormatada . 'T03:00:00.000Z&dataFinal=' . $dataInicialFormatada . 'T03:00:00.000Z&tipoData=1&codigoStatus=1'
		]);

		$response = curl_exec($curl);

		$dados['data'] = json_decode($response, false);
		curl_close($curl);


		if (!empty($dados['data'])) {
			$this->loadTemplate("compras-publicas", $dados);
			exit;
		} else {
			$this->loadTemplate('telaPncpSemDados');
			exit;
		}
	}
}
