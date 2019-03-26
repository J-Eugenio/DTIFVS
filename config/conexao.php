<?php
	$server = "localhost";
	$usuario = "root";
	$senha = "";
	$dbname = "wwwnexas_dti";

	//criar conexão
	$connect = mysqli_connect($server, $usuario, $senha, $dbname);
	$connect->set_charset("utf8");

	//
	$query = 'SELECT u.nome, u.email, re.nome
	FROM reserva AS r
	INNER JOIN recurso AS re ON r.equipamento = re.id
	INNER JOIN usuario AS u ON r.usuario = u.id
	WHERE r.data < current_date() and entregue = 1 and devolucao = 0';

	$dados = mysqli_query($connect, $query);

	function GetUltMsg(){
		$connect = $GLOBALS['connect']; 
		$rSQL = "SELECT * FROM notificacao GROUP BY id DESC LIMIT 1;"; 
        $resultado = mysqli_query($connect, $rSQL); 
        $re = mysqli_fetch_array($resultado);
        return $re[1];
	}
?>