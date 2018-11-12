<?php
include_once '../../config/config.php';
include_once '../../config/Conexao.class.php';
include_once '../../model/Usuario.class.php';

//$usuario_inst = new Usuario;

//$usuario_inst->redirecLogado();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=0.5, maximum-scale=0.5" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link rel="icon" type="imagem/png" href="<?php echo URL_BASE; ?>/assets/img/dti.png" />
  <!--[if IE]>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <![endif]-->
  <title>Sistema de Reservas e Solicitações - DTI</title>
  <!-- BOOTSTRAP CORE STYLE  -->
  <link href="<?php echo URL_BASE; ?>/css/bootstrap.css" rel="stylesheet" />
  <!-- FONT AWESOME ICONS  -->
  <link href="<?php echo URL_BASE; ?>/css/font-awesome.css" rel="stylesheet" />
  <!-- CUSTOM STYLE  -->
  <link href="<?php echo URL_BASE; ?>/css/style.css" rel="stylesheet" />
  <!-- HTML5 Shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
  <header>

    <div class="container">
     
	 
        <div class="col-md-12">
		
          <strong>Email: </strong>dti@fvs.edu.br
          &nbsp;&nbsp;
          <strong>Telefone: </strong> 3561-2760
        </div>

    
    </div>
  </header>
  <!-- HEADER END-->
  <div class="navbar navbar-inverse set-radius-zero">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
<a class="navbar-brand" href="index.php">
          <img src="<?php echo URL_BASE; ?>/img/logo.png" />
        </a>

      </div>

      <div class="left-div">
       <div align="right"> <i class="fa fa-user-plus login-icon float-right" style ="opacity: 0.0; }"></i></div>
      </div>
    </div>
  </div>
  <!-- LOGO HEADER END-->

  <!-- MENU SECTION END-->
  <div class="content-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-md-10">
          <h4 class="page-head-line">Formulário de login </h4>

        </div>

      </div>
      <div class="row">
        <div class="col-md-6">
          <h4>Preencha seus dados:</h4>
          <br />
          <form id="formLogin" action="<?php echo URL_BASE; ?>\control\usuario-controle.php?acao=login" method="post">
            <label>Informe o seu Email ou login : </label>
            <input type="text" class="form-control" name="email"/>
            <hr>
            <label>Informe a sua senha :  </label>
            <input type="password" class="form-control" name="cpf"/>
            <hr />
            <button class="btn btn-info"><span class="glyphicon glyphicon-user"></span> &nbsp;Realizar login </button>&nbsp;
          </form>
        </div>
        <div class="col-md-6">
          <div class="alert alert-success">
            <strong> Instruções de Uso:</strong>
            <ul>
              <li>
                Professor utilize o sistema para realizar reservas somente para a real data de utilização do material. 
              </li>
			  <li>
                As reservas só podem ser feitas para até 7 dias a contar da data atual.
              </li>
			  <li>
                A devolução dos equipamentos deve ser realizada preterivelmente no mesmo dia.
              </li
              <li>
                Caso ainda não possua credenciais de acesso, solicite o registro ao Departamento de Tecnologia (DTI).
              </li>
              <li>
                Não repasse seus dados de acesso a terceiros.
              </li>
            </ul>

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
  <script src="<?php echo URL_BASE; ?>/js/jquery-1.12.3.js"></script>
  <script src="<?php echo URL_BASE; ?>/js/jquery.validate.min.js"></script>
  <script src="<?php echo URL_BASE; ?>/js/jquery.mask.js"></script>
  <script src="<?php echo URL_BASE; ?>/js/script.js"></script>
  <!-- BOOTSTRAP SCRIPTS  -->
  <script src="<?php echo URL_BASE; ?>/js/bootstrap.js"></script>
  <script type="text/javascript">

   var msgFormLogin = $('#formLogin').msgRapida();

  jQuery.validator.setDefaults({
    debug: true,
    success: "valid"
  });

  $("#formLogin").validate({
    rules: {
      email: {required: true},
      cpf: {required: true}
    },
    messages:{
      email: { required: 'O campo Login é obrigatório.'},
      cpf: {required: 'O campo Senha é obrigatório.'}
    },
    errorClass: "alert alert-danger",
    errorElement: "div",

    submitHandler : function(form){
      var dados = $(form).serialize();

      $.ajax({
        type: "POST",
        url: "<?php echo URL_BASE;?>/control/usuario-controle.php?acao=login&ajax=true",
        data: dados,
        dataType: 'json',
        success: function(data){

          if(data.result == 2){
			window.location = '<?php echo URL_BASE; ?>/view/usuario/alterar-senha.php';
          }
          else if(data.result == 1){
            window.location = '<?php echo URL_BASE; ?>/view/usuario/pagina-usuario.php';
          }else{
            msgFormLogin.abrir(data.result, data.mensagem);
          }
        }
      });

      return false;
    }
  });
  </script>
</body>
</html>
