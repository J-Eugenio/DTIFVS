<?php

include_once '../config/config.php';
include_once '../config/Conexao.class.php';
include_once '../model/Usuario.class.php';
include_once '../model/Recurso.class.php';

$usuario_inst = new Usuario;
$recurso_inst = new Recurso;

$acao = $_GET['acao'];
$ajax = isset($_GET['ajax']);

if($usuario_inst->possuiAcessoAdm()){
  switch ($acao) {
    case 'atualiza-tipo-equip':
    if(empty($_POST['id'])){
      $res = $recurso_inst->cadastraTipoRecurso($_POST['nome']);
    }else{
      $res = $recurso_inst->atualizaTipoRecurso($_POST['id'], $_POST['nome']);
    }

    if($ajax){
      echo json_encode($res);
    }

    break;

    case 'atualiza-equip':

	$descs = $_POST['descricao'];
	$tipos = $_POST['tipo'];
	$type = 0;
	
	if(!empty($tipos)) {
		$type = 1;
		$dados = array(
      'nome' => $_POST['nome'],
      'descricao' => $_POST['descricao'],
      'tipo' => $_POST['tipo'],
      'quantidade' => $_POST['quantidade'],
	  'campus' => $_POST['campus']
    );
    }
	else {
		$type = 2;
		$dados = array(
      'nome' => $_POST['nome'],
      'descricao' => $_POST['descricao'],
      'quantidade' => $_POST['quantidade'],
	  'campus' => $_POST['campus']
    );
	}
	

    if(!empty($_POST['id'])){
      $dados['id'] = $_POST['id'];
      $res = $recurso_inst->atualizaRecurso($dados);
    }else{
      $res = $recurso_inst->cadastraRecurso($dados, $type);
    }

    if($ajax){
      echo json_encode($res);
    }

    break;

    case 'excluir-equipamento':

    $res = $recurso_inst->excluirRecurso($_GET['id']);

    if($ajax){
      echo json_encode($res);
    }else{
      header('Location: '.URL_BASE.'\view\administrador\buscar-equipamento.php');
    }

    break;
  }
}

if($usuario_inst->possuiAcessoAdm() || $usuario_inst->possuiAcessoProfessor()){
  switch ($acao) {
    case 'busca-tipo-equip':

    $lista = $recurso_inst->buscarTipoRecursos();
    echo json_encode($lista);

    break;

    case 'busca-equip':

    $lista = $recurso_inst->buscarRecursos($_POST['termo']);
    echo json_encode($lista);

    break;
  }
}
