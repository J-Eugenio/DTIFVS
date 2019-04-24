<?php
include_once '../../config/config.php';
include_once '../../config/Conexao.class.php';
include_once '../../model/Usuario.class.php';

$usu_inst = new Usuario;

$usu_inst->redirecNaoAdm();

$usu_logado = $usu_inst->getUsuarioLogado();

if(isset($_GET['id'])){
  $usuario_selec = $usu_inst->getUsuarioPorId($_GET['id']);

}
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
  <link rel="icon" type="imagem/png" href="<?php echo URL_BASE; ?>/assets/img/dti.png" />
  <!-- HTML5 Shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
  <?php include_once '../menu-topo.php' ?>
  <!-- MENU SECTION END-->

  <div class="content-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1 class="page-head-line">Atualizar Usuários</h1>
        </div>
      </div>
      <div class="row">
	  <div class="col-md-3">
	  </div>
        <div class="col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
              Atualizar usuário
            </div>
            <div class="panel-body">
              <form id="form-cadastro-usuario">
                <div class="form-group">
				 <input type="hidden" name="id"
                  value="<?php echo isset($usuario_selec) ? $usuario_selec['id'] : '' ?>">
                  <label>Login: </label>
                  <input type="text" name="login" class="form-control" placeholder="Não altere..." 
				  value = "<?php echo isset($usuario_selec) ? $usuario_selec['login'] : '' ?>" />
                </div>
                <div class="form-group">
                  <label>Senha: </label>
                  <input type="password"  name="senha" class="form-control" placeholder="<?php echo isset($usuario_selec) ? $usuario_selec['senha'] : '' ?>"
				  value = "<?php echo isset($usuario_selec) ? $usuario_selec['senha'] : '' ?>"/>
                </div>
				<div class="form-group">
                  <label>Nome: </label>
                  <input type="text" name="nome" class="form-control" placeholder="Informe um nome.."
				  value = "<?php echo isset($usuario_selec) ? $usuario_selec['nome'] : '' ?>"/>
                </div>
                <div class="form-group">
                  <label>Email: </label>
                     <input type="email" name="email" class="form-control" placeholder="Informe um email.."
					 value = "<?php echo isset($usuario_selec) ? $usuario_selec['email'] : '' ?>"/>
                </div>
				<div class="form-group">
				<label>CPF: </label>
					 <input type="text" name="cpf" class="form-control" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" placeholder="Digite o CPF no formato nnn.nnn.nnn-nn"
					 value = "<?php echo isset($usuario_selec) ? $usuario_selec['cpf'] : '' ?>"/>
				</div>
                <button type="submit" class="btn btn-success"><span class="fa fa-check"></span> Salvar</button>
                <button type="reset" class="btn btn-warning"><span class="fa fa-close"></span> Limpar</button>
              </form>
            </div>
          </div>
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
  <!-- FOOTER SECTION END-->
  <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
  <!-- CORE JQUERY SCRIPTS -->
  <script src="<?php echo URL_BASE ?>/js/jquery-1.12.3.js"></script>
  <script src="<?php echo URL_BASE ?>/js/script.js"></script>
  <!-- BOOTSTRAP SCRIPTS  -->
  <script src="<?php echo URL_BASE; ?>/js/jquery.validate.min.js"></script>
  <script src="<?php echo URL_BASE ?>/js/bootstrap.js"></script>

  <script type="text/javascript">

  jQuery.validator.setDefaults({
    debug: true,
    success: "valid"
  });

  var msgFormUsuario = $('#form-cadastro-usuario').msgRapida();
  var formUsuario = $("#form-cadastro-usuario");

  formUsuario.validate({
    rules: {
      login: {required: true},
      senha: {required: true},
	  nome: {required: true},
	  cpf: {required: true},
      email: {required: true},
	  nivel: {required: true}
    },
    messages:{
      login: { required: 'É necessário informar um login.'},
      senha: { required: 'É necessário informar uma senha.'},
	  nome: { required: 'É necessário informar um nome.'},
	  cpf: { required: 'É necessário informar um cpf.'},
      email: { required: 'É necessário informar um email.'},
	  nivel: { required: 'É necessário informar um nível de usuário.'}
    },
    errorClass: "alert alert-danger",
    errorElement: "div",

    submitHandler : function(form){
      var dados = $(form).serialize();

      $.ajax({
        type: "POST",
        url: "<?php echo URL_BASE;?>/control/usuario-controle.php?acao=atualizar-usuario&ajax=true",
        data: dados,
        dataType: 'json',
        success: function(res){

          msgFormUsuario.abrir(res.result, res.mensagem);

          form.reset();
        }
      });

      return false;
    }
  });

  </script>
</body>
</html>
