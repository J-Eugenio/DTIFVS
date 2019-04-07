<?php
	include_once '../../config/conexao.php';
	include_once '../../config/Conexao.class.php';

	$turno = $_REQUEST['turno'];
        $campus = $_REQUEST['campus'];
        $data = $_REQUEST['datepicker'];
        $id = $_REQUEST['id'];
        $horainicio = $_REQUEST['horainicio'];
        
	$result = "SELECT  rec.id AS id, 
		rec.nome, 
        rec.quantidade AS 'Quantidade Original', 
        (rec.quantidade - ( select count(equipamento) from reserva 
                            where res.turno = '$turno'
                            AND res.data = '$data'
                            AND res.campus = '$campus'
                            AND res.horainicio = '$horainicio'
                            AND entregue = 1 
                            AND devolucao = 0
                            AND equipamento = rec.id)) as 'Quantidade Disponível' 
	FROM reserva AS res INNER JOIN recurso as rec on rec.id = res.equipamento WHERE res.equipamento = $id LIMIT 1;";

	$resultado = mysqli_query($connect, $result);
	while($result_final = mysqli_fetch_assoc($resultado)){
		$resultado_final2[] = array(
                    'qtd' => $result_final['Quantidade Disponível']
		);
	}

	echo (json_encode($resultado_final2));
?>
