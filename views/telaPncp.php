  <?php
    // Exibir os resultados
    //    echo "<pre>";
    //  print_r($data);
    //    echo "</pre>";
    $barra = '/';
    $anoAtual = date('Y');

    foreach ($data as $k):

        $result = array();
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://pncp.gov.br/api/pncp/v1/orgaos/' . $k['orgaoEntidade']['cnpj'] . '/compras/2025/' . $k['sequencialCompra'] . '/itens?pagina=1&tamanhoPagina=10'
        ]);

        $response = curl_exec($curl);
        $res = json_decode($response, false);
        foreach ($res as $itens) {

            $materialOuServico = $itens->materialOuServico;
        }
    ?>
      <?php if ($materialOuServico == $tipo): ?>

          <div class="shadow p-3 mb-5 bg-body rounded">
              <div class="d-flex flex-row bd-highlight mb-3">
                  <div class="col-sm-auto style-font">
                      <h3><?php echo $k['tipoInstrumentoConvocatorioNome'] . " - " . $k['numeroCompra'] . "/" . $k['anoCompra']; ?></h3><br />
                  </div>
              </div>

              <div class="d-flex flex-row bd-highlight mb-3">
                  <div class="col-sm-auto style-font"><strong>Local:</strong> &nbsp;<?php echo $k['orgaoEntidade']['razaoSocial'] . '/' . $k['unidadeOrgao']['ufSigla']; ?>

                  </div>

                  <div class="flex-wrap flex-md-nowrap style-font"> &nbsp;&nbsp;<strong>Unidade compradora:</strong> &nbsp; <?php echo $k['orgaoEntidade']['razaoSocial']; ?>

                  </div>
              </div>

              <div class="d-flex flex-row bd-highlight mb-3">
                  <div class="col-sm-auto style-font"><strong>Número do UASG:</strong>&nbsp;<?php echo $k['unidadeOrgao']['codigoUnidade']; ?>

                  </div>

                  <?php $dataA = str_replace("-", "/", $k['dataAtualizacao']); ?>
                  <div class="col-sm-auto style-font">&nbsp;&nbsp;<strong>Última Atualização:</strong> <?php echo  $dataAtualizacao  = date('d/m/Y', strtotime($dataA)); ?>
                  </div>
              </div>

              <?php $dataE = str_replace("-", "/", $k['dataEncerramentoProposta']); ?>
              <div class="d-flex flex-row bd-highlight mb-3">
                  <div class="col-sm-auto style-font"><strong>Data de Encerramento:</strong>&nbsp; <?php echo $dataEncerramentoProposta  = date('d/m/Y H:i:s', strtotime($dataE)); ?>

                  </div>
                  <div class="col-sm-auto style-font">&nbsp;&nbsp;<strong>Modalidade:</strong>&nbsp;<?php echo $k['modalidadeNome']; ?>

                  </div>
                  <div class="col-sm-auto style-font">&nbsp;&nbsp;<strong>Fonte:</strong>&nbsp; <?php echo $k['usuarioNome']; ?>

                  </div>
              </div>

              <div class="d-flex flex-row bd-highlight mb-3">
                  <div class="flex-wrap flex-md-nowrap style-font"><strong>Link de Origem:</strong>
                      <strong class="ng-star-inserted">
                          <a href="<?php echo $k['linkSistemaOrigem'] = $k['linkSistemaOrigem'] == "" ? "Sem informação" : $k['linkSistemaOrigem']; ?>" target="_blank">
                              <?php echo $k['linkSistemaOrigem'] = $k['linkSistemaOrigem'] == "" ? "Sem informação" : $k['linkSistemaOrigem']; ?>
                          </a></strong>
                  </div>
              </div>

              <!--<div class="d-flex flex-row bd-highlight mb-3">-->
              <!--      <div class="col-sm-auto style-font">Tipo de Serviço:-->
              <!--          <strong class="style-font-l"><?php echo $value->materialOuServicoNome; ?></strong> -->
              <!--      </div>-->
              <!--</div>   -->

              <hr>
              <div class="d-flex flex-row bd-highlight mb-3">
                  <div class="flex-wrap flex-md-nowrap style-font"><strong>Objeto:</strong>
                      <div class="ng-star-inserted"><?php echo $k['objetoCompra']; ?></div>
                  </div>
              </div>

              <hr>
              <div class="d-flex flex-row bd-highlight mb-3">
                  <div class="flex-wrap flex-md-nowrap style-font"><strong>Informações Complementar:</strong>
                      <div class="ng-star-inserted"><?php echo $k['informacaoComplementar']; ?></div>
                  </div>
              </div>

              <!--- Essa API vai trazer os documentos para anexar ---->
              <?php
                $arq = [];
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => 'https://pncp.gov.br/api/pncp/v1/orgaos/' . $k['orgaoEntidade']['cnpj'] . '/compras' . $barra . $anoAtual . '/' . $k['sequencialCompra'] . '/arquivos?pagina=1&tamanhoPagina=5'
                ]);
                $response = curl_exec($curl);
                $arq = json_decode($response, false);
                ?>

              <hr>

              <div class="d-flex flex-row bd-highlight mb-3">
                  <?php foreach ($arq as $download): ?>
                      <div class="col-sm-auto style-font"><strong>Documento:</strong>
                          <a class="btn btn-success" data-bs-toggle="collapse" href="<?php echo $download->url; ?>" role="button" aria-expanded="false" aria-controls="collapseExample"><?php echo $download->titulo; ?></a>
                      </div>
                  <?php endforeach; ?>
              </div>

              <hr>
              <div class="d-flex flex-row bd-highlight mb-3">
                  <div class="col-sm-auto style-font"><strong>Valor Total Estimado:</strong>
                      <div class="style-font-valor">
                          <div class="alert alert-danger" role="alert" style="font-size: 1.2rem"><?php echo "R$ " . number_format($k['valorTotalEstimado'], 2, ",", "."); ?></div>
                      </div>
                  </div>
              </div>




              <table class="table table-bordered">
                  <thead class="table-dark">
                      <tr style="text-align: center">
                          <th>Numero Item</th>
                          <th>Descrição</th>
                          <th>Quantidade</th>
                          <th>Valor Unitário</th>
                          <th>Valor Total</th>
                          <th>Tipo</th>
                      </tr>
                  </thead>


                  <?php foreach ($res as $itens): ?>
                      <tbody>
                          <tr>
                              <th style="text-align: center" scope="row"><?php echo $itens->numeroItem; ?></th>
                              <td><?php echo $itens->descricao; ?></td>
                              <td style="text-align: center"><?php echo $itens->quantidade; ?></td>
                              <td style="text-align: center"><?php echo "R$ " . $valor_unitario = number_format($itens->valorUnitarioEstimado, 2, ',', '.'); ?></td>
                              <td style="text-align: center"><?php echo "R$ " . $valor_total = number_format($itens->valorTotal, 2, ',', '.'); ?></td>
                              <td style="text-align: center"><?php echo $itens->materialOuServicoNome; ?></td>
                          </tr>
                      </tbody>

                  <?php endforeach; ?>



              </table>

          </div>

      <?php endif; ?>



  <?php endforeach; ?>