<?php
include_once '../../config/config.php';
include_once '../../config/Conexao.class.php';
include_once '../../model/Usuario.class.php';
include_once '../../model/Recurso.class.php';
include_once '../../config/conexao.php';

$usu_inst = new Usuario;
$equip_inst = new Recurso;

$usu_inst->redirecNaoProfessor();

$usu_logado = $usu_inst->getUsuarioLogado();

$pagindice = isset($_GET['pagindice']) ? $_GET['pagindice'] : 1;
$equip = "HDMI";
$lista_equips = $equip_inst->buscarRecursos(empty($_GET['termo']) ? '' : $_GET['termo'], 10, $pagindice);
//buscarQtdDisponivel
//$lista_equips2 = $equip_inst->buscarQtdDisponivel($equip, 10, $pagindice);
//var_dump($result);
$QtdDisponivel = 0;



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

  <link rel="icon" type="imagem/png" href="<?php echo URL_BASE; ?>/assets/img/dti.png" />

  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->

  <link rel="stylesheet" href="<?php echo URL_BASE ?>/css/jquery-ui.css">
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
</head>
<body>

  <?php include_once '../menu-topo.php' ?>

  <div class="content-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h4 class="page-head-line">Buscar equipamentos</h4>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Tabela de equipamentos - Exibindo página
                <strong><?php echo $lista_equips['pagina_atual'] ?></strong>
                de
                <strong><?php echo $lista_equips['limites_pagina'] ?></strong>
                - <strong><?php echo $lista_equips['qtd_resultados'] ?></strong> dados
              </h3>
            </div>
            <div class="panel-body">
              <div class="col-md-12 form-group">
                <form action="" method="get" id="form-busca">
                  <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                    <div class="input-group-addon"><span class="fa fa-search"></span></div>
                    <input type="hidden" name="pagindice" value="1">
                    <select onchange="this.form.submit()" name="termo" autocomplete="off" class="form-control">
                      <option value=" "></option>
                      <option value="Anexo">Principal</option>
                      <option value="Anexo">Anexo</option>
                      <option value="Clínica">Clínica Escola</option>
                      <option value=" ">Todos</option>
                    </select>
                  </div>
                </form>
              </div>
              <div class="col-md-12">
                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="50%">
                  <thead>
                    <tr>
                      <th>Nome do equipamento</th>
                      <th>Campus</th>
                      <th class="text-center">Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($lista_equips['resultados'] as $equip_row): 
                      for ($i=0; $i < sizeof($result); $i++) { 
                         if($result[$i]['id'] == $equip_row['id']){
                            $QtdDisponivel = $result[$i]['Quantidade Disponível'];
                         }
                      }
                      ?>
                      <tr>
                       <td style="display:none;" data-id="<?php echo $equip_row['id']; ?>"><?php echo $equip_row['id']; ?></td>
                        <td data-nome="<?php echo $equip_row['nome']; ?>"><?php echo $equip_row['nome']; ?></td>
                        <td><?php echo $equip_row['campus']; ?></td>
                        <td class="text-center">
                          <a href="<?php echo $equip_row['id']; ?>"
                            class="btn btn-sm btn-primary reservar-equip">
                            <span class="fa fa-clock-o"></span> Reservar</a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>

                </div>
              </div>
              <div class="panel-footer">
                <ul class="pagination" style="margin: 0;">
                  <li class="paginate_button previous <?php echo $lista_equips['primeira_pag'] ? 'disabled' : '' ?>"
                    id="example_previous">
                    <a href="" aria-controls="example" data-dt-idx="0" tabindex="0">&lt;</a>
                  </li>
                  <li class="paginate_button active">
                    <a href="#" aria-controls="example" data-dt-idx="1" tabindex="0"><?php echo $pagindice ?></a>
                  </li>
                  <li class="paginate_button next <?php echo $lista_equips['ultima_pag'] ? 'disabled' : '' ?>"
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

    <div class="modal fade" id="modal-conf-exc-equip" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Formulário de reserva do equipamento</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="form-cadastro-reserva">
		<input type="hidden" name="equipamento" value="">
        <div class="modal-body">
        <div class="row">
        <div class="col-md-6">
        
        <div class="form-group">
          <label>Equipamento:</label>
          <input type="text" id="equip-reservado" class="form-control" disabled>
              <input type="hidden" id="id_equips" class="form-control" disabled>
        </div>
        <div class="form-group">
		  <label>Selecione o Campus:</label>
		   <select class ="form-control" onchange="changeSelect();" name = "campus" id ="campus">
			<option value=""></option>
			<option value="Prédio Principal / Anexo">Prédio Principal</option>
			<option value="Anexo / Prédio Principal">Anexo</option>
			<option value="Clínica Escola">Clínica Escola</option>
		   </select>
		</div>	
		</div>
		<div class="col-md-6">
				<div class="form-group">
                  <label>Selecione a Sala:</label>
                  <select id ="sala" class="form-control" name="sala">
				  <option value=""></option>
				  </select>
				</div>
				<div class="form-group">
                  <label>Selecione uma data:</label>
                  <input type="text" name="data" class="form-control" id="datepicker" autocomplete="off"/>
        </div>
        <div class="form-group">
        </div>
		</div>
        </div>

			  <script type="text/javascript">

			  function changeSelect(){

        var select = document.getElementById('campus');
        var selectSetor = document.getElementById('sala');

        var value = select.options[select.selectedIndex].value;

        //remove itens
        var length = selectSetor.options.length;
        var i;
        for(i = selectSetor.options.length-1 ; i>=0 ; i--)
        {
            selectSetor.remove(i);
        }


        if(value == 'Prédio Principal / Anexo') {

            var option = document.createElement('option');
            option.value = 'Sala 01 Principal';
            option.text = 'Sala 01';

			var option2 = document.createElement('option');
			option2.value = 'Sala 02 Principal';
            option2.text = 'Sala 02';

			var option3 = document.createElement('option');
			option3.value = 'Sala 03 Principal';
            option3.text = 'Sala 03';

			var option4 = document.createElement('option');
			option4.value = 'Sala 04 Principal';
            option4.text = 'Sala 04';

			var option5 = document.createElement('option');
			option5.value = 'Sala 05 Principal';
            option5.text = 'Sala 05';

			var option6 = document.createElement('option');
			option6.value = 'Sala 06 Principal';
            option6.text = 'Sala 06';

			var option7 = document.createElement('option');
			option7.value = 'Sala 07 Principal';
            option7.text = 'Sala 07';

			var option8 = document.createElement('option');
			option8.value = 'Sala 08 Principal';
            option8.text = 'Sala 08';

			var option9 = document.createElement('option');
			option9.value = 'Sala 13 Principal';
            option9.text = 'Sala 13';

			var option10 = document.createElement('option');
			option10.value = 'Sala 14 Principal';
            option10.text = 'Sala 14';

			var option11 = document.createElement('option');
			option11.value = 'Sala 15 Principal';
            option11.text = 'Sala 15';

			var option12 = document.createElement('option');
			option12.value = 'Sala 16 Principal';
            option12.text = 'Sala 16';

			var option13 = document.createElement('option');
			option13.value = 'Sala 18 Principal';
            option13.text = 'Sala 18';

			var option14 = document.createElement('option');
			option14.value = 'Sala 19 Principal';
            option14.text = 'Sala 19';

            var option15 = document.createElement('option');
            option15.value = 'Auditório Prédio Principal';
            option15.text = 'Auditório Prédio Principal';

            selectSetor.add(option);
            selectSetor.add(option2);
			selectSetor.add(option3);
			selectSetor.add(option4);
			selectSetor.add(option5);
			selectSetor.add(option6);
			selectSetor.add(option7);
			selectSetor.add(option8);
			selectSetor.add(option9);
			selectSetor.add(option10);
			selectSetor.add(option11);
			selectSetor.add(option12);
			selectSetor.add(option13);
			selectSetor.add(option14);
			selectSetor.add(option15);

        } else if (value == 'Anexo / Prédio Principal'){

            var option = document.createElement('option');
            option.value = 'Sala 01 Anexo';
            option.text = 'Sala 01';

			var option2 = document.createElement('option');
			option2.value = 'Sala 02 Anexo';
            option2.text = 'Sala 02';

			var option3 = document.createElement('option');
			option3.value = 'Sala 03 Anexo';
            option3.text = 'Sala 03';

			var option4 = document.createElement('option');
			option4.value = 'Sala 04 Anexo';
            option4.text = 'Sala 04';

			var option5 = document.createElement('option');
			option5.value = 'Sala 05 Anexo';
            option5.text = 'Sala 05';

			var option6 = document.createElement('option');
			option6.value = 'Sala 06 Anexo';
            option6.text = 'Sala 06';

			var option7 = document.createElement('option');
			option7.value = 'Sala 07 Anexo';
            option7.text = 'Sala 07';

			var option8 = document.createElement('option');
			option8.value = 'Sala 08 Anexo';
            option8.text = 'Sala 08';

            selectSetor.add(option);
            selectSetor.add(option2);
			selectSetor.add(option3);
			selectSetor.add(option4);
			selectSetor.add(option5);
			selectSetor.add(option6);
			selectSetor.add(option7);
			selectSetor.add(option8);

        }   else if (value == 'Clínica Escola'){

            var option = document.createElement('option');
            option.value = 'Sala 01 Clínica';
            option.text = 'Sala 01';

			var option2 = document.createElement('option');
			option2.value = 'Sala 02 Clínica';
            option2.text = 'Sala 02';

			var option3 = document.createElement('option');
			option3.value = 'Sala 03 Clínica';
            option3.text = 'Sala 03';

			var option4 = document.createElement('option');
			option4.value = 'Sala 04 Clínica';
            option4.text = 'Sala 04';

			var option5 = document.createElement('option');
			option5.value = 'Sala 05 Clínica';
            option5.text = 'Sala 05';

			var option6 = document.createElement('option');
			option6.value = 'Sala 06 Clínica';
            option6.text = 'Sala 06';

			var option7 = document.createElement('option');
			option7.value = 'Sala 07 Clínica';
            option7.text = 'Sala 07';

			var option8 = document.createElement('option');
			option8.value = 'Sala 08 Clínica';
            option8.text = 'Sala 08';

			var option9 = document.createElement('option');
			option9.value = 'Sala 09 Clínica';
            option9.text = 'Sala 09';

			var option10 = document.createElement('option');
			option10.value = 'Sala 10 Clínica';
            option10.text = 'Sala 10';

			var option11 = document.createElement('option');
			option11.value = 'Sala 11 Clínica';
            option11.text = 'Sala 11';

			var option12 = document.createElement('option');
			option12.value = 'Sala 12 Clínica';
            option12.text = 'Sala 12';

			var option13 = document.createElement('option');
			option13.value = 'Auditório Clínica';
            option13.text = 'Auditório Clínica';

            selectSetor.add(option);
            selectSetor.add(option2);
			selectSetor.add(option3);
			selectSetor.add(option4);
			selectSetor.add(option5);
			selectSetor.add(option6);
			selectSetor.add(option7);
			selectSetor.add(option8);
			selectSetor.add(option9);
			selectSetor.add(option10);
			selectSetor.add(option11);
			selectSetor.add(option12);
			selectSetor.add(option13);

        }
    }
