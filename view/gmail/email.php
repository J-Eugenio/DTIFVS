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
  <title>Sistema de E-mail - DTI</title>
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
          <h1 class="page-head-line">Sistema de E-mails</h1>
        </div>
      </div>
      <div class="row">
	  <div class="col-md-3">
	  </div>
        <div class="col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
              Sistema de E-mails
            </div>
            <div class="panel-body">
              <form method="post" action="processa_email.php">
				        <div class="form-group">
                  <label>Para: </label>
                  <input type="text" name="para" class="form-control" placeholder="Informe o E-mail..."/>
                  <label>Assunto: </label>
                  <input type="text" name="assunto" class="form-control" placeholder="Informe a Assunto.."/>
                   <label>Mensagem: </label>
                  <textarea rows="4" cols="50" name="mensagem" class="form-control" placeholder="Digite sua Mensagem..."></textarea>
                </div>
                <button type="submit" class="btn btn-success"><span class="fa fa-check"></span> Enviar</button>
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
            &copy; 2018 Núcleo de Extensão em Análise e Desenvolvimento de Sistemas | <a href="http://www.nexasfvs.com.br/" target="">NEXAS</a>
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

  var msgFormUsuario = $('#form-suporte-equipamento').msgRapida();
  var formUsuario = $("#form-suporte-equipamento");

  formUsuario.validate({
    rules: {
	  titulo: {required: true},
    },
    messages:{
	  titulo: { required: 'É necessário informar um Titulo.'},
    },
    errorClass: "alert alert-danger",
    errorElement: "div",

    submitHandler : function(form){
      var dados = $(form).serialize();

      $.ajax({
        type: "POST",
        url: "<?php echo URL_BASE;?>/control/bug-controle.php?acao=cadastrar-bug&ajax=true",
        data: dados,
        dataType: 'json',
        success: function(res){
          msgFormUsuario.abrir(res.result, res.mensagem);        
        }
      });

      return false;
    }
  });

  </script>
</body>
</html>
