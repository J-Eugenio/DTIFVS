<?php
	$server = "localhost";
	$usuario = "root";
	$senha = "";
	$dbname = "wwwnexas_dti";

	//criar conexão
	$connect = mysqli_connect($server, $usuario, $senha, $dbname);
	$connect->set_charset("utf8");

?>