<?php

include_once '../config/config.php';
include_once '../config/Conexao.class.php';
include_once '../model/Usuario.class.php';
include_once '../model/Bug.class.php';

$usuario_inst = new Usuario;
$bug_inst = new Bug;

$acao = $_GET['acao'];
$ajax = isset($_GET['ajax']);

if($usuario_inst->possuiAcessoProfessor()){
  switch ($acao) {
    case 'atualiza-bug':
    $dados = array(
      'titulo' => $_POST['titulo'],
      'descricao' => $_POST['descricao'],
      'status' => 0
    );

    $rsp = $bug_inst->cadastraBug($dados);

    if($ajax){
      echo json_encode($rsp);
    }

    break;

    case 'buscar-bug':

    $lista = $bug_inst->buscaBugProfLogado($_POST['termo']);

    if($ajax){
      echo json_encode($lista);
    }

    break;
  }
}

if($usuario_inst->possuiAcessoAdm()){
  switch ($acao) {
    case 'atualiza-stat-bug':

    $rsp = $bug_inst->altStatusBug($_POST['id'], $_POST['status']);

    if($ajax){
      echo json_encode($rsp);
    }

    break;
    case 'buscar-bug':

    $lista = $bug_inst->buscaBug($_POST['termo']);

    if($ajax){
      echo json_encode($lista);
    }

    break;
  }
}
