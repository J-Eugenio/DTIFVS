<?php
include_once '../../config/config.php';
include_once '../../config/Conexao.class.php';
include_once '../../model/Usuario.class.php';

$usu_inst = new Usuario;

$usu_inst->redirecNaoAdm();

$usu_logado = $usu_inst->getUsuarioLogado();

$pagindice = isset($_GET['pagindice']) ? $_GET['pagindice'] : 1;

$lista_usuarios = $usu_inst->buscarUsuarios(empty($_GET['termo']) ? '' : $_GET['termo'], 10, $pagindice);

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <!--[if IE]>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <![endif]-->
  <title>Sistema de Reservas e Solicitações - DTI</title>
  <!-- BOOTSTRAP CORE STYLE  -->
  <link href="<?php echo URL_BASE ?>/css/bootstrap.css" rel="stylesheet" type="text/css"/>
  <link href="<?php echo URL_BASE ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

  <script src="<?php echo URL_BASE ?>/js/jquery-1.12.3.js"></script>

  <link href="<?php echo URL_BASE ?>/css/font-awesome.css" rel="stylesheet"/>

  <link href="<?php echo URL_BASE ?>/css/style.css" rel="stylesheet"/>

  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->

  <link rel="stylesheet" href="<?php echo URL_BASE ?>/css/jquery-ui.css">
  <link rel="icon" type="imagem/png" href="<?php echo URL_BASE; ?>/assets/img/dti.png" />
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
</head>
<body>
  <?php include_once '../menu-topo.php' ?>
  <div class="content-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h4 class="page-head-line">Buscar Usuários</h4>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-primary table-ajustes">
            <div class="panel-heading">
              <h3 class="panel-title">Tabela de usuarios - Exibindo página
              <strong><?php echo $lista_usuarios['pagina_atual'] ?></strong>
               de
              <strong><?php echo $lista_usuarios['limites_pagina'] ?></strong>
              - <strong><?php echo $lista_usuarios['qtd_resultados'] ?></strong> Resultados
            </h3>
            </div>
            <div class="panel-body">
              <div class="col-md-8 form-group">
                <form action="" method="get" id="form-busca">
                  <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                    <div class="input-group-addon"><span class="fa fa-search"></span></div>
                    <input type="hidden" name="pagindice" value="1">
                    <input type="text" class="form-control" name="termo"
                    placeholder="Informe uma palavra chave para a busca..."
                    value="<?php echo isset($_GET['termo']) ? $_GET['termo'] : '' ?>">
                  </div>
                </form>
              </div>
              <div class="col-md-12">
			  <center>
			  <a href="<?php echo URL_BASE.'/view/administrador/cadastro-usuario.php'; ?>">
			  <button class ="btn btn-warning">
          <span class="fa fa-user"></span> Cadastrar</button>
				</a>
				</center>
				<br/>
                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="50%">
                  <thead>
                    <tr>
                      <th>Nome do Usuário</th>
                      <th>Login</th>
					  <th>Email</th>
                      <th class="text-center">Ações</th>
                    </tr>
                  </thead>
                  <tbody style="overflow: auto; height: 300px">
                    <?php foreach ($lista_usuarios['resultados'] as $usuario_row): ?>
                      <tr>
                        <td><?php echo $usuario_row['nome']; ?></td>
                        <td><?php echo $usuario_row['login']; ?></td>
						<td><?php echo $usuario_row['email']; ?></td>
                        <td class="text-center">
                          <a href="<?php echo $usuario_row['id']; ?>"
                            class="btn btn-sm btn-danger excluir-usuario">
                            <span class="fa fa-trash"></span> Excluir</a>
                          <a href="<?php echo URL_BASE.'/view/administrador/alterar-usuario.php?id='.
                          $usuario_row['id']; ?>"
                            class="btn btn-sm btn-primary">
                            <span class="fa fa-cogs"></span> Atualizar</a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="panel-footer">
              <ul class="pagination" style="margin: 0;">
                <li class="paginate_button previous <?php echo $lista_usuarios['primeira_pag'] ? 'disabled' : '' ?>"
                  id="example_previous">
                  <a href="" aria-controls="example" data-dt-idx="0" tabindex="0">&lt;</a>
                </li>
                <li class="paginate_button active">
                  <a href="#" aria-controls="example" data-dt-idx="1" tabindex="0"><?php echo $pagindice ?></a>
                </li>
                <li class="paginate_button next <?php echo $lista_usuarios['ultima_pag'] ? 'disabled' : '' ?>"
                   id="example_next">
                  <a href="" aria-controls="example" data-dt-idx="2" tabindex="0">&gt;</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-conf-exc-usuario" tabindex="-1" role="dialog"
  aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmar exclusão do usuário</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>
          Tem certeza que deseja excluir este usuário?<br/>
        </p>
      </div>
      <div class="modal-footer">
        <button id="btn-confirma-exclusao-usuario" class="btn btn-success">
          <span class="fa fa-check"></span> Sim</button>
        <button class="btn btn-danger" data-dismiss="modal">
          <span class="fa fa-close"></span> Não</button>
      </div>
    </div>
  </div>
</div>

<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        &copy; 2018 Núcleo de Extensão em Análise e Desenvolvimento de Sistemas | <a href="http://www.nexasfvs.com.br/" target="_blank">NEXAS</a>
      </div>
    </div>
  </div>
</footer>
<script src="<?php echo URL_BASE ?>/js/bootstrap.js"></script>
<script type="text/javascript">
var formBusca = $('#form-busca');
var idSelecUsuario;

$('.excluir-usuario').click(function(evt){
  idSelecUsuario = $(this).attr('href');
  $('#modal-conf-exc-usuario').modal('show');
  evt.preventDefault();
});

$('#btn-confirma-exclusao-usuario').click(function(){
  window.location.href = '<?php echo URL_BASE ?>'+
  '/control/usuario-controle.php?acao=excluir-usuario&id='+idSelecUsuario;
});

$('#example_previous a').click(function(evt){
  formBusca.find('input[name=pagindice]').val(<?php echo $lista_usuarios['pagina_atual']-1 ?>);
  formBusca.submit();
  evt.preventDefault();
});

$('#example_next a').click(function(evt){
  formBusca.find('input[name=pagindice]').val(<?php echo $lista_usuarios['pagina_atual']+1 ?>);
  formBusca.submit();
  evt.preventDefault();
});
</script>
</body>
</html>
