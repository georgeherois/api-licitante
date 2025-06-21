<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Licitante Exxpert</title>
  <link rel="shortcut icon" type="image/jpg" href="<?php echo BASE_URL; ?>assets/img/favicon.ico" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

</head>

<style>
  a {
    text-decoration: none;
    color: blue;
    /* Cor padrão */
  }

  a:hover {
    color: red;
    /* Cor ao passar o rato */
  }

  a:active {
    color: green;
    /* Cor ao clicar */
  }

  a:visited {
    color: purple;
    /* Cor após clicar e visitar */
  }
</style>

<style>
  body {
    margin: 0;
    overflow: hidden;
    /* Evita rolagem no body */
  }

  /* Linha no topo */
  .top-line {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    /* Espessura da linha */
    background-color: #0d6efd;
    /* Cor da linha (azul Bootstrap) */
    z-index: 1050;
    /* Fica acima do menu e conteúdo */
  }

  .sidebar {
    position: fixed;
    top: 4px;
    bottom: 0;
    left: 0;
    width: 300px;
    /* Largura do menu */
    background-color: #f8f9fa;
    padding: 1rem;
  }

  .content {
    position: absolute;
    top: 4px;
    left: 285px;
    /* Mesma largura do menu */
    right: 0;
    bottom: 0;
    overflow-y: auto;
    /* Rola somente o conteúdo */
    padding: 2rem;
  }
</style>

