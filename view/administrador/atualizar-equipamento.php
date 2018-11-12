<?php
include_once '../../config/config.php';
include_once '../../config/Conexao.class.php';
include_once '../../model/Usuario.class.php';

$usu_inst = new Usuario;

$usu_inst->redirecNaoAdm();

$usu_logado = $usu_inst->getUsuarioLogado();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <!--[if IE]>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <![endif]-->
  <title>Sistema de Reservas e Solicitações - DTI</title>
  <!-- BOOTSTRAP CORE STYLE  -->
  <link href="<?php echo URL_BASE ?>/css/bootstrap.css" rel="stylesheet" />
  <!-- FONT AWESOME ICONS  -->
  <link href="<?php echo URL_BASE ?>/css/font-awesome.css" rel="stylesheet" />
  <!-- CUSTOM STYLE  -->
  <link href="<?php echo URL_BASE ?>/css/style.css" rel="stylesheet" />
  <!-- HTML5 Shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
  <link rel="icon" type="imagem/png" href="<?php echo URL_BASE; ?>/assets/img/dti.png" />
</head>
<body>
  <?php include_once '../menu-topo.php' ?>
  <!-- MENU SECTION END-->
  <div class="content-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1 class="page-head-line">Gerenciador de equipamentos</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              Cadastrar novo equipamento
            </div>
            <div class="panel-body">
              <form>
                <div class="form-group">
                  <label>Nome do equipamento: </label>
                  <input type="text" name="nome" class="form-control" placeholder="Informe o nome.." />
                </div>
                <div class="form-group">
                  <label>Tipo de equipamento: </label>
                  <select name="tipo" class="form-control">
                    <option value="0">Cabo VGA</option>
                    <option value="0">Cabo VGA</option>
                    <option value="0">Cabo VGA</option>
                    <option value="0">Cabo VGA</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Descrição do equipamento: </label>
                  <textarea name="descricao" class="form-control" rows="3" placeholder="Informe a descrição do equipamento..."></textarea>
                </div>
                <button type="submit" class="btn btn-success">Salvar</button>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              Atualizar equipamentos
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover">
                      <thead>
                      <tr>
                          <th>Equipamento</th>
                          <th class="text-center">Disponível</th>
                          <th class="text-center">Ação</th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr>
                          <td>Caixa de som</td>
                          <td class="text-center"><label class="label label-success">Disponível</label>
                          </td>
                          <td class="text-center"><a href="#" class="btn btn-sm btn-default">Atualizar</a>
                          </td>
                      </tr>
                      <tr>
                          <td>Leitor de DVDs</td>
                          <td class="text-center"><label class="label label-success">Disponível</label>
                          </td>
                          <td class="text-center"><a href="#" class="btn btn-sm btn-default">Atualizar</a>
                          </td>
                      </tr>
                      <tr>
                          <td>Extensão</td>
                          <td class="text-center"><label class="label label-success">Disponível</label>
                          </td>
                          <td class="text-center"><a href="#" class="btn btn-sm btn-default">Atualizar</a>
                          </td>
                      </tr>
                      <tr>
                          <td>Cabo USB</td>
                          <td class="text-center"><label class="label label-danger">Indisponível</label>
                          </td>
                          <td class="text-center"><a href="#" class="btn btn-sm btn-default">Atualizar</a>
                          </td>
                      </tr>
                      <tr>
                          <td>Cabo HDMI</td>
                          <td class="text-center"><label class="label label-success">Disponível</label>
                          </td>
                          <td class="text-center"><a href="#" class="btn btn-sm btn-default">Atualizar</a>
                          </td>
                      </tr>
                      <tr>
                          <td>Cabo VGA</td>
                          <td class="text-center"><label class="label label-success">Disponível</label>
                          </td>
                          <td class="text-center"><a href="#" class="btn btn-sm btn-default">Atualizar</a>
                          </td>
                      </tr>
                      </tbody>
                  </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- CONTENT-WRAPPER SECTION END-->
   <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            &copy; 2018 Núcleo de Extensão em Análise e Desenvolvimento de Sistemas | <a href="http://www.nexasfvs.com.br/" target="_blank">NEXAS</a>
          </div>
        </div>
      </div>
    </footer>
  <!-- FOOTER SECTION END-->
  <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
  <!-- CORE JQUERY SCRIPTS -->
  <script src="<?php echo URL_BASE ?>/js/jquery-1.12.3.js"></script>
  <!-- BOOTSTRAP SCRIPTS  -->
  <script src="<?php echo URL_BASE ?>/js/bootstrap.js"></script>
</body>
</html>
