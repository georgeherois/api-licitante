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


    private function buscarContratacoes($dataFinal, $modalidade){

		$pagina = 1;
        $resultados = [];
		$dados = array();
        
        do {

			$url = "https://pncp.gov.br/api/consulta/v1/contratacoes/proposta";
            $response = Http::get($url, [
                'dataFinal' => $dataFinal,
                'codigoModalidadeContratacao' => $modalidade,
                'idUsuario' => 3,
                'pagina' => $pagina,
                'tamanhoPagina' => 30
            ])->json();
            
            
            if (!$response || empty($response)) {
                break;
            }
            
            foreach ($response as $item) {

			
				echo $item['sequencialCompra'];
                if (isset($item['cnpj'], $item['sequencialCompra'])) {
                    $resultados[] = [
                        'cnpj' => $item['cnpj'],
                        'sequencialCompra' => $item['sequencialCompra']
                    ];
                }
            }
            
            //$pagina++;
        }while(!empty($response));
		//var_dump($dados);

		return $resultados;
					

		
	}

	private function buscarItensCompra($cnpj, $sequencialCompra){

        $url = "https://pncp.gov.br/api/pncp/v1/orgaos/$cnpj/compras/2025/$sequencialCompra/itens";
        $response = Http::get($url, [
            'pagina' => 1,
            'tamanhoPagina' => 5
        ])->json();
        
        $materiais = [];
        if ($response && !empty($response)) {
            foreach ($response as $item) {
                if (isset($item['materialOuServico']) && $item['materialOuServico'] === 'M') {
                    $materiais[] = $item;
                }
            }
        }
        return $materiais;

		
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
		$contratacoes = $this->buscarContratacoes($dataFinal, $modalidade);
        $materiaisFiltrados = [];
        
        //foreach ($contratacoes['data'] as $contratacao) {
           // $materiais = $this->buscarItensCompra($contratacao['cnpj'], $contratacao['sequencialCompra']);
            // if (!empty($materiais)) {
            //     $materiaisFiltrados = array_merge($materiaisFiltrados, $materiais);
            // }
       // }
        
        //return $materiaisFiltrados;
		var_dump($contratacoes);
    


	}


}