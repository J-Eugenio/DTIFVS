<?php

include_once '../config/config.php';
include_once '../config/Conexao.class.php';
include_once '../model/Usuario.class.php';

$usuario_inst = new Usuario;

$acao = $_GET['acao'];
$ajax = isset($_GET['ajax']);

switch ($acao) {
  case 'login':
    $res = $usuario_inst->logar($_POST['email'], $_POST['cpf']);
    if($ajax){
      echo json_encode($res);
    }else{
      header('Location: '.URL_BASE.'/control/redireciona.php');
    }
    break;

	
	case 'cadastrar-usuario':
    $login = $_POST['login'];
	$senha = $_POST['senha'];
	$nome = $_POST['nome'];
	$cpf = $_POST['cpf'];
	$email = $_POST['email'];
    $nivel = $_POST['nivel'];

	$res = $usuario_inst->cadastrar($login,$senha,$nome,$cpf,$email,$nivel);
    
    if($ajax){
      echo json_encode($res);
    }

    break;
	
	case 'atualizar-usuario':
	$login = $_POST['login'];
	$senha = $_POST['senha'];
	$nome = $_POST['nome'];
	$cpf = $_POST['cpf'];
	$email = $_POST['email'];
	
	$res = $usuario_inst->alterarUsuario($login,$senha,$nome,$cpf,$email);

    if($ajax){
      echo json_encode($res);
    }
	break;
	
	case 'excluir-usuario':
	$res = $usuario_inst->excluirUsuario($_GET['id']);

    if($ajax){
      echo json_encode($res);
    }else{
      header('Location: '.URL_BASE.'\view\administrador\buscar-usuarios.php');
    }

	
	$res = $usuario_inst->alterarUsuario($login,$senha,$nome,$cpf,$email);

    if($ajax){
      echo json_encode($res);
    }
	break;
	
	
	case 'alterar-senha':
	$id = $usuario_inst->getIDUsuarioLogado();
	$senha2 = $_POST['senha2'];

    $res = $usuario_inst->alterar($id,$senha2);
	
    if($ajax){
      echo json_encode($res);
    }

    break;
	
    case 'logoff':
    $usuario_inst->logoff();

    if(!$ajax){
      header('Location: '.URL_BASE.'/view/public/login.php');
    }
	
    break;
}
