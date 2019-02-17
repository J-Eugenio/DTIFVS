<?php

include_once '../config/config.php';
include_once '../config/Conexao.class.php';
include_once '../model/Usuario.class.php';
include_once '../model/Reserva.class.php';

$usuario_inst = new Usuario;
$reserva_inst = new Reserva;

$acao = $_GET['acao'];
$ajax = isset($_GET['ajax']);

if($usuario_inst->possuiAcessoProfessor()){
  switch ($acao) {
    case 'atualiza-reserva':

    $data = DateTime::createFromFormat('d/m/Y', $_POST['data']);

    $data_reserva = $data->format('Y-m-d');

    $dados = array(
      'campus' => $_POST['campus'],
      'equipamento' => $_POST['equipamento'],
      'sala' => $_POST['sala'],
      'turno' => $_POST['turno'],
      'data' => $data_reserva,
      'horainicio' => $_POST['horainicio'],
      'horafim' => $_POST['horafim'],
      'usuario' => $usuario_inst->getIDUsuarioLogado()
    );

    $equipDisp = $reserva_inst->podeRealizarReserva(
      $data_reserva,
      $_POST['horainicio'],
      $_POST['horafim'],
      $_POST['equipamento'],
	  $_POST['campus']
    );
	
    if(empty($_POST['id'])){
      if(!$equipDisp){
        $res = array(
          'result' => 0,
          'mensagem' => 'Este equipamento não está disponível para reserva, tente reservar para outra ocasião.'
        );
      }else{
        $res = $reserva_inst->cadastraReserva($dados);
      }
    }

    if($ajax){
      echo json_encode($res);
    }
	 

    break;

    case 'busca-reservas':
    $res = $reserva_inst->getReservasProfLogado($_POST['termo'], 15, 1, false);

    if($ajax){
      echo json_encode($res);
    }
    break;
	
    case 'excluir-reserva':

    $res = $reserva_inst->excluirReserva($_GET['id']);

    if($ajax){
      echo json_encode($res);
    } else {
		header('Location: '.URL_BASE.'\view\professor\minhas-reservas.php');
	}

    break;
  }
}

if($usuario_inst->possuiAcessoAdm()){
  switch ($acao) {
    case 'busca-reservas':
    $res = $reserva_inst->buscarReservas($_POST['termo'], 15, 1, false);

    if($ajax){
      echo json_encode($res);
    }
    break;
    
    case 'busca-entregues':
    $res = $reserva_inst->getEntregues($_POST['termo'], 15, 1, false);     
    if($ajax){
      echo json_encode($res);
    }
    break;
    case 'regista-devolucao-reserva':

    $resp = $reserva_inst->registraDevolucaoReserva($_POST['id']);

    if($ajax){
      echo json_encode($resp);
    }

    break;
	
	case 'registra-entregue-reserva':

    $resp = $reserva_inst->registraEntregueReserva($_POST['id']);

    if($ajax){
      echo json_encode($resp);
    }
	
    break;

  case 'remover-entregue-reserva':

    $resp = $reserva_inst->removerEntregueReserva($_POST['id']);

    if($ajax){
      echo json_encode($resp);
    }
  
    break;
  }
}
