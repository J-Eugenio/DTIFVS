<?php

class Reserva{
  private $conn;

  function __construct(){
    $this->conn = new Conexao;

    if(!isset($_SESSION)){
      session_start();
    }
  }

  public function cadastraReserva($dados){
    try {
      $conn = $this->conn;
      $conec = $conn->getConexao();

      $prep = $conec->prepare('INSERT INTO reserva (sala, turno, usuario, campus, data, equipamento, horainicio, horafim, reserva)'.
      'VALUES (:sala, :turno, :usuario, :campus, :data, :equipamento, :horainicio, :horafim, :reserva)');

      foreach ($dados as $chave => $valor) {
        $prep->bindValue(':'.$chave, $valor);
      }

      $prep->execute();

      return array(
        'result' => 1,
        'mensagem' => 'Reserva realizada com sucesso!'
      );

    } catch (Exception $e) {
      return array(
        'result' => 0,
        'mensagem' => 'Ocorreu um erro ao tentar realizar a reserva.'
      );
    }
  }

  public function getReservasProfLogado($termo, $res_por_pagina, $pagina_atual){
    try {
      $conn = $this->conn;
      $conec = $conn->getConexao();

      $query = 'SELECT tb_res.*, tb_equip.nome AS equip_nome,'.
      'tb_dev.datadevolucao, tb_dev.horadevolucao, tb_dev.idDevolucao'.
      ' FROM reserva tb_res INNER JOIN recurso tb_equip ON tb_res.equipamento = tb_equip.id '.
      ' LEFT JOIN devolucao tb_dev ON tb_res.id = tb_dev.reserva'.
      ' WHERE tb_res.usuario = ? AND (tb_equip.nome LIKE?) ORDER BY devolucao ASC';

      $prep = $conec->prepare($query);

      $prep->bindValue(1, $_SESSION['USER_ID']);
      $prep->bindValue(2, '%'.$termo.'%');

      $prep->execute();

      $res_fetch = $prep->fetchAll(PDO::FETCH_ASSOC);
      $qtd_resultados = $prep->rowCount();

      return motorBusca($res_fetch, $res_por_pagina, $pagina_atual, $qtd_resultados);

    } catch (Exception $e) {
      return null;
    }
  }
  public function getEntregues($termo, $res_por_pagina, $pagina_atual){
    try {
      $conn = $this->conn;
      $conec = $conn->getConexao();

      $query = 'SELECT tb_res.*, tb_equip.nome AS equip_nome,'.
      'tb_dev.datadevolucao, tb_dev.horadevolucao, tb_dev.idDevolucao, tb_prof.nome AS nome_professor'.
      ' FROM reserva tb_res INNER JOIN recurso tb_equip ON tb_res.equipamento = tb_equip.id '.
      ' INNER JOIN usuario tb_prof ON tb_prof.id = '.
      'tb_res.usuario LEFT JOIN devolucao tb_dev ON tb_res.id = tb_dev.reserva WHERE '.
      '(tb_equip.nome LIKE? OR tb_prof.nome LIKE?) AND tb_dev.idDevolucao IS NULL';


	  
	  $query .= ' AND tb_res.entregue = 1';

      $prep = $conec->prepare($query);

      $prep->bindValue(1, '%'.$termo.'%');
      $prep->bindValue(2, '%'.$termo.'%');

      $prep->execute();

      $res_fetch = $prep->fetchAll(PDO::FETCH_ASSOC);
      $qtd_resultados = $prep->rowCount();

      return motorBusca($res_fetch, $res_por_pagina, $pagina_atual, $qtd_resultados);

    } catch (Exception $e) {
      return null;
    }
  }

  public function buscarReservas($termo, $res_por_pagina, $pagina_atual, $apenas_reservas_hoje){
    try {
      $conn = $this->conn;
      $conec = $conn->getConexao();

      $query = 'SELECT tb_res.*, tb_equip.nome AS equip_nome,'.
      'tb_dev.datadevolucao, tb_dev.horadevolucao, tb_dev.idDevolucao, tb_prof.nome AS nome_professor'.
      ' FROM reserva tb_res INNER JOIN recurso tb_equip ON tb_res.equipamento = tb_equip.id '.
      ' INNER JOIN usuario tb_prof ON tb_prof.id = '.
      'tb_res.usuario LEFT JOIN devolucao tb_dev ON tb_res.id = tb_dev.reserva WHERE '.
      '(tb_equip.nome LIKE? OR tb_prof.nome LIKE?) AND tb_dev.idDevolucao IS NULL';

      
	  $query .= ' AND tb_res.entregue = 0';
	  $query .= ' ORDER BY tb_res.data DESC';

      $prep = $conec->prepare($query);

      $prep->bindValue(1, '%'.$termo.'%');
      $prep->bindValue(2, '%'.$termo.'%');

      $prep->execute();

      $res_fetch = $prep->fetchAll(PDO::FETCH_ASSOC);
      $qtd_resultados = $prep->rowCount();

      return motorBusca($res_fetch, $res_por_pagina, $pagina_atual, $qtd_resultados);

    } catch (Exception $e) {
      return null;
    }
  }

