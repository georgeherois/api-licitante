<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Licitante Exxpert</title>
  <link rel="shortcut icon" type="image/jpg" href="<?php echo BASE_URL; ?>assets/images/favicon.ico"/>
  <link href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo BASE_URL; ?>assets/css/cheatsheet.rtl.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="row">
      <!-- Menu lateral -->
      <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar fixar">
        <div class="position-sticky">
          <div class="col-auto menu">
            <a href="<?php echo BASE_URL; ?>api"><img src="<?php echo BASE_URL; ?>assets/images/logo-card.png" class="rounded mx-auto d-block" alt="..."></a>
            <br /><br />
            <form action="<?php echo BASE_URL; ?>api/validarCampos" method="post">
              <div class="form-group">
                <label for="formGroupExampleInput">Fonte</label>
                <select name="fonte" id="selecionar" class="form-control fill">
                  <option value="">Selecione...</option>
                  <option value="3" <?php echo (isset($_POST['fonte']) && $_POST['fonte'] == '3') ? 'selected' : ''; ?>>Compras gov BR</option>
                  <option data-section="2" value="2" <?php echo (isset($_POST['fonte']) && $_POST['fonte'] == '2') ? 'selected' : ''; ?>>Compras Publicas</option>
                  <option value="1" <?php echo (isset($_POST['fonte']) && $_POST['fonte'] == '1') ? 'selected' : ''; ?>>Outros</option>
                </select>
              </div>

              <div data-name="2">
                <div class="form-group">
                  <label for="formGroupExampleInput2">Tipo</label>
                  <select name="tipo" class="form-control fill">
                    <option value="">Selecione...</option>
                    <option value="M" <?php echo (isset($_POST['tipo']) && $_POST['tipo'] == 'M') ? 'selected' : ''; ?>>Material</option>
                    <option value="S" <?php echo (isset($_POST['tipo']) && $_POST['tipo'] == 'S') ? 'selected' : ''; ?>>Serviço</option>
                  </select>
                </div>
              </div>

              <div data-name="2">
                <div class="form-group">
                  <label for="formGroupExampleInput2">Data Inicial</label>
                  <input type="date" name="dataInicial" class="form-control" value="<?php echo isset($_POST['dataInicial']) ? $_POST['dataInicial'] : ''; ?>">
                </div>
              </div>

              <div class="form-group">
                <label for="formGroupExampleInput2">Data Final</label>
                <input type="date" name="dataFinal" class="form-control" value="<?php echo isset($_POST['dataFinal']) ? $_POST['dataFinal'] : ''; ?>">
              </div>

              <div data-bs-dismiss="2">
                <div class="form-group">
                  <label for="formGroupExampleInput2">Status</label>
                  <select name="status" id="selecionar" class="form-control fill">
                    <option value="">Selecione...</option>
                    <option value="0" <?php echo (isset($_POST['status']) && $_POST['status'] == '0') ? 'selected' : ''; ?>>Status</option>
                    <option value="1" <?php echo (isset($_POST['status']) && $_POST['status'] == '1') ? 'selected' : ''; ?>>Recebendo Propostas</option>
                    <option value="2" <?php echo (isset($_POST['status']) && $_POST['status'] == '2') ? 'selected' : ''; ?>>Em Andamento</option>
                    <option value="3" <?php echo (isset($_POST['status']) && $_POST['status'] == '3') ? 'selected' : ''; ?>>Finalizado</option>
                    <option value="4" <?php echo (isset($_POST['status']) && $_POST['status'] == '4') ? 'selected' : ''; ?>>Iminência de deserto</option>
                  </select>
                </div>
              </div>

              <div data-name="2">
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
              <div class="form-group">
                <button type="submit" class="btn btn-primary mb-3">Buscar Filtro</button>
              </div>
            </form>
        
            <a href="<?php echo BASE_URL; ?>authentication/sair" ><img src="<?php echo BASE_URL; ?>assets/images/iconeSairSistema.png" class="" width="35" height="35"  alt="..."> Sair do sistema</a>
          </div>
        </div>
        <br /><br />
      </nav>
      
      <!-- Conteúdo principal -->
      <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <a href="<?php echo BASE_URL; ?>api" ><img src="<?php echo BASE_URL; ?>assets/images/logo.png" class="" width="300" height="80"  alt="..."></a>
            Seja bem-vindo - <?php echo $_SESSION['tb_nome']; ?>
        </div>
        <div>
          <h5 class="h5"><?php //require("totalDispensa.php"); ?></h5>
          <br>
          <?php $this->loadViewInTemplate($viewName, $viewData); ?>
        </div>
      </main>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="<?php echo BASE_URL; ?>assets/js/form.js"></script>
</body>
</html>