</script>


            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Selecione o turno:</label>
                  <select class="form-control" onchange="changeSelect2();" name="turno" id="turno">
                    <option value=""></option>
                    <option value="Manhã">Manhã</option>
                    <option value="Tarde">Tarde</option>
                    <option value="Noite">Noite</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <span id="resultado_qtd"></span>
                </div>
              </div>
              <script type="text/javascript">
		$(function(){
                    
			$('.carregando').hide();
			$('#turno').change(function(){
				if( $(this).val() ) {
					$('#resultado_qtd').hide();
					$.getJSON('refresh.php?search=',
                                        {
                                            id: $('#id_equips').val(),
                                            turno: $('#turno').val(),
                                            campus: $('#campus').val(),
                                            datepicker: $('#datepicker').val(),
                                            horainicio: $('#horainicio').val(),
                                            
                                        
                                        }
                                        , function(j){
						var valor = '';	
						valor = 'Quantidade Disponivel: ' + j[0].qtd;	
						$('#resultado_qtd').html(valor).show();
					});
				} else {
					$('.carregando').hide();
					$('#resultado_qtd').html('Nenhuma Registro emcontrado');
				}
			});
                        $('#campus').change(function(){
				if( $(this).val() ) {
					$('#resultado_qtd').hide();
					$.getJSON('refresh.php?search=',
                                        {
                                            id: $('#id_equips').val(),
                                            turno: $('#turno').val(),
                                            campus: $('#campus').val(),
                                            datepicker: $('#datepicker').val(),
                                            horainicio: $('#horainicio').val(),
                                            
                                        
                                        }
                                        , function(j){
						var valor = '';	
						valor = 'Quantidade Disponivel: ' + j[0].qtd;	
						$('#resultado_qtd').html(valor).show();
					});
				} else {
					$('.carregando').hide();
					$('#resultado_qtd').html('Nenhuma Registro emcontrado');
				}
			});  
                        $('#datepicker').change(function(){
				if( $(this).val() ) {
					$('#resultado_qtd').hide();
					$.getJSON('refresh.php?search=',
                                        {
                                            id: $('#id_equips').val(),
                                            turno: $('#turno').val(),
                                            campus: $('#campus').val(),
                                            datepicker: $('#datepicker').val(),
                                            horainicio: $('#horainicio').val(),
                                            
                                        
                                        }
                                        , function(j){
						var valor = '';	
						valor = 'Quantidade Disponivel: ' + j[0].qtd;	
            if(j[0].qtd == 0){
              document.getElementById("btn-confirma-exclusao-equip").disabled = true; 
            }
						$('#resultado_qtd').html(valor).show();
					});
				} else {
					$('.carregando').hide();
					$('#resultado_qtd').html('Nenhuma Registro emcontrado');
				}
			});
                        $('#horainicio').change(function(){
				if( $(this).val() ) {
					$('#resultado_qtd').hide();
					$.getJSON('refresh.php?search=',
           {
                                            id: $('#id_equips').val(),
                                            turno: $('#turno').val(),
                                            campus: $('#campus').val(),
                                            datepicker: $('#datepicker').val(),
                                            horainicio: $('#horainicio').val(),

                                        
                                        }
                                        , function(j){
						var valor = '';	
						valor = 'Quantidade Disponivel: ' + j[0].qtd;	
						$('#resultado_qtd').html(valor).show();

					});
				} else {
					$('.carregando').hide();
					$('#resultado_qtd').html('Nenhuma Registro emcontrado');
				}
			});
                        $('#horafim').change(function(){
				if( $(this).val() ) {
					$('#resultado_qtd').hide();
					$.getJSON('refresh.php?search=',
                                        {
                                            id: $('#id_equips').val(),
                                            turno: $('#turno').val(),
                                            campus: $('#campus').val(),
                                            datepicker: $('#datepicker').val(),
                                            horainicio: $('#horainicio').val(),
                                           
                                        
                                        }
                                        , function(j){
						var valor = '';	
						valor = 'Quantidade Disponivel: ' + j[0].qtd;	
						$('#resultado_qtd').html(valor).show();
					});
				} else {
					$('.carregando').hide();
					$('#resultado_qtd').html('Nenhuma Registro emcontrado');
				}
			});
		});
		</script>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Informe a hora inicio da reserva:</label>
				   <select class="form-control" name="horainicio" id="horainicio">
                    <option value=""></option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Informe a hora final da reserva:</label>
                 <select class="form-control" name="horafim" id="horafim">
                    <option value=""></option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <script type="text/javascript">

            function changeSelect2(){

            var select = document.getElementById('turno');
            var selectSetor = document.getElementById('horainicio');
            var selectSetor2 = document.getElementById('horafim');

            var value = select.options[select.selectedIndex].value;

            //remove itens
            var length = selectSetor.options.length;
            var i;
            for(i = selectSetor.options.length-1 ; i>=0 ; i--)
            {
            selectSetor.remove(i);
            }
            for(i = selectSetor2.options.length-1 ; i>=0 ; i--)
            {
            selectSetor2.remove(i);
            }

            
            switch(value){
              case 'Manhã':
                var option = document.createElement('option');
                option.value = 'AB';
                option.text = 'AB';

                var option2 = document.createElement('option');
                option2.value = 'CD';
                option2.text = 'CD';

                var option3 = document.createElement('option');
                option3.value = 'EF';
                option3.text = 'EF';

                var option4 = document.createElement('option');
                option4.value = 'AB';
                option4.text = 'AB';

                var option5 = document.createElement('option');
                option5.value = 'CD';
                option5.text = 'CD';

                var option6 = document.createElement('option');
                option6.value = 'EF';
                option6.text = 'EF';

                selectSetor.add(option);
                selectSetor.add(option2);
                selectSetor.add(option3); 
                selectSetor2.add(option4);
                selectSetor2.add(option5);
                selectSetor2.add(option6); 
              break;

              case 'Tarde':
              case 'Noite':
                var option7 = document.createElement('option');
                option7.value = 'AB';
                option7.text = 'AB';

                var option8 = document.createElement('option');
                option8.value = 'CD';
                option8.text = 'CD';

                var option9 = document.createElement('option');
                option9.value = 'AB';
                option9.text = 'AB';

                var option10 = document.createElement('option');
                option10.value = 'CD';
                option10.text = 'CD';

                selectSetor.add(option7);
                selectSetor.add(option8); 
                selectSetor2.add(option9);
                selectSetor2.add(option10); 
              break;      
            }
          }
          </script>
          <div class="modal-footer">
            <button id="btn-confirma-exclusao-equip" class="btn btn-success btn-concluir-cc">
              <span class="fa fa-check"></span> Concluir</button>
            <button class="btn btn-warning" data-dismiss="modal">
              <span class="fa fa-close"></span> Cancelar</button>
          </div>
        </form>
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
  <script src="<?php echo URL_BASE ?>/js/script.js"></script>
  <script src="<?php echo URL_BASE; ?>/js/jquery.validate.min.js"></script>
  <script src="<?php echo URL_BASE; ?>/js/jquery.mask.js"></script>
  <script type="text/javascript">
  

  $('.campo-horario').mask('00:00');

  $("#datepicker").datepicker({
      dateFormat: 'yy/mm/dd',
      dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'],
      dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
      dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
      monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
      monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
  });

  var msgFormReserva = $('#form-cadastro-reserva .modal-body').msgRapida();

  var formBusca = $('#form-busca');
  var formReserva = $('#form-cadastro-reserva');
  var idSelecEquip;

  $('.reservar-equip').click(function(evt){
    idSelecEquip = $(this).attr('href');
    formReserva.find('input[name=equipamento]').val(idSelecEquip);
    $('#modal-conf-exc-equip').modal('show');
    $('#modal-conf-exc-equip').on('hidden.bs.modal', function() {
    console.log('fechar modal')
    $(this).find('input:text').val('');
    $(this).find('select').val('');
    location.reload();
  });
    evt.preventDefault();
  });
  $(function(){
    $(document).on('click', '.reservar-equip', function(e) {
        e.preventDefault;
        var nome = $(this).closest('tr').find('td[data-nome]').data('nome');
        var id = $(this).closest('tr').find('td[data-id]').data('id');
        $("#equip-reservado").val(nome);
        $("#id_equips").val(id);   

    });
  });
  $('.btn-concluir-cc').click(function(evt){
     $('#modal-conf-exc-equip').modal('hide');
  });
  function pegarValor(){
    w=document.getElementById("var").value;
    alert(w);
  }

  $('#example_previous a').click(function(evt){
    formBusca.find('input[name=pagindice]').val(<?php echo $lista_equips['pagina_atual']-1 ?>);
    formBusca.submit();
    evt.preventDefault();
  });

  $('#example_next a').click(function(evt){
    formBusca.find('input[name=pagindice]').val(<?php echo $lista_equips['pagina_atual']+1 ?>);
    formBusca.submit();
    evt.preventDefault();
  });

  formReserva.validate({
    rules: {
      data: {required: true},
      horainicio: {required: true},
      horafim: {required: true},
      sala: {required: true}
    },
    messages:{
      data: { required: 'Informe a data da reserva.'},
      horainicio: { required: 'Informe a hora inicial da reserva.'},
      horafim: { required: 'Informe a hora final da reserva.'},
      sala: { required: 'Informe a sala da reserva.'}
    },
	//successClas: "alert alert-success",
	//successElement: "div",
    errorClass: "alert alert-danger",
    errorElement: "div",

    submitHandler : function(form){
      var dados = $(form).serialize();

      $.ajax({
        type: "POST",
        url: "<?php echo URL_BASE;?>/control/reserva-controle.php?acao=atualiza-reserva&ajax=true",
        data: dados,
        dataType: 'json',
        success: function(res){
          msgFormReserva.abrir(res.result, res.mensagem);
          //form.reset();
        }
      });

      return false;
    }
  });
  </script>
</body>
</html>