  public function registraDevolucaoReserva($id){
    try {
      $conn = $this->conn;
      $conec = $conn->getConexao();

      $prep = $conec->prepare('DELETE FROM devolucao WHERE reserva=?');
      $prep2 = $conec->prepare('INSERT INTO devolucao (usuario, reserva, datadevolucao, horadevolucao, devolucao) '.
      'VALUES (?, ?, CURRENT_DATE(), CURRENT_TIME(), ?)');
      $prep3 = $conec->prepare('UPDATE reserva SET devolucao="1", reserva = "0" WHERE id = ?');
      $prep->bindValue(1, $id);

      $prep2->bindValue(1, $_SESSION['USER_ID']);
      $prep2->bindValue(2, $id);
      $prep2->bindValue(3, '1');
      $prep3->bindValue(1, $id);
      $prep->execute();
      $prep2->execute();
      $prep3->execute();

      return array(
        'result' => 1,
        'mensagem' => 'Devolução registrada com sucesso!'
      );

    } catch (Exception $e) {
      return array(
        'result' => 0,
        'mensagem' => 'Ocorreu um erro ao tentar registrar a devolução.'
      );
    }
  }
  
  public function registraEntregueReserva($id){
    try {
      $conn = $this->conn;
      $conec = $conn->getConexao();
	  $value = 1;

      $prep = $conec->prepare('UPDATE reserva SET entregue=?, dataentregue=CURRENT_DATE(), horaentregue = CURRENT_TIME() WHERE id=?');

	  $prep->bindValue(1, $value);
	  $prep->bindValue(2, $id);
	  
      $prep->execute();

      return array(
        'result' => 1,
        'mensagem' => 'Devolução registrada com sucesso!'
      );

    } catch (Exception $e) {
      return array(
        'result' => 0,
        'mensagem' => 'Ocorreu um erro ao tentar registrar a devolução.'
      );
    }
  }

  public function removerEntregueReserva($id){
    try {
      $conn = $this->conn;
      $conec = $conn->getConexao();
    $value = 0;

      $prep = $conec->prepare('UPDATE reserva SET entregue=?, dataentregue=CURRENT_DATE(), horaentregue = CURRENT_TIME() WHERE id=?');

    $prep->bindValue(1, $value);
    $prep->bindValue(2, $id);
    
      $prep->execute();

      return array(
        'result' => 1,
        'mensagem' => 'Devolução registrada com sucesso!'
      );

    } catch (Exception $e) {
      return array(
        'result' => 0,
        'mensagem' => 'Ocorreu um erro ao tentar registrar a devolução.'
      );
    }
  }

  public function podeRealizarReserva($dia, $horaini, $horafim, $idequip, $campus){
	  
	  if(strtotime($dia) > strtotime('7 day') || strtotime($dia) < strtotime('today UTC')) {
		return false;
	  }
	  
    try {
      $conn = $this->conn;
      $conec = $conn->getConexao();

      $prep = $conec->prepare('SELECT tb_res.*, tb_dev.reserva AS dev_reserva FROM reserva tb_res LEFT JOIN '.
      'devolucao tb_dev ON tb_res.id = tb_dev.reserva WHERE tb_dev.reserva IS NULL AND tb_res.equipamento=? '.
      'AND tb_res.data=? AND ((? = tb_res.horainicio) AND (? = tb_res.horafim))');
	  
      $prep->bindValue(1, $idequip);
      $prep->bindValue(2, $dia);

      $prep->bindValue(3, $horaini);
	  $prep->bindValue(4, $horafim);

	  $anexo = "Anexo / Prédio Principal";
	  $predio = "Prédio Principal / Anexo";
	  
	  $prep2 = $conec->prepare('SELECT quantidade FROM recurso WHERE id=? AND campus=? LIMIT 1');

	  switch ($campus) {
		case 'Prédio Principal / Anexo':
		$prep2 = $conec->prepare('SELECT quantidade FROM recurso WHERE id=? AND (campus=? OR campus=?) LIMIT 1');
		      $prep2->bindValue(1, $idequip);
	  $prep2->bindValue(2, $campus);
	  $prep2->bindValue(3, $anexo);
		break;
		
		case 'Anexo / Prédio Principal':
		$prep2 = $conec->prepare('SELECT quantidade FROM recurso WHERE id=? AND (campus=? OR campus=?) LIMIT 1');
		  $prep2->bindValue(1, $idequip);
	  $prep2->bindValue(2, $campus);
	  $prep2->bindValue(3, $predio);
		break;
		
		default:
		$prep2 = $conec->prepare('SELECT quantidade FROM recurso WHERE id=? AND campus=? LIMIT 1');
		  $prep2->bindValue(1, $idequip);
	  $prep2->bindValue(2, $campus);
		break;
	  }
	  
      $prep->execute();
      $prep2->execute();

      $equip = $prep2->fetch(PDO::FETCH_ASSOC);

      return $prep->rowCount() < $equip['quantidade'];

    }catch (Exception $e){
		echo $e->getMessage();
      return false;
    }
  }
  
  public function excluirReserva($id){
    try {
      $connect = $this->conn;
      $conn = $connect->getConexao();

	  $pre = $conn->prepare('SET GLOBAL FOREIGN_KEY_CHECKS=0');
	  $prep = $conn->prepare('DELETE FROM reserva WHERE (id=? AND entregue = 0)');
	  $prep2 = $conn->prepare('SET GLOBAL FOREIGN_KEY_CHECKS=1');
	  
	  
	  $pre->execute();
	  
      $prep->bindValue(1, $id);
	  
	  $prep->execute();
	  
      $prep2->execute();

     return array(
        'result' => 0,
        'mensagem'=>'Reserva feita com sucesso !'
       );  
    } catch (Exception $e) {
      return array(
        'result' => 0,
        'mensagem'=> 'Não e possivel excluir material Entreque!!!'
      );
    }
  }
  
}
