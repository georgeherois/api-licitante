<!--<pre>-->
   <?php //var_dump($info); ?> 
<?php foreach($info['data'] as $k): ?>
   <!--</pre>-->
   <?php 

        // $curl = curl_init();
        // curl_setopt_array($curl, [
        // CURLOPT_RETURNTRANSFER => 1,
        // CURLOPT_URL => 'https://pncp.gov.br/api/pncp/v1/orgaos/'.$k['orgaoEntidade']['cnpj'].'/compras/2025/'.$k['sequencialCompra'].'/itens?pagina=1&tamanhoPagina=5'
        // ]);
        // $response = curl_exec($curl);		
        // $dados = json_decode($response, false);
        // curl_close($curl);

        // foreach($dados as $value){
        //      $tipoServiço = $value->materialOuServico;
        // }

   $dataE = str_replace("-", "/", $k['dataEncerramentoProposta']);
   $dataEncerramentoProposta  = date('Ymd', strtotime($dataE));
   if($dataEncerramentoProposta == $dataFinal):
   
    ?>
    <div class="shadow p-3 mb-5 bg-body rounded">
        <div class="d-flex flex-row bd-highlight mb-3">
            <div class="col-sm-auto style-font">
                <h3><?php echo $k['tipoInstrumentoConvocatorioNome']." - ".$k['numeroCompra']."/".$k['anoCompra']; ?></h3><br/>
            </div>
        </div>

        <div class="d-flex flex-row bd-highlight mb-3">
            <div class="col-sm-auto style-font">Local:
                <strong class="ng-star-inserted"><?php echo $k['orgaoEntidade']['razaoSocial'].'/'.$k['unidadeOrgao']['ufSigla']; ?></strong>
            </div>

            <div class="col-sm-auto style-font">Unidade compradora:
                <strong class="ng-star-inserted"><?php echo $k['orgaoEntidade']['razaoSocial']; ?></strong>
            </div>
        </div>

        <div class="d-flex flex-row bd-highlight mb-3">
            <div class="col-sm-auto style-font">Número do UASG:
                <strong class="ng-star-inserted"><?php echo $k['unidadeOrgao']['codigoUnidade']; ?></strong>
            </div>

            <div class="col-sm-auto style-font">Última Atualização:
                <?php $dataA = str_replace("-", "/", $k['dataAtualizacao']); ?>
                <strong class="ng-star-inserted"><?php echo  $dataAtualizacao  = date('d/m/Y', strtotime($dataA));?></strong>
            </div>
        </div>

        <div class="d-flex flex-row bd-highlight mb-3">
            <div class="col-sm-auto style-font">Data de Encerramento:
            <?php $dataE = str_replace("-", "/", $k['dataEncerramentoProposta']); ?>
                <strong class="ng-star-inserted"><?php echo $dataEncerramentoProposta  = date('d/m/Y H:i:s', strtotime($dataE)); ?></strong>
            </div>
            <div class="col-sm-auto style-font">Modalidade:
                <strong class="ng-star-inserted"><?php echo $k['modalidadeNome']; ?></strong>
            </div>
            <div class="col-sm-auto style-font">Fonte:
                <strong class="style-font-f"><?php echo $k['usuarioNome']; ?></strong>
            </div>
        </div>
        
      <div class="d-flex flex-row bd-highlight mb-3">
            <div class="col-sm-auto style-font">Link de Origem:
                <strong class="ng-star-inserted"><?php echo $k['linkSistemaOrigem'] = $k['linkSistemaOrigem'] == "" ? "Sem informação" : $k['linkSistemaOrigem']; ?></strong> 
            </div>
      </div>        

      <!--<div class="d-flex flex-row bd-highlight mb-3">-->
      <!--      <div class="col-sm-auto style-font">Tipo de Serviço:-->
      <!--          <strong class="style-font-l"><?php echo $value->materialOuServicoNome; ?></strong> -->
      <!--      </div>-->
      <!--</div>   -->

        <hr>
        <div class="d-flex flex-row bd-highlight mb-3">
            <div class="col-sm-auto style-font">Objeto:
                <div class="ng-star-inserted"><?php echo $k['objetoCompra']; ?></div>
            </div>
        </div>

        <hr>
        <div class="d-flex flex-row bd-highlight mb-3">
            <div class="col-sm-auto style-font">Informações Complementar:
                <div class="ng-star-inserted"><?php echo $k['informacaoComplementar']; ?></div>
            </div>
        </div>

        <hr>
        <div class="d-flex flex-row bd-highlight mb-3">
            <div class="col-sm-auto style-font">Valor Total Estimado:
                <div class="style-font-valor">
                    <div class="style-div"><?php echo "R$ ".number_format($k['valorTotalEstimado'],2,",","."); ?></div>
                </div>
            </div>
        </div>

        
        
    </div>
    <?php endif; ?>
    
<?php endforeach; ?>