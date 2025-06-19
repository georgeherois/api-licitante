                        <!-- Conteúdo principal -->

                        <!-- Somente usuários adm podem ver os botões de cadastrar usuário -->
                        <?php if ($_SESSION['cModalidade'] === 1): ?>
                          <a class="btn btn-outline-primary" href="<?php BASE_URL; ?>home/novoUser" role="button">+ Criar Usuário</a>&nbsp;&nbsp; <a type="button" class="btn btn-outline-success" href="<?php BASE_URL; ?>home/getListUser">Listar Usuários</a>
                          <br /><br /><br /><br />

                        <?php endif; ?>

                        <?php
                        $cont = 1;
                        $data_atual = date('Ymd');
                        foreach ($item as $chave) {
                          foreach ($chave as $key) {

                            $dataEncPro = str_replace("-", "/", $key->data_fim_vigencia);
                            $dtEncerramentoProposta  = date('Ymd', strtotime($dataEncPro));
                            if ($key->modalidade_licitacao_id === "8" and $dtEncerramentoProposta === $data_atual) {
                              $cont++;
                            }
                          }
                        }


                        ?>
                        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
                          <div class="col">
                            <div class="card mb-4 rounded-3 shadow-sm">
                              <div class="card-header py-3">
                                <h4 class="my-0 fw-normal">Total de Dispensas</h4>
                              </div>
                              <div class="card-body">

                                <h1 class="card-title pricing-card-title"><?php echo number_format($total, 0, '', '.');; ?><small class="text-muted fw-light"></small></h1>
                                <ul class="list-unstyled mt-3 mb-4">
                                  <li>Ano <?php echo date('Y'); ?></li>
                                  <li>Modalidade - Dispensas</li>

                                </ul>
                                <div class="alert alert-success">Instrumento Convocatorio Codigo 2</div>
                              </div>
                            </div>
                          </div>

                          <div class="col">
                            <div class="card mb-4 rounded-3 shadow-sm border-primary">
                              <div class="card-header py-3 text-white bg-primary border-primary">
                                <h4 class="my-0 fw-normal">Total de dispensa Hoje</h4>
                              </div>
                              <div class="card-body">
                                <h1 class="card-title pricing-card-title"><?php echo (!empty($cont)) ? $cont : "0"; ?></small></h1>
                                <ul class="list-unstyled mt-3 mb-4">
                                  <li>Ano <?php echo date('Y'); ?></li>
                                  <li>Modalidade - Dispensas</li>
                                  <li></li>
                                </ul>
                                <div class="alert alert-success">Instrumento Convocatorio Codigo 2</div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <a class="btn btn-outline-danger" href="<?php BASE_URL; ?>licitante" role="button">Atualizar informações</a>

                        </div>