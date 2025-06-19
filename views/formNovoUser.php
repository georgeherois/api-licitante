                        <!-- Conteúdo principal -->
                        <div class="container-fluid">
                          <h3>Cadastrar Novo Usuário</h3>
                          <br />
                          <!-- Aqui mostra a mensagem de erro ou de cadastrado com sucesso  -->
                          <?php echo (!empty($menssagem)) ? $menssagem : ""; ?>

                          <form action="<?php echo BASE_URL; ?>home/adicionarNovoUsuario" method="post">
                            <div class="mb-3">
                              <label for="exampleFormControlInput1" class="form-label">Nome</label>
                              <input type="text" class="form-control" name="nome" id="exampleFormControlInput1" placeholder="Digite seu nome" style="width:511px;" required>
                            </div>

                            <div class="mb-3">
                              <label for="exampleFormControlInput1" class="form-label">Nome do Usuário</label>
                              <input type="texte" class="form-control" name="usuario" id="exampleFormControlInput1" placeholder="Exemplo: Paulo.Santos" style="width:511px;" required>
                            </div>

                            <div class="mb-3">
                              <label for="exampleFormControlInput1" class="form-label">E-mail</label>
                              <input type="email" class="form-control" name="email" id="exampleFormControlInput1" placeholder="exemplo@gmail.com" style="width:511px;" required>
                            </div>

                            <div class="mb-3">
                              <label for="exampleFormControlInput1" class="form-label">Senha</label>
                              <input type="password" class="form-control" name="password" id="exampleFormControlInput1" placeholder="" style="width:511px;" required>
                            </div>
                            <br />
                            <button type="submit" class="btn btn-primary mb-3" style="width:130px;">Cadastrar</button>

                          </form>

                        </div>