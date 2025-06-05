  
                         
                          <?php foreach($info as $array): ?>

                           <?php
                            $url = 'https://pncp.gov.br/api/pncp/v1/orgaos/'.$array['tb_cnpj'].'/compras/2024/'.$array['tb_num_sequencial'].'/itens?pagina=1&tamanhoPagina=10';                    
                            $ch = curl_init($url);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                             $tabela = json_decode(curl_exec($ch));
                             foreach($tabela as $k){
                                $materialOuServico = $k->materialOuServico;
                             }       
                            
                            ?>

                        <?php if($materialOuServico == $tipo): ?>
                            <div class="shadow p-3 mb-5 bg-body rounded">   
                            <h3><?php echo $array['tb_title']; ?></h3><br/> 
                            
                                                
                                                <div class="d-flex flex-row bd-highlight mb-3">
                                                        <div class="col-sm-auto style-font">Local:
                                                        <strong class="ng-star-inserted"><?php echo $array['tb_municipio_nome'].'/'.$array['tb_uf']; ?> </strong>
                                                        </div>

                                                        <div class="col-sm style-font">Órgão:
                                                        <strong class="ng-star-inserted"><?php echo $array['tb_orgao_nome']; ?></strong>
                                                        </div> 

                                                                                                            
                                                        <div class="col-sm style-font">Unidade compradora:
                                                        <strong class="ng-star-inserted"><?php echo $array['tb_unidade_codigo'].'-'.$array['tb_unidade_nome']; ?></strong>
                                                        </div>
                                                        </div>
                                                        
                                                        <div class="d-flex flex-row bd-highlight mb-3">
                                                        <div class="col-sm-auto style-font">Data de divulgação no PNCP:
                                                        <strong class="ng-star-inserted"><?php  echo (date("d/m/Y H:i:s", strtotime($array['tb_data_publicacao_pncp']))); ?></strong>
                                                        </div>
                                                        

                                                        
                                                        <div class="col-sm-auto style-font">Data de início de recebimento de propostas:
                                                        <strong class="ng-star-inserted"><?php echo (date("d/m/Y H:i:s", strtotime($array['tb_data_inicio_vigencia']))); ?></strong>
                                                        </div>
                                                        </div>

                                                        <div class="d-flex flex-row bd-highlight mb-3">
                                                        <div class="col-sm-auto style-font">Data fim de recebimento de propostas:                                                            
                                                        <strong class="ng-star-inserted"><?php echo (date("d/m/Y H:i:s", strtotime($array['tb_data_fim_vigencia']))); ?></strong>
                                                        </div>

                                                        <div class="col-sm-auto style-font">Atualizado em:
                                                        <strong class="ng-star-inserted"><?php echo (date("d/m/Y", strtotime($array['tb_data_atualizacao_pncp'])));   ?></strong>
                                                        </div>
                                                       </div>                                                

                                                        <div class="d-flex flex-row bd-highlight mb-3"> 
                                                        <div class="col-sm-auto style-font">Fonte:
                                                        <strong class="ng-star-inserted"><?php echo $array['tb_usuarioNome'];?></strong>
                                                        </div>
                                                        </div>

                                                        <div class="d-flex flex-row bd-highlight mb-3"> 
                                                        <div class="col-sm style-font">Objeto:
                                                        <strong class="ng-star-inserted"><?php echo $array['tb_objeto']; ?></strong> 
                                                        </div>
                                                       </div>
        

                                                       <div class="d-flex flex-row bd-highlight mb-3">
                                                        <div class="col-sm-auto style-font-final">VALOR TOTAL ESTIMADO DA COMPRA:                                        
                                                        <strong class="ng-star-inserted style-font-valor"><?php echo "R$ ".$num_formatado = number_format($array['tb_valorEstimado'], 2, ',', '.');  ?></strong> 
                                                        </div>
                                                    </div> 


                                                    <div class="d-flex flex-row bd-highlight mb-3">    
                                                        <div class="col-sm style-font-doc">Documento:
                                                            <?php //$cont = 0; ?>

                                                                
                                                                        <?php //$cont = $cont + 1; ?>
                                                                        <a class="btn btn-success" data-bs-toggle="collapse" href="" role="button" aria-expanded="false" aria-controls="collapseExample">Arquivo<?php //echo $cont.' - '.$download['tb_titulo']; ?></a>                                    
                                                           <?php //endif; ?>
                                                            <?php //endforeach; ?> 
                                                        </div>                           
                                                                
                                                    </div>

                                                    <br>

                                                            <table class="table table-bordered">
                                                                <thead class="table-dark">
                                                                    <tr class="style-tabela">
                                                                    <th>Numero Item</th>
                                                                    <th>Descrição</th>
                                                                    <th>Quantidade</th>
                                                                    <th>Unidade</th>
                                                                    <th>Valor Unitário</th>
                                                                    <th>Valor Total</th>
                                                                    <th>Tipo</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php foreach($tabela as $k): ?>
                                                                       
                                                                       <tr>
                                                                       
                                                                       <th class="style-tabela" scope="row"><?php echo $k->numeroItem; ?></th>
                                                                       <td><?php echo $k->descricao; ?></td>
                                                                       <td class="style-tabela"><?php echo $k->quantidade; ?></td>
                                                                       <td class="style-tabela"><?php echo$k->unidadeMedida; ?></td>                                                                    
                                                                       <td class="style-tabela"><?php echo "R$ ".$valor_unitario = number_format($k->valorUnitarioEstimado, 2, ',', '.'); ?></td>  
                                                                       <td class="style-tabela"><?php echo "R$ ".$valor_total = number_format($k->valorTotal, 2, ',', '.'); ?></td>                                               
                                                                       <td class="style-tabela"><?php echo $k->materialOuServicoNome; ?></td>
                                                                      
                                                                       </tr>
                                                                   <?php endforeach; ?>
                                                                   
   
                                                                   </tbody>
    
                                                                
                                                                
                                                            </table> 
                                                            <br>
                                                            </div>
                                                              <?php endif; ?>
                                                                
                                                            <?php endforeach; ?>
                                                           