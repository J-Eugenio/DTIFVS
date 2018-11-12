<?php

include_once '../config/config.php';

if(!isset($_SESSION)){
  session_start();
}

if(isset($_SESSION['USER_NIVEL'])){
  switch ($_SESSION['USER_NIVEL']) {
    case 1:
    case 2:
      header('Location: '.URL_BASE.'/view/usuario/pagina-usuario.php');
      break;
    default:
      header('Location: '.URL_BASE.'/view/public/login.php');
      break;
  }
}else{
     header('Location: '.URL_BASE.'/view/public/login.php');
}
