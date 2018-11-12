<?php
include_once '../../config/config.php';
include_once '../../config/Conexao.class.php';
include_once '../../model/Usuario.class.php';

$usu_inst = new Usuario;

$usu_inst->redirecNaoLogado();

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
  <link href="../../css/bootstrap.css" rel="stylesheet" />
  <!-- FONT AWESOME ICONS  -->
  <link href="../../css/font-awesome.css" rel="stylesheet" />
  <!-- CUSTOM STYLE  -->
  <link href="../../css/style.css" rel="stylesheet" />
  <link rel="icon" type="imagem/png" href="<?php echo URL_BASE; ?>/assets/img/dti.png" />
  <!-- HTML5 Shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->

  <script src="../../js/jquery-1.12.3.js"></script>
  <script src="../../js/jquery.validate.min.js"></script>
  <script src="../../js/script.js"></script>
</head>
<body>
  <?php include_once '../menu-topo.php'; ?>
  <div class="content-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h4 class="page-head-line">Página inicial do usuário</h4>
        </div>

      </div>

      <div class="row">
        <div class="col-md-7">

          <div class="panel panel-primary table-ajustes">
            <div class="panel-heading">
              Tabela de reservas
            </div>
            <div class="form-group" style="margin: 8px 10px;">
              <form id="form-busca-reservas">
                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                  <div class="input-group-btn">
                    <button class="btn btn-primary"><span class=" fa fa-search"></span></button>
                  </div>
                  <input type="text" name="termo" class="form-control" placeholder="Informe uma palavra chave para a busca..." value="">
                </div>
              </form>
            </div>
            <div class="panel-body" style="height: 250px; overflow: auto;">
              <table id="table-reservas" class="table table-striped table-bordered">
                <thead>
                  <?php if($usu_inst->possuiAcessoAdm()): ?>
                    <th>Prof°</th>
                  <?php endif; ?>
                  <th>Data</th>
                  <th>Equipamento</th>
				  <th style="width: 120px">Entregue</th>
				  <th style="width: 120px">Devolução</th>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
            <div class="panel-footer">
              <button id="btn-atualz-table-reservas" class="btn btn-default btn-block">
                <i class="glyphicon glyphicon-repeat"></i> Atualizar
              </button>
            </div>
            <script>
            function atualizaTabReservas(termo){

              if(termo == null){
                termo = $('#form-busca-reservas')[0].termo.value;
              }

              var tableRes = $('#table-reservas tbody');

              tableRes.html('');

              $.ajax({
                type: "POST",
                url: "<?php echo URL_BASE;?>"+
                "/control/reserva-controle.php?acao=busca-reservas&ajax=true",
                data: 'termo='+termo,
                dataType: 'json',
                success: function(res){
                  for (var idx in res.resultados) {
                    var valor = res.resultados[idx];

                    var tr = $('<tr></tr>');

                    <?php if($usu_inst->possuiAcessoAdm()): ?>
                    var td1 = $('<td>'+valor.nome_professor+'</td>');
                    <?php endif; ?>
                    var td2 = $('<td>'+formatData(valor.data)+'</td>');
                    var td3 = $('<td>'+valor.equip_nome+'</td>');
                    var td4 = $('<td class="td-opcao-unica"></td>');
					var td5 = $('<td class="td-opcao-unica"></td>');
					
					
					var btnEntregue = $('<button class="btn"></button>');
                    var spanIcon = $('<span class="fa"></span>');

                    btnEntregue.append(spanIcon);
                    td4.append(btnEntregue);

                    btnEntregue.attr('id-reserva', valor.id);

                    <?php if($usu_inst->possuiAcessoAdm()): ?>
                    btnEntregue.click(function(){
                      var idRes = $(this).attr('id-reserva');

                      $.ajax({
                        type: "POST",
                        url: "<?php echo URL_BASE;?>"+
                        "/control/reserva-controle.php?acao=registra-entregue-reserva&ajax=true",
                        data: 'id='+idRes,
                        dataType: 'json',
                        success: function(res){
                          if(res.result == 1){
                            atualizaTabReservas();
                          }
                        }
                      });
                    });
                    <?php endif; ?>

                    if(valor.entregue == 0){
                      btnEntregue.addClass('btn-danger');
                      spanIcon.addClass('fa-remove');
                      btnEntregue.append($('<br/><span>Não Entregue</span>'))
                    }else{
                      btnEntregue.addClass('btn-success');
                      spanIcon.addClass('fa-check');

                      btnEntregue.append($('<br/><span>'+
                      formatData(valor.dataentregue)+
                      '</span><br/><span>'+
                      formatHora(valor.horaentregue)+
                      '</span>'));
                    }
					
					var btnDevolucao = $('<button class="btn"></button>');
                    var spanIcon = $('<span class="fa"></span>');

                    btnDevolucao.append(spanIcon);
                    td5.append(btnDevolucao);

                    btnDevolucao.attr('id-reserva', valor.id);

                    <?php if($usu_inst->possuiAcessoAdm()): ?>
                    btnDevolucao.click(function(){
                      var idRes = $(this).attr('id-reserva');

                      $.ajax({
                        type: "POST",
                        url: "<?php echo URL_BASE;?>"+
                        "/control/reserva-controle.php?acao=regista-devolucao-reserva&ajax=true",
                        data: 'id='+idRes,
                        dataType: 'json',
                        success: function(res){
                          if(res.result == 1){
                            atualizaTabReservas();
                          }
                        }
                      });
                    });
                    <?php endif; ?>

                   if(valor.idDevolucao == null){
                      btnDevolucao.addClass('btn-danger');
                      spanIcon.addClass('fa-remove');
                      btnDevolucao.append($('<br/><span>Pendente</span>'))
                    }else{
                      btnDevolucao.addClass('btn-success');
                      spanIcon.addClass('fa-check');
 
                      btnDevolucao.append($('<br/><span>'+
                      formatData(valor.datadevolucao)+
                      '</span><br/><span>'+
                      formatHora(valor.horadevolucao)+
                      '</span>'));
                    }

                    <?php if($usu_inst->possuiAcessoAdm()): ?>
                    tr.append(td1, td2, td3, td4, td5);
                    <?php else: ?>
                    tr.append(td2, td3, td4, td5);
                    <?php endif; ?>

                    tableRes.append(tr);
                  }
                }
              });
            }

            atualizaTabReservas();

            $('#form-busca-reservas').on('submit', function(evt){
              atualizaTabReservas(this.termo.value);
              evt.preventDefault();
            });

            $('#btn-atualz-table-reservas').click(function(){
              atualizaTabReservas();
            });
            </script>
          </div>
        </div>
        <div class="col-md-5">
          <div class="notice-board">
            <div class="panel panel-primary table-ajustes">
              <div class="panel-heading">
                Tabela de solicitações
              </div>
              <div class="form-group" style="margin: 8px 10px;">
                <form id="form-busca-bugs">
                  <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                    <div class="input-group-btn">
                      <button class="btn btn-primary"><span class=" fa fa-search"></span></button>
                    </div>
                    <input type="text" name="termo" class="form-control" placeholder="Informe uma palavra chave para a busca..." value="">
                  </div>
                </form>
              </div>
              <div class="panel-body" style="height: 250px; overflow: auto;">
                <table id="table-solicitacoes" class="table table-striped table-bordered">
                  <thead>
                    <th>Título</th>
                    <th>Descrição</th>
                    <?php if($usu_inst->possuiAcessoAdm()): ?>
                      <th>Prof°</th>
                    <?php endif; ?>
                    <th style="width: 60px;">Status</th>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>
              <div class="panel-footer">
                <button id="btn-atualz-table-bugs" class="btn btn-default btn-block">
                  <i class="glyphicon glyphicon-repeat"></i> Atualizar
                </button>
              </div>
              <script>
              function atualizaTabSolicitacoes(termo){
                var tableSolic = $('#table-solicitacoes tbody');
                tableSolic.html('');

                $.ajax({
                  type: "POST",
                  url: "<?php echo URL_BASE;?>"+
                  "/control/bug-controle.php?acao=buscar-bug&ajax=true",
                  data: 'termo='+termo,
                  dataType: 'json',
                  success: function(res){

                    for(var attr in res){
                      var valor = res[attr];

                      var linha = $('<tr></tr>');

                      var colTitulo = $('<td>'+valor.titulo+'</td>');
                      var colDescricao = $('<td>'+valor.descricao+'</td>');
                      var colProf = $('<td>'+valor.nome_usu+'</td>');
                      var colStatus = $('<td class="td-opcao-unica"></td>');

                      var btnMudarStatus = $('<button class="btn"></button>');
                      btnMudarStatus.attr('id-bug', valor.idBug);

                      <?php if($usu_inst->possuiAcessoAdm()): ?>

                      btnMudarStatus.click(function(){
                        var self = $(this);

                        var dados = $.param({
                          'id' : self.attr('id-bug'),
                          'status' : self.attr('value')
                        });

                        $.ajax({
                          type: "POST",
                          url: "<?php echo URL_BASE;?>"+
                          "/control/bug-controle.php?acao=atualiza-stat-bug&ajax=true",
                          data: dados,
                          dataType: 'json',
                          success: function(res){

                            if(res.result = 1){
                              if(self.attr('value') == 1){
                                self.html('<span class="fa fa-check"></span>');
                                self.removeClass('btn-danger').addClass('btn-success');
                                self.attr('value', 0);
                              }else{
                                self.html('<span class="fa fa-remove"></span>');
                                self.removeClass('btn-success').addClass('btn-danger');
                                self.attr('value', 1);
                              }
                            }
                          }
                        });
                      });

                      <?php endif; ?>

                      if(valor.status == 1){
                        btnMudarStatus.html('<span class="fa fa-check"></span>');
                        btnMudarStatus.addClass('btn-success');
                        btnMudarStatus.attr('value', 0);
                      }else{
                        btnMudarStatus.html('<span class="fa fa-remove"></span>');
                        btnMudarStatus.addClass('btn-danger');
                        btnMudarStatus.attr('value', 1);
                      }

                      colStatus.append(btnMudarStatus);

                      <?php if($usu_inst->possuiAcessoAdm()): ?>
                      linha.append(colTitulo, colDescricao, colProf, colStatus);
                      <?php elseif($usu_inst->possuiAcessoProfessor()): ?>
                      linha.append(colTitulo, colDescricao, colStatus);
                      <?php endif; ?>
                      tableSolic.append(linha);
                    }
                  }
                });
              }

              atualizaTabSolicitacoes('');

              $('#form-busca-bugs').on('submit', function(evt){
                atualizaTabSolicitacoes(this.termo.value);
                evt.preventDefault();
              });

              $('#btn-atualz-table-bugs').click(function(evt){
                atualizaTabSolicitacoes($('#form-busca-bugs')[0].termo.value);
                evt.preventDefault();
              });
              </script>
            </div>
          </div>
          <?php if($usu_inst->possuiAcessoProfessor()): ?>
            <div class="Compose-Message">
              <div class="panel panel-primary">
                <div class="panel-heading">
                  <span class="fa fa-flag"></span> Realizar solicitação
                </div>
                <form id="form-registra-bug">
                  <div class="panel-body">
                    <div class="form-group">
                      <label>Título : </label>
                      <input name="titulo" type="text" class="form-control" />
                    </div>
                    <div class="form-group">
                      <label>Descrição :  </label>
                      <textarea name="descricao" rows="9" class="form-control"></textarea>
                    </div>
                    <hr />
                    <button type="submit" class="btn btn-success"><span class="fa fa-check"></span> Enviar</Button>
                      <button type="reset" class="btn btn-warning"><span class="fa fa-remove"></span> Cancelar</Button>
                      </div>
                    </form>

                    <script>
                    $('#form-registra-bug').validate({
                      rules: {
                        titulo: {required: true},
                        descricao: {required: true}
                      },
                      messages:{
                        titulo: { required: 'Defina um título.'},
                        descricao: { required: 'Defina uma descrição.'},
                      },
                      errorClass: "alert alert-danger",
                      errorElement: "div",

                      submitHandler : function(form){
                        var dados = $(form).serialize();

                        $.ajax({
                          type: "POST",
                          url: "<?php echo URL_BASE;?>"+
                          "/control/bug-controle.php?acao=atualiza-bug&ajax=true",
                          data: dados,
                          dataType: 'json',
                          success: function(res){

                            $('#form-registra-bug .panel-body').msgRapida().abrir(res.result, res.mensagem);
                            atualizaTabSolicitacoes('');
                            form.reset();
                          }
                        });

                        return false;
                      }
                    });
                    </script>
                  </div>
                </div>
              <?php endif; ?>
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
      <!-- BOOTSTRAP SCRIPTS  -->
      <script src="../../js/bootstrap.js"></script>
    </body>
    </html>
