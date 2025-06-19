                        
                        
       
                          <?php 
                            foreach($info->items as $array): 
                                                              
                                $result = array();
                                $curl = curl_init();
                                curl_setopt_array($curl, [
                                CURLOPT_RETURNTRANSFER => 1,
                                CURLOPT_URL => 'https://pncp.gov.br/api/pncp/v1/orgaos/'.$array->orgao_cnpj.'/compras/2024/'.$array->numero_sequencial.'/itens?pagina=1&tamanhoPagina=10'
                                ]);

                                $response = curl_exec($curl);		
                                $res = json_decode($response, false);
                                foreach($res as $itens){

                                $materialOuServicoNome = $itens->materialOuServicoNome;

                               }
                                ?>
                                      <?php if($materialOuServicoNome == 'Material'): ?>
                                                        <div class="d-flex flex-row bd-highlight mb-3">
                                                        <div class="col-sm-auto style-font">Local:
                                                        <strong class="ng-star-inserted"><?php echo $array->municipio_nome."/".$array->uf; ?> </strong>
                                                        </div>

                                                        <div class="col-sm-auto style-font">Órgão:
                                                        <strong class="ng-star-inserted"><?php echo $array->orgao_nome; ?></strong>
                                                        </div> 

                                                    
                                                        <div class="col-sm style-font">Unidade compradora:
                                                        <strong class="ng-star-inserted"><?php echo $array->unidade_codigo." - ".$array->unidade_nome; ?></strong>
                                                        </div>
                                                        </div>
                                                                                                       
                                                        <div class="d-flex flex-row bd-highlight mb-3">
                                                        <div class="col-sm-auto style-font">Tipo:
                                                        <strong class="ng-star-inserted"><?php echo $array->tipo_nome; ?></strong> 
                                                        </div>
                                                        <div class="col-sm-auto style-font">Data de divulgação no PNCP:
                                                            <?php 
                                                            $a = new DateTime($array->data_publicacao_pncp);
                                                            $dataPNCP = $a->format('d/m/Y');
                                                            ?>

                                                        <strong class="ng-star-inserted"><?php echo $dataPNCP; ?></strong>
                                                        </div>
                                                        </div>

                                                        <div class="d-flex flex-row bd-highlight mb-3">
                                                        <div class="col-sm-auto style-font">Data de início de recebimento de propostas:
                                                            <?php 
                                                            $b = new DateTime($array->data_inicio_vigencia);
                                                            $dataRecebimento = $b->format('d/m/Y H:i:s');
                                                            ?>
                                                        <strong class="ng-star-inserted"><?php echo $dataRecebimento  == null ? 'Sem data' :  $dataRecebimento." (horário de Brasília)"; ?></strong>
                                                        </div>
                                                        </div>

             

                                                            <table class="table table-bordered">
                                                                <thead class="table-dark">
                                                                    <tr class="style-tabela">
                                                                    <th>Numero Item</th>
                                                                    <th>Descrição</th>
                                                                    <th>Categoria</th>
                                                                    <th>Unidade</th>
                                                                    <th>Valor Unitário</th>
                                                                    <th>Valor Total</th>
                                                                    <th>Tipo</th>
                                                                    </tr>
                                                                </thead>
                                                                    
                                                                        
                                                                <?php foreach($res as $itens): ?>
                                                                <tbody>
                                                                    <tr>
                                                                    <th class="style-tabela" scope="row"><?php echo $itens->numeroItem; ?></th>
                                                                    <td><?php echo $itens->descricao; ?></td>
                                                                    <td class="style-tabela"><?php echo $itens->itemCategoriaNome; ?></td>
                                                                    <td class="style-tabela"><?php echo  $itens->quantidade; ?></td>                                                
                                                                    <td class="style-tabela"><?php echo "R$ ".$valor_unitario = number_format($itens->valorUnitarioEstimado, 2, ',', '.'); ?></td>                                                              
                                                                    <td class="style-tabela"><?php echo "R$ ".$valor_total = number_format($itens->valorTotal, 2, ',', '.'); ?></td>
                                                                    <td class="style-tabela"><?php echo $itens->materialOuServicoNome; ?></td>
                                                                    </tr>
                                                                </tbody>
                                                        
                                                                <?php endforeach; ?>
                                                                
                                                                
                                                                
                                                            </table> 
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>