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


	public function selectDados(){

		$fonte 		  = $_POST['fonte'];
		$tipo  		  = $_POST['tipo'];
		$dataIn  	  = str_replace("/", "-", $_POST["dataInicial"]);
		$dataInicial  = date('Ymd', strtotime($dataIn));
		$dataFin  	  = str_replace("/", "-", $_POST["dataFinal"]);
		$dataFinal 	  = date('Ymd', strtotime($dataFin));
		$modalidade   = $_POST['modalidade'];
		$horaAtual = date('H:i');

		//Buscar o tamanho da pagina para iniciar o loop
		$curl = curl_init();
		curl_setopt_array($curl, [
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => 'https://pncp.gov.br/api/consulta/v1/contratacoes/proposta?dataFinal='.$dataFinal.'&codigoModalidadeContratacao='.$modalidade.'&idUsuario=3&pagina=1&tamanhoPagina=10'
		]);
		$response = curl_exec($curl);		
		$dados = json_decode($response, false);
		curl_close($curl);

		// Defina o número de páginas que você quer consultar
			$totalPaginas = $dados->totalPaginas;  // Por exemplo, 5 páginas
			$dados = array();

		// Laço para fazer múltiplas requisições
			for ($pagina = 1; $pagina <= $totalPaginas; $pagina++) {
				//echo "Consultando a página $pagina...\n";
				
				// Chama a função para acessar a API e passar o número da página
					$dados = $this->acessarApi($pagina, $dataInicial, $dataFinal, $modalidade);

				// Verifica se a consulta retornou dados
				if ($dados !== null) {
					//echo "Dados recebidos da página $pagina:\n";
					//echo '<pre>';
					//print_r($dados);  // Exibe os dados da página
					//echo '</pre>';
				     $dados['info'] = $dados;
				     $dados['dataFinal'] = $dataFinal;
					 $dados['horaAtual'] = $horaAtual;
					 $dados['tipo'] = $tipo;
					 $this->loadTemplate('telaPncp', $dados);
					
				} else {
					//echo "Erro ao acessar os dados da página $pagina.\n";
				}
				// Atraso entre as requisições para evitar sobrecarga no servidor (opcional)
				sleep(1);
				//set_time_limit(500); // 

			}
	
			$this->loadTemplate('telaPncpSemDados');
			exit;

	}

	private function acessarApi($pagina, $dataInicial, $dataFinal, $modalidade){

		    // URL base da API
			 $url = "https://pncp.gov.br/api/consulta/v1/contratacoes/proposta?dataFinal=$dataFinal&codigoModalidadeContratacao=$modalidade&idUsuario=3&pagina=$pagina&tamanhoPagina=30";
			  //$url = "https://pncp.gov.br/api/consulta/v1/contratacoes/publicacao?dataInicial=$dataInicial&dataFinal=$dataFinal&codigoModalidadeContratacao=$modalidade&idUsuario=3&pagina=$pagina";

			// Inicia a sessão cURL
			$ch = curl_init();
		
			// Configura a URL da requisição
			curl_setopt($ch, CURLOPT_URL, $url);
		
			// Configura para retornar a resposta como string em vez de exibir no navegador
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
			// Executa a requisição e armazena a resposta
			$response = curl_exec($ch);
		
			// Verifica se houve erro na requisição
			if(curl_errno($ch)) {
				echo 'Erro cURL: ' . curl_error($ch);
				curl_close($ch);
				return null;
			}
		
			// Fecha a sessão cURL
			curl_close($ch);
		
			// Converte a resposta JSON para um array PHP
			return json_decode($response, true);

	}


}