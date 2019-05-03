<?php
include_once '../../config/config.php';
include_once '../../config/Conexao.class.php';
include_once '../../model/Usuario.class.php';
include_once '../../model/Recurso.class.php';

$usu_inst = new Usuario;
$recurso_inst = new Recurso;

$usu_inst->redirecNaoAdm();

$usu_logado = $usu_inst->getUsuarioLogado();

if(isset($_GET['idrecurso'])){
  $recurso_selec = $recurso_inst->getRecursoPorID($_GET['idrecurso']);
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
          <h1 class="page-head-line">Gerenciador de equipamentos</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
              Cadastrar novo equipamento
            </div>
            <div class="panel-body">
              <form id="form-cadastro-equipamento">
                <div class="form-group">
                  <input type="hidden" name="id"
                  value="<?php echo isset($recurso_selec) ? $recurso_selec['id'] : '' ?>"/>
                  <label>Nome do equipamento: </label>
                  <input type="text" name="nome" class="form-control" placeholder="Informe o nome.."
                  value="<?php echo isset($recurso_selec) ? $recurso_selec['nome'] : '' ?>"/>
                </div>
                <div class="form-group">
                  <label>Tipo de equipamento: </label>
                  <input type="text"  name="tipo_nome" class="form-control"
                  value="<?php echo isset($recurso_selec) ? $recurso_selec['tipo']['nome'] : '' ?>" readonly>
                  <input type="hidden" name="tipo"
                  value="<?php echo isset($recurso_selec) ? $recurso_selec['tipo']['id'] : '' ?>">
                </div>
                <div class="form-group">
                  <label>Descrição do equipamento: </label>
                  <textarea name="descricao" class="form-control" rows="3" placeholder="Informe a descrição do equipamento..."><?php echo isset($recurso_selec) ? $recurso_selec['descricao'] : '' ?></textarea>
                </div>
                <div class="form-group">
                  <label>Qtd. equipamento: </label>
                  <input type="number" name="quantidade" class="form-control"
                  value="<?php echo isset($recurso_selec) ? $recurso_selec['quantidade'] : '1' ?>">
                </div>
				<div class="form-group">
				<label>Selecione o Campus:</label>
				<select class ="form-control" name = "campus" id ="campus">
					<option selected disabled hidden>Selecione um campus</option>
						<option value="Prédio Principal / Anexo"<?php if(isset ($recurso_selec) && ($recurso_selec['campus']) == 'Prédio Principal / Anexo'){ echo "selected";} ?>>Prédio Principal / Anexo</option>
						<option value="Clínica Escola" <?php if(isset ($recurso_selec) && ($recurso_selec['campus']) == 'Clínica Escola'){ echo "selected";} ?>>Clínica Escola</option>
				</select>
				</div>
                <button type="submit" class="btn btn-success"><span class="fa fa-check"></span> Salvar</button>
                <button type="reset" class="btn btn-warning"><span class="fa fa-close"></span> Limpar</button>
              </form>
            </div>
          </div>
        </div>
        <!-- Modal de formulário do tipo de equipamento -->
        <div class="modal fade" id="modal-tipo-equip" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Formulário do tipo de equipamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form id="form-tipo-equip" href="index.html" method="post">
                <div class="modal-body">
                  <div class="form-group">
                    <input type="hidden" name="id">
                    <label>Nome do tipo de equipamento: </label>
                    <input type="text" name="nome" class="form-control" placeholder="Informe o nome.." />
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-success">
                    <span class="fa fa-check"></span> Salvar</button>
                  <button type="reset" class="btn btn-warning" data-dismiss="modal">
                    <span class="fa fa-close"></span> Fechar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
              Tipos de equipamento
            </div>
            <div class="panel-body" style="max-height: 350px; overflow: auto;">
              <div class="table-responsive">
                <table class="table table-striped table-bordered tb-tipos-equip">
                  <thead>
                    <tr>
                      <th>Nome</th>
                      <th class="text-center" style="width: 200px;">Ação</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
            </div>
            <div class="panel-footer">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-tipo-equip">
                <span class="fa fa-plus"></span> Cadastrar novo tipo</button>
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

  var msgFormTipoEquip = $('#form-tipo-equip .modal-body').msgRapida();
  var msgFormEquip = $('#form-cadastro-equipamento').msgRapida();
  var formTipoEquip = $("#form-tipo-equip");
  var formEquip = $("#form-cadastro-equipamento");
  var modalTipoEquip = $("#modal-tipo-equip");

  function atualizaTabelaTiposEquip(){
    var tbTiposEq = $('.tb-tipos-equip tbody');
    tbTiposEq.html('');

    $.ajax({
      type: "POST",
      url: "<?php echo URL_BASE;?>/control/equipamento-controle.php?acao=busca-tipo-equip&ajax=true",
      dataType: 'json',
      success: function(res){

        if(!res[0]){
          var trne = $('<tr></tr>');
          trne.text('Nenhum resultado encontrado.');
          tbTiposEq.append(trne);
        }

        for (var prop in res) {
          var valor = res[prop];
          var tr = $('<tr></tr>');
          tr.attr('id-tipo-equip', valor.id);

          var td1 = $('<td></td>');
          td1.text(valor.nome);
          td1.addClass('td-nome-tipo-equip');

          var td2 = $('<td></td>');

          var btnSeleciona = $('<button><span class="fa fa-check"></span> Selecionar</button>');
          btnSeleciona.attr('class', 'btn btn-sm btn-success');

          btnSeleciona.click(function(){
            var esta = $(this);

            var tr = esta.parent().parent();
            var tdNome = tr.find('.td-nome-tipo-equip');

            formEquip.find('input[name=tipo_nome]').val(tdNome.text());
            formEquip.find('input[name=tipo]').val(tr.attr('id-tipo-equip'));
          });

          var btnAtualiza = $('<button><span class="fa fa-cogs"></span> Atualizar</button>');
          btnAtualiza.attr('class', 'btn btn-sm btn-warning');

          btnAtualiza.click(function(){

            var esta = $(this);
            var tr = esta.parent().parent();
            var tdNome = tr.find('.td-nome-tipo-equip');

            formTipoEquip.find('input[name=nome]').val(tdNome.text());
            formTipoEquip.find('input[name=id]').val(tr.attr('id-tipo-equip'));

            modalTipoEquip.modal('show');
          });

          td2.append(btnSeleciona, btnAtualiza);

          tr.append(td1, td2);

          tbTiposEq.append(tr);
        }
      }
    });
  }

  atualizaTabelaTiposEquip();

  formTipoEquip.find('button[type=reset]').on('click', function(){
  formTipoEquip.find('input').val('');
  });

  formTipoEquip.validate({
    rules: {
      nome: {required: true}
    },
    messages:{
      nome: { required: 'O nome é obrigatório.'}
    },
    errorClass: "alert alert-danger",
    errorElement: "div",

    submitHandler : function(form){
      var dados = $(form).serialize();

      $.ajax({
        type: "POST",
        url: "<?php echo URL_BASE;?>/control/equipamento-controle.php?acao=atualiza-tipo-equip&ajax=true",
        data: dados,
        dataType: 'json',
        success: function(res){

          msgFormTipoEquip.abrir(res.result, res.mensagem);

          atualizaTabelaTiposEquip();

          form.reset();
        }
      });

      return false;
    }
  });

  formEquip.validate({
    rules: {
      nome: {required: true},
      tipo_nome: {required: false},
      descricao: {required: false},
	  campus: {required: true}
    },
    messages:{
      nome: { required: 'O nome é obrigatório.'},
      //tipo_nome: { required: 'Selecione na tabela de tipos o tipo de equipamento.'},
      //descricao: { required: 'A descrição é obrigatória.'},
	  campus: { required: 'O campus é obrigatório.'}
    },
    errorClass: "alert alert-danger",
    errorElement: "div",

    submitHandler : function(form){
      var dados = $(form).serialize();

      $.ajax({
        type: "POST",
        url: "<?php echo URL_BASE;?>/control/equipamento-controle.php?acao=atualiza-equip&ajax=true",
        data: dados,
        dataType: 'json',
        success: function(res){

          msgFormEquip.abrir(res.result, res.mensagem);

          form.reset();
        }
      });

      return false;
    }
  });

  </script>
</body>
</html>
