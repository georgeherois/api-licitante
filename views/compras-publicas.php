
                        <!-- Page-header end -->
                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <!-- Page-body start -->
                                    <div class="page-body"> 
                                        <?php $aux = false; ?>       
               
                                <?php foreach($info->result as $info): ?>
                                                                                                                                         
                                         
                                        <div class="card">
                                            <div class="card-header">
                                            <h3><?php echo $info->tipoLicitacao->tipoLicitacao." nº ".$info->numero; ?></h3><br/>                                
                                            
                                            <div class="d-flex flex-row bd-highlight mb-3">
                                            <div class="col-sm-auto style-font">Local:
                                            <strong class="ng-star-inserted"><?php echo $info->unidadeCompradora->cidade."/".$info->unidadeCompradora->uf; ?> </strong>
                                            </div>

                                            <div class="col-sm-auto style-font">Órgão:
                                            <strong class="ng-star-inserted"><?php echo $info->razaoSocial; ?></strong>
                                            </div> 

                                        
                                            <div class="col-sm style-font">Unidade compradora:
                                            <strong class="ng-star-inserted"><?php echo $info->identificacao." - ".$info->nomeUnidade; ?></strong>
                                            </div>
                                        </div>
                                        
                                        
                                            <div class="d-flex flex-row bd-highlight mb-3">
                                            <div class="col-sm-auto style-font">Modalidade da contratação:
                                            <strong class="ng-star-inserted"><?php echo $info->tipoLicitacao->modalidadeLicitacao; ?></strong>
                                            </div>

                                            <div class="col-sm-auto style-font">Identificação:
                                            <strong class="ng-star-inserted"><?php echo $info->identificacao; ?></strong>
                                            </div>

                                            <div class="col-sm-auto style-font">Tipo Licitação:
                                            <strong class="ng-star-inserted"><?php echo $info->tipoLicitacao->tipoLicitacao; ?></strong> 
                                            </div>

                                            <div class="col-sm-auto style-font">Tipo de Julgamento:
                                            <strong class="ng-star-inserted"><?php echo $info->tipoLicitacao->tipoJulgamento; ?></strong> 
                                            </div>
                                            </div>

                                            <div class="d-flex flex-row bd-highlight mb-3">
                                            <div class="col-sm-auto style-font">Modo de Disputa:
                                            <strong class="ng-star-inserted"><?php echo $info->tipoLicitacao->tipoRealizacao; ?></strong>
                                            </div>
                                            <div class="col-sm-auto style-font">Código da Licitação:
                                        <strong class="ng-star-inserted"><?php echo $info->codigoLicitacao; ?></strong>
                                            </div>
                                            <div class="col-sm-auto style-font">Código Unidade Compradora:
                                            <strong class="ng-star-inserted"><?php echo $info->unidadeCompradora->codigoUnidadeCompradora; ?></strong>
                                            </div>
                                            </div>
                                        

                                            <div class="d-flex flex-row bd-highlight mb-3">
                                            <div class="col-sm-auto style-font">Data de início de recebimento de propostas:
                                                <?php 
                                                $a = new DateTime($info->dataHoraInicioPropostas);
                                                $dataHoraInicioPropostas = $a->format('d/m/Y H:i');
                                                ?>
                                            <strong class="ng-star-inserted"><?php echo $dataHoraInicioPropostas; ?></strong>
                                            </div>
                                            <div class="col-sm-auto style-font">Limite para Recebimento das Propostas:
                                                <?php 
                                                $b = new DateTime($info->dataHoraFinalPropostas);
                                                $dataHoraFinalPropostas = $b->format('d/m/Y H:i');
                                                ?>
                                            <strong class="ng-star-inserted"><?php echo $dataHoraFinalPropostas == null ? 'Sem data' :  $dataHoraFinalPropostas; ?></strong>
                                            </div>
                                            </div>
                                        
                                            
                                            <div class="d-flex flex-row bd-highlight mb-3">
                                            <div class="col-sm-auto style-font">Data do inicio do lance:
                                                <?php 
                                                $c = new DateTime($info->dataHoraInicioLances);
                                                $dataHoraInicioLances = $c->format('d/m/Y H:i');
                                                ?>
                                            <strong class="ng-star-inserted"><?php echo  $dataHoraInicioLances == null ? 'Sem data' : $dataHoraInicioLances; ?></strong>
                                            </div>

                                            <div class="col-sm-auto style-font">Data fim do Lance:
                                                <?php 
                                                // $d = new DateTime($info->dataHoraFinalLances);
                                                // $FinalLances = $d->format('d/m/Y');
                                                ?>
                                            <strong class="ng-star-inserted"><?php echo $info->dataHoraFinalLances == '' ? 'Sem data' : $info->dataHoraFinalLances; ?></strong>
                                            </div>
                                            </div>
                                            <div class="d-flex flex-row bd-highlight mb-3">
                                            <div class="col-sm-auto style-font">Data da Publicação:
                                                <?php 
                                                $e = new DateTime($info->dataHoraPublicacao);
                                                $dataHoraPublicacao = $e->format('d/m/Y H:i');
                                                ?>
                                            <strong class="ng-star-inserted"><?php echo  $dataHoraPublicacao == null ? 'Sem data' : $dataHoraPublicacao; ?></strong>
                                            </div>
                                            <div class="col-sm-auto style-font">Limite para Recebimento das Propostas:
                                                <?php 
                                                $f = new DateTime($info->dataHoraFinalPropostas);
                                                $dataHoraFinalPropostas = $f->format('d/m/Y H:i');
                                                ?>

                                            <strong class="ng-star-inserted"><?php echo $dataHoraFinalPropostas; ?></strong>
                                            </div>
                                            </div>

                                            <div class="d-flex flex-row bd-highlight mb-3">
                                            <div class="col-sm-auto style-font">Link de origem:
                                                <?php if($info->urlReferencia == null):  ?>
                                            <strong class="ng-star-inserted">Sem informação</strong>
                                                <?php endif; ?> 
                                                <?php if($info->urlReferencia != null):  ?>
                                                    <strong class="ng-star-inserted"><a href="<?php echo 'https://www.portaldecompraspublicas.com.br/processos'.$info->urlReferencia;  ?>" target="_blank"><?php echo 'https://www.portaldecompraspublicas.com.br/processos'.$info->urlReferencia;  ?></a></strong>
                                                <?php endif; ?>
                                            </div>

                                        </div>
                                        

                                            <div class="d-flex flex-row bd-highlight mb-3">
                                            <div class="col-sm-auto style-font">Descrição:
                                            <strong class="ng-star-inserted"><?php echo $info->statusProcessoPublico->descricao;  ?></strong>
                                            </div>
                                            </div>

                                            <div class="d-flex flex-row bd-highlight mb-3">
                                            <div class="d-flex p-2 bd-highlight style-font">Objeto:
                                            <strong class="ng-star-inserted ">&nbsp; <?php echo $info->resumo; ?></strong>
                                            </div>

                                            
                                        </div>
                                        <br/>   

                                        <div class="card-header-right">
                                                    <ul class="list-unstyled card-option">
                                                        <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                                        <li><i class="fa fa-window-maximize full-card"></i></li>
                                                        <li><i class="fa fa-minus minimize-card"></i></li>
                                                        <li><i class="fa fa-refresh reload-card"></i></li>
                                                        <li><i class="fa fa-trash close-card"></i></li>
                                                    </ul>
                                                </div>
                                        </div>
                                            <div class="card-block table-border-style">
                                            <h3><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Documentos</h3>
                                                <div class="table-responsive">
                                                    <?php
                                                    $doc = array();
                                                    $url_doc = 'https://compras.api.portaldecompraspublicas.com.br/v2/licitacao/'.$info->codigoLicitacao.'/documentos/processo';
                                                    $doc = json_decode(file_get_contents($url_doc));
                                                    ?>
                                                <table class="table table-bordered">
                                                    <thead class="table-secondary">
                                                        <tr class="style-tabela-doc">
                                                        <th scope="col">Documento</th>
                                                        <th scope="col">Tipo</th>
                                                        <th scope="col">Data/Hora</th>
                                                        <th scope="col">Download</th>
                                                        </tr>
                                                    </thead>
                                                    <?php foreach($doc as $d): ?>
                                                    <tbody>
                                                        <tr class="style-tabela-doc">
                                                        <th><?php echo $d->nome; ?></th>
                                                        <td><?php echo $d->tipo; ?></td>
                                                        <td><?php echo $d->dataHora; ?></td>
                                                        <td><a href="<?php echo $d->url; ?>"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a></td>
                                                        </tr>
                                                    </tbody>
                                                    <?php endforeach; ?>
                                                    </table>
                                                  

                                                    <br><br>

                                                <?php
                                                $table = array();
                                                $urlTable = 'https://compras.api.portaldecompraspublicas.com.br/v2/licitacao/'.$info->codigoLicitacao.'/itens?filtro=&pagina=1';
                                                $table = json_decode(file_get_contents($urlTable));

                                                ?>
                                                <h3><i class="fa fa-bars" aria-hidden="true"></i> Itens</h3>  
                                                    <table class="table table-bordered">
                                                            <thead class="table-dark">
                                                                <tr class="style-tabela">
                                                                <th>Item</th>
                                                                <th>Descrição</th>
                                                                <th>Unidade</th>
                                                                <th>Quantidade</th>
                                                                <th>Melhor Lance</th>
                                                                <th>Valor Referência</th>
                                                                <th>Disputa</th>
                                                                <th>Situação</th>
                                                                </tr>
                                                            </thead>
                                            
                                                                   
                                                           <?php if($table->itens->result != null ): ?> 
                                                            <?php foreach($table->itens->result as $f): ?>
                                                            <tbody>
                                                                <tr>                                                                
                                                                <th class="style-tabela" scope="row"><?php echo $f->codigo; ?></th>
                                                                <td><?php echo  $f->descricao; ?></td>
                                                                <td class="style-tabela"><?php echo $f->unidade; ?></td>                                                
                                                                <td class="style-tabela"><?php echo $f->quantidade; ?></td>
                                                                <td class="style-tabela"><?php echo $f->melhorLance == null ? '-' : $f->melhorLance; ?></td>                                                              
                                                                <td class="style-tabela"><?php echo "R$ ".$valor_total = number_format($f->valorReferencia, 2, ',', '.'); ?></td>
                                                                <td class="style-tabela"><?php echo $f->participacao->descricao; ?></td>
                                                                <td class="style-tabela"><?php echo $f->situacao->descricao; ?></td>                                                                 
                                                                </tr>
                                                            </tbody>
                                                            <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        
                                                            <?php if($table->lotes->result != null): ?>
                                                            <?php foreach($table->lotes->result as $f): ?>
                                                                <?php foreach($f->itens as $k): ?>

                                                            <tbody>
                                                                <tr>                                                                
                                                                <th class="style-tabela" scope="row"><?php echo $k->codigo; ?></th>
                                                                <td><?php echo  $k->descricao; ?></td>
                                                                <td class="style-tabela"><?php echo $k->unidade; ?></td>                                                
                                                                <td class="style-tabela"><?php echo $k->quantidade; ?></td>
                                                                <td class="style-tabela"><?php echo $k->melhorLance == null ? '-' : $k->melhorLance; ?></td>                                                              
                                                                <td class="style-tabela"><?php echo "R$ ".$valor_total = number_format($k->valorReferencia, 2, ',', '.'); ?></td>
                                                                <td class="style-tabela"><?php echo $k->participacao->descricao; ?></td>
                                                                <td class="style-tabela"><?php echo $k->situacao->descricao; ?></td>                                                                 
                                                                </tr>
                                                            </tbody>                                                          
                                                            <?php endforeach; ?>
                                                            <?php endforeach; ?>
                                                            <?php endif; ?>
                                                           
                                                            <?php $aux = true; ?>
                                                           
                                                        </table> 


                                                       

                                                 
                                                    </div>
                                                </div>
                                            </div>

                                   
                                        

                                        <?php endforeach; ?>
                                        <?php if($aux == false): ?>
                                            <div class="alert alert-dark" role="alert"><h5>Propostas encerradas hoje!</h5></div>
                                            <?php endif; ?>
                                        
                                        <!-- Background Utilities table end -->
                                    </div>
                                    <!-- Page-body end -->
                                </div>
                            </div>
                            <!-- Main-body end -->

                            <div id="styleSelector">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    



    