<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Menu lateral -->
      <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar fixar sidebar">
        <div class="position-sticky">
          <div class="col-auto menu">
            <a href="<?php echo BASE_URL; ?>licitante"><img src="<?php echo BASE_URL; ?>assets/img/logo-card.png" class="rounded mx-auto d-block" alt="..."></a>
            <br /><br />
            <form action="<?php echo BASE_URL; ?>api/consultar" method="post">
              <div class="form-group">
                <label for="formGroupExampleInput">Fonte</label>
                <select name="fonte" id="selecionar" class="form-control fill">
                  <option value="4" <?php echo (isset($_POST['fonte']) && $_POST['fonte'] == '4') ? 'selected' : ''; ?>>Selecione...</option>
                  <option value="3" <?php echo (isset($_POST['fonte']) && $_POST['fonte'] == '3') ? 'selected' : ''; ?>>Compras Gov</option>
                  <option data-section="2" value="2" <?php echo (isset($_POST['fonte']) && $_POST['fonte'] == '2') ? 'selected' : ''; ?>>Compras Publicas</option>
                  <option value="1" <?php echo (isset($_POST['fonte']) && $_POST['fonte'] == '1') ? 'selected' : ''; ?>>Outros</option>
                </select>
                <br />
              </div>

              <div data-name="2" id="status-group-govA">
                <div class="form-group">
                  <label for="formGroupExampleInput2">Tipo</label>
                  <select name="tipo" class="form-control fill">
                    <option value="">Selecione...</option>
                    <option value="M" <?php echo (isset($_POST['tipo']) && $_POST['tipo'] == 'M') ? 'selected' : ''; ?>>Material</option>
                    <option value="S" <?php echo (isset($_POST['tipo']) && $_POST['tipo'] == 'S') ? 'selected' : ''; ?>>Serviço</option>
                  </select>
                </div>
              </div>
              <br />
              <div data-name="2" id="status-group-govB">
                <div class="form-group">
                  <label for="formGroupExampleInput2">Data Inicial</label>
                  <input type="date" name="dataInicial" class="form-control" value="<?php echo isset($_POST['dataInicial']) ? $_POST['dataInicial'] : ''; ?>">
                </div>
              </div>
              <br />
              <div class="form-group">
                <label for="formGroupExampleInput2">Data Final</label>
                <input type="date" name="dataFinal" class="form-control" value="<?php echo isset($_POST['dataFinal']) ? $_POST['dataFinal'] : ''; ?>">
              </div>
              <br />
              <div id="status-group" data-bs-dismiss="2">
                <div class="form-group">
                  <label for="formGroupExampleInput2">Status</label>
                  <select name="status" id="selecionar" class="form-control fill">
                    <option value="">Selecione...</option>
                    <option value="0" <?php echo (isset($_POST['status']) && $_POST['status'] == '0') ? 'selected' : ''; ?>>Status</option>
                    <option value="1" <?php echo (isset($_POST['status']) && $_POST['status'] == '1') ? 'selected' : ''; ?>>Recebendo Propostas</option>
                    <option value="2" <?php echo (isset($_POST['status']) && $_POST['status'] == '2') ? 'selected' : ''; ?>>Em Andamento</option>
                    <option value="25" <?php echo (isset($_POST['status']) && $_POST['status'] == '25') ? 'selected' : ''; ?>>Em Republicação</option>
                    <option value="3" <?php echo (isset($_POST['status']) && $_POST['status'] == '3') ? 'selected' : ''; ?>>Finalizado</option>
                    <option value="4" <?php echo (isset($_POST['status']) && $_POST['status'] == '4') ? 'selected' : ''; ?>>Iminência de deserto</option>
                  </select>
                </div>

                <br />


                <div class="form-group">
                  <label for="formGroupExampleInput2">Modo Compras Publicas</label>
                  <select name="modoModalidade" id="selecionar" class="form-control fill">
                    <option value="">Selecione...</option>
                    <option value="10" <?php echo (isset($_POST['modoModalidade']) && $_POST['modoModalidade'] == '10') ? 'selected' : ''; ?>>Chamada Pública Agricultura</option>
                    <option value="11" <?php echo (isset($_POST['modoModalidade']) && $_POST['modoModalidade'] == '11') ? 'selected' : ''; ?>>Chamamento Publica - 13.019</option>
                    <option value="19" <?php echo (isset($_POST['modoModalidade']) && $_POST['modoModalidade'] == '19') ? 'selected' : ''; ?>>Chamamento Publico - 9.637</option>
                    <option value="6" <?php echo (isset($_POST['modoModalidade']) && $_POST['modoModalidade'] == '6') ? 'selected' : ''; ?>>Concorrência</option>
                    <option value="14" <?php echo (isset($_POST['modoModalidade']) && $_POST['modoModalidade'] == '14') ? 'selected' : ''; ?>>Concurso</option>
                    <option value="4" <?php echo (isset($_POST['modoModalidade']) && $_POST['modoModalidade'] == '4') ? 'selected' : ''; ?>>Cotação</option>
                    <option value="8" <?php echo (isset($_POST['modoModalidade']) && $_POST['modoModalidade'] == '8') ? 'selected' : ''; ?>>Contratação Direta</option>
                    <option value="7" <?php echo (isset($_POST['modoModalidade']) && $_POST['modoModalidade'] == '7') ? 'selected' : ''; ?>>Credenciamento</option>
                    <option value="3" <?php echo (isset($_POST['modoModalidade']) && $_POST['modoModalidade'] == '3') ? 'selected' : ''; ?>>Dispensa</option>
                    <option value="92" <?php echo (isset($_POST['modoModalidade']) && $_POST['modoModalidade'] == '92') ? 'selected' : ''; ?>>Dispensa - Lei das Estatais 13.303</option>
                    <option value="13" <?php echo (isset($_POST['modoModalidade']) && $_POST['modoModalidade'] == '13') ? 'selected' : ''; ?>>Inexigibilidade</option>
                    <option value="16" <?php echo (isset($_POST['modoModalidade']) && $_POST['modoModalidade'] == '16') ? 'selected' : ''; ?>>IRP-Intenção para Regsitro de Preço</option>
                    <option value="5" <?php echo (isset($_POST['modoModalidade']) && $_POST['modoModalidade'] == '5') ? 'selected' : ''; ?>>Leilão</option>
                    <option value="12" <?php echo (isset($_POST['modoModalidade']) && $_POST['modoModalidade'] == '12') ? 'selected' : ''; ?>>Leilão Eletrônico</option>
                    <option value="15" <?php echo (isset($_POST['modoModalidade']) && $_POST['modoModalidade'] == '15') ? 'selected' : ''; ?>>Pré-Qualificação</option>
                    <option value="1" <?php echo (isset($_POST['modoModalidade']) && $_POST['modoModalidade'] == '1') ? 'selected' : ''; ?>>Pregão</option>
                    <option value="91" <?php echo (isset($_POST['modoModalidade']) && $_POST['modoModalidade'] == '91') ? 'selected' : ''; ?>>Pregão Lei Estatais 13.303</option>
                    <option value="2" <?php echo (isset($_POST['modoModalidade']) && $_POST['modoModalidade'] == '2') ? 'selected' : ''; ?>>Pregão para Registro de Preço</option>
                    <option value="18" <?php echo (isset($_POST['modoModalidade']) && $_POST['modoModalidade'] == '18') ? 'selected' : ''; ?>>RCE-Regime de Contratação Estatal</option>
                    <option value="9" <?php echo (isset($_POST['modoModalidade']) && $_POST['modoModalidade'] == '9') ? 'selected' : ''; ?>>Regime Diferenciado de Contratação</option>

                  </select>
                </div>
                <br />
              </div>


              <div data-name="2" id="status-group-govC">
                <div class="form-group">
                  <label for="formGroupExampleInput2">Modalidade</label>
                  <select name="modalidade" id="modalidade" class="form-control fill">
                    <option value="8" <?php echo (isset($_POST['modalidade']) && $_POST['modalidade'] == '8') ? 'selected' : 'selected'; ?>>Dispensa de Licitação</option>
                    <option value="1" <?php echo (isset($_POST['modalidade']) && $_POST['modalidade'] == '1') ? 'selected' : ''; ?>>Leilão - Eletrônico</option>
                    <option value="2" <?php echo (isset($_POST['modalidade']) && $_POST['modalidade'] == '2') ? 'selected' : ''; ?>>Diálogo Competitivo</option>
                    <option value="3" <?php echo (isset($_POST['modalidade']) && $_POST['modalidade'] == '3') ? 'selected' : ''; ?>>Concurso</option>
                    <option value="4" <?php echo (isset($_POST['modalidade']) && $_POST['modalidade'] == '4') ? 'selected' : ''; ?>>Concorrência - Eletrônica</option>
                    <option value="5" <?php echo (isset($_POST['modalidade']) && $_POST['modalidade'] == '5') ? 'selected' : ''; ?>>Concorrência - Presencial</option>
                    <option value="6" <?php echo (isset($_POST['modalidade']) && $_POST['modalidade'] == '6') ? 'selected' : ''; ?>>Pregão - Eletrônico</option>
                    <option value="7" <?php echo (isset($_POST['modalidade']) && $_POST['modalidade'] == '7') ? 'selected' : ''; ?>>Pregão - Presencial</option>
                    <option value="9" <?php echo (isset($_POST['modalidade']) && $_POST['modalidade'] == '9') ? 'selected' : ''; ?>>Inexigibilidade</option>
                    <option value="10" <?php echo (isset($_POST['modalidade']) && $_POST['modalidade'] == '10') ? 'selected' : ''; ?>>Manifestação de Interesse</option>
                    <option value="11" <?php echo (isset($_POST['modalidade']) && $_POST['modalidade'] == '11') ? 'selected' : ''; ?>>Pré-Qualificação</option>
                    <option value="12" <?php echo (isset($_POST['modalidade']) && $_POST['modalidade'] == '12') ? 'selected' : ''; ?>>Credenciamento</option>
                    <option value="13" <?php echo (isset($_POST['modalidade']) && $_POST['modalidade'] == '13') ? 'selected' : ''; ?>>Leilão - Presencial</option>
                  </select>
                </div>
              </div>
              <br />
              <div class="form-group">
                <button type="submit" class="btn btn-primary mb-3">Buscar Filtro</button>
              </div>
            </form>
            <br /><br />
            <a href="<?php echo BASE_URL; ?>authentication/sair"><img src="<?php echo BASE_URL; ?>assets/img/sair.png" class="" width="35" height="35" alt="..."> Sair do sistema</a>
          </div>
        </div>
        <br /><br /><br />
      </nav>

      <!-- Conteúdo principal -->
      <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 content">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <a href="<?php echo BASE_URL; ?>licitante"><img src="<?php echo BASE_URL; ?>assets/img/logo.png" class="" width="300" height="80" alt="..."></a>

        </div>
        Usuário Logado - <?php echo $_SESSION['cNome']; ?>
        <div>
          <!-- Linha no topo -->
          <div class="top-line"></div>

          <br>
          <?php $this->loadViewInTemplate($viewName, $viewData); ?>
        </div>
      </main>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="<?php echo BASE_URL; ?>assets/js/form.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var fonteSelect = document.querySelector('select[name="fonte"]');
      var statusGroup = document.getElementById('status-group');
      var statusGroupGovA = document.getElementById('status-group-govA');
      var statusGroupGovB = document.getElementById('status-group-govB');
      var statusGroupGovC = document.getElementById('status-group-govC');

      function toggleStatus() {
        if (fonteSelect.value === '3') {
          statusGroup.style.display = 'none';
        } else {
          statusGroup.style.display = 'block';

        }
        if (fonteSelect.value === '2') {
          statusGroupGovA.style.display = 'none';
          statusGroupGovB.style.display = 'none';
          statusGroupGovC.style.display = 'none'
        } else {
          statusGroupGovA.style.display = 'block';
          statusGroupGovB.style.display = 'block';
          statusGroupGovC.style.display = 'block';
        }

      }
      fonteSelect.addEventListener('change', toggleStatus);
      toggleStatus();
    });
  </script>
</body>

</html>