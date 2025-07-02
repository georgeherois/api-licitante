<?php
class apiController extends controller
{

    public function getContratos($dataFinal, $modalidade, $totalPaginas, $dataInicial, $consultarMesInteiro)
    {

        $baseUrl = "https://pncp.gov.br/api/consulta/v1/contratacoes/proposta";
        $idUsuario = 3;
        $tamanhoPagina = 30;

        $mh = curl_multi_init();
        $curlHandles = [];
        $results = [];

        for ($pagina = 1; $pagina <= $totalPaginas; $pagina++) {
            $url = "$baseUrl?"
                . ($consultarMesInteiro === 1
                    ? "dataInicial=$dataInicial&dataFinal=$dataFinal"
                    : "dataFinal=$dataFinal")
                . "&codigoModalidadeContratacao=$modalidade"
                . "&idUsuario=$idUsuario"
                . "&pagina=$pagina"
                . "&tamanhoPagina=$tamanhoPagina";

            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT => 20
            ]);
            curl_multi_add_handle($mh, $ch);
            $curlHandles[$pagina] = $ch;
        }

        // Executa todas as requisições simultaneamente (não bloqueante)
        $running = null;
        do {
            curl_multi_exec($mh, $running);
            curl_multi_select($mh); // Reduz uso de CPU
            usleep(50000); // Pequena pausa para aliviar CPU
        } while ($running > 0);

        foreach ($curlHandles as $pagina => $ch) {
            $response = curl_multi_getcontent($ch);
            curl_multi_remove_handle($mh, $ch);
            curl_close($ch);

            $data = json_decode($response, true);
            if (!empty($data['data'])) {
                if ($consultarMesInteiro === 2) {
                    $results = array_merge($results, array_filter($data['data'], function ($item) use ($dataFinal) {
                        $enc = str_replace("-", "/", $item['dataEncerramentoProposta'] ?? '');
                        return date('Ymd', strtotime($enc)) === $dataFinal;
                    }));
                } else {
                    $results = array_merge($results, $data['data']);
                }
            }
        }

        curl_multi_close($mh);
        return $results;
    }


    public function getAllData($dataFinal, $modalidade, $totalPaginas, $dataInicial, $consultarMesInteiro)
    {


        return $this->getContratos($dataFinal, $modalidade, $totalPaginas, $dataInicial, $consultarMesInteiro);

        //echo "<pre>";
        //print_r($firstApiResponse);
        //return $firstApiResponse;
        //echo "</pre>";
    }

    public function consultar()
    {

        $fonte           = $_POST['fonte'];
        $tipo            = $_POST['tipo'];
        $modalidade   = $_POST['modalidade'];
        $status        = $_POST['status'];
        $modoComprasPublicas   = $_POST['modoModalidade'];

        if ($fonte === "3") {

            $dataInicial = null;
            $dataFinal = null;
            $consultarMesInteiro = 2;

            if (!empty($_POST['dataInicial']) && !empty($_POST['dataFinal'])) {
                $dataInicial = date('Ymd', strtotime(str_replace("/", "-", $_POST['dataInicial'])));
                $dataFinal = date('Ymd', strtotime(str_replace("/", "-", $_POST['dataFinal'])));
                $consultarMesInteiro = 1;
            }

            if (empty($_POST['dataInicial']) && empty($_POST['dataFinal'])) {
                $dataInicial = date('Ym01');
                $dataFinal = date('Ymt');
                $consultarMesInteiro = 1;
            }

            if (empty($_POST['dataInicial']) && !empty($_POST['dataFinal'])) {
                $dataFinal = date('Ymd', strtotime(str_replace("/", "-", $_POST['dataFinal'])));
            }

            // Obtém a quantidade de páginas
            $urlBase = $consultarMesInteiro === 1
                ? "https://pncp.gov.br/api/consulta/v1/contratacoes/publicacao?dataInicial=$dataInicial&dataFinal=$dataFinal"
                : "https://pncp.gov.br/api/consulta/v1/contratacoes/proposta?dataFinal=$dataFinal";

            $url = "$urlBase&codigoModalidadeContratacao=$modalidade&idUsuario=3&pagina=1";
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_URL => $url,
                CURLOPT_SSL_VERIFYPEER => false
            ]);

            $response = curl_exec($curl);
            curl_close($curl);

            $dados = json_decode($response);
            $totalPaginas = $dados->totalPaginas ?? 1;
            $resultado['data'] = $this->getAllData($dataFinal, $modalidade, $totalPaginas, $dataInicial, $consultarMesInteiro);
            $resultado['tipo'] = $tipo;


            if (!empty($resultado['data'])) {
                $this->loadTemplate('telaPncp', $resultado);
            } else {
                $this->loadTemplate('telaPncpSemDados');
            }

            exit;
        }

        if ($_POST['fonte'] === "2") {

            $dataFin        = !empty($_POST['dataFinal']) ? str_replace("/", "-", $_POST['dataFinal']) : date('Y-m-t');
            $dataFinal       = date('Ymd', strtotime($dataFin));

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
