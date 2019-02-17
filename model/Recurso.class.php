<?php

class Recurso{
  private $conn;

  function __construct(){
    $this->conn = new Conexao;
  }

  public function cadastraTipoRecurso($nome){
    try {
      $connect = $this->conn;
      $conn = $connect->getConexao();

      $prep = $conn->prepare('INSERT INTO tiporecurso (nome) VALUES (?)');
      $prep->bindValue(1, $nome);

      $prep->execute();

      return array(
        'result' => 1,
        'mensagem' => 'Tipo de equipamento cadastrado com sucesso!'
      );

    } catch (Exception $e) {
      return array(
        'result' => 0,
        'mensagem' => 'Ocorreu um erro ao cadastrar o tipo de equipamento.'
      );
    }

  }

  public function atualizaTipoRecurso($id, $nome){
    try {
      $connect = $this->conn;
      $conn = $connect->getConexao();

      $prep = $conn->prepare('UPDATE tiporecurso SET nome=? WHERE id=?');
      $prep->bindValue(1, $nome);
      $prep->bindValue(2, $id);

      $prep->execute();

      return array(
        'result' => 1,
        'mensagem' => 'Tipo de equipamento alterado com sucesso!'
      );

    } catch (Exception $e) {
      return array(
        'result' => 0,
        'mensagem' => 'Ocorreu um erro ao alterar o tipo de equipamento.'
      );
    }

  }

  public function cadastraRecurso($parametros, $type){
    try {
      $connect = $this->conn;
      $conn = $connect->getConexao();

	  if($type == 1) {
      $prep = $conn->prepare('INSERT INTO recurso  (nome, descricao, tipo, quantidade, campus) VALUES'.
      ' (:nome, :descricao, :tipo, :quantidade, :campus)');
	  } else {
		 $prep = $conn->prepare('INSERT INTO recurso  (nome, descricao, quantidade, campus) VALUES'.
      ' (:nome, :descricao, :quantidade, :campus)'); 
	  }
      foreach ($parametros as $chave => $valor) {
        $prep->bindValue(':'.$chave, $valor);
      }

      $prep->execute();

      return array(
        'result' => 1,
        'mensagem' => 'Equipamento cadastrado com sucesso!'
      );

    } catch (Exception $e) {
      return array(
        'result' => 0,
        'mensagem' => 'Ocorreu um erro ao cadastrar o equipamento.'
      );
    }
  }

  public function atualizaRecurso($parametros){
    try {
      $connect = $this->conn;
      $conn = $connect->getConexao();

      $prep = $conn->prepare('UPDATE recurso set nome=:nome, descricao=:descricao, tipo=:tipo, quantidade=:quantidade, campus=:campus'.
      ' WHERE id=:id');

      foreach ($parametros as $chave => $valor) {
        $prep->bindValue(':'.$chave, $valor);
      }

      $prep->execute();

      return array(
        'result' => 1,
        'mensagem' => 'Equipamento alterado com sucesso!'
      );

    } catch (Exception $e) {
      return array(
        'result' => 0,
        'mensagem' => 'Ocorreu um erro ao alterar o equipamento.'
      );
    }
  }

  public function buscarTipoRecursos(){
    try {
      $connect = $this->conn;
      $conn = $connect->getConexao();

      $prep = $conn->prepare('SELECT * FROM tiporecurso');

      $prep->execute();

      return $prep->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
      return null;
    }
  }

  public function buscarRecursos($termo, $res_por_pagina = 20, $pagina_atual = 1){
    try {
      $connect = $this->conn;
      $conn = $connect->getConexao();

      $prep = $conn->prepare('SELECT tab_rec.* FROM recurso tab_rec'.
      ' WHERE (tab_rec.nome LIKE? OR tab_rec.descricao LIKE?)');

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

   public function buscarPendencia($termo, $res_por_pagina = 20, $pagina_atual = 1){
    try {
      $connect = $this->conn;
      $conn = $connect->getConexao();

      $prep = $conn->prepare('SELECT *, usuario.nome as userName FROM reserva INNER JOIN usuario ON reserva.usuario = usuario.id INNER JOIN  recurso ON reserva.equipamento = recurso.id LIKE?)');

      $prep->bindValue(1, '%'.$termo.'%');

      $prep->execute();

      $res_fetch = $prep->fetchAll(PDO::FETCH_ASSOC);
      $qtd_resultados = $prep->rowCount();

      return motorBusca($res_fetch, $res_por_pagina, $pagina_atual, $qtd_resultados);

    } catch (Exception $e) {
      return null;
    }
  }
  public function excluirRecurso($id){
    try {
      $connect = $this->conn;
      $conn = $connect->getConexao();

	  $pre = $conn->prepare('SET GLOBAL FOREIGN_KEY_CHECKS=0');
      $prep = $conn->prepare('DELETE FROM recurso WHERE id=?');
	  $prep2 = $conn->prepare('DELETE FROM reserva WHERE equipamento=?');
	  $pre2 = $conn->prepare('SET GLOBAL FOREIGN_KEY_CHECKS=1');
	  
	  
	  $pre->execute();
	  
      $prep->bindValue(1, $id);
	  
	  $prep->execute();
	  
      $prep2->bindValue(1, $id);

      $prep2->execute();
	  
	  $pre2->execute();

      return array(
        'result' => 1,
        'mensagem'=> 'Equipamento excluído com sucesso!'
      );

    } catch (Exception $e) {
      return array(
        'result' => 0,
        'mensagem'=> 'Ocorreu um erro ao tentar excluir o equipamento.'
      );
    }
  }

  public function getTipoRecursoPorID($id){
    try {
      $connect = $this->conn;
      $conn = $connect->getConexao();

      $prep = $conn->prepare('SELECT * FROM tiporecurso WHERE id=? LIMIT 1');
      $prep->bindValue(1, $id);

      $prep->execute();

      return $prep->fetch(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
      return null;
    }
  }

  public function getRecursoPorID($id){
    try {
      $connect = $this->conn;
      $conn = $connect->getConexao();

      $prep = $conn->prepare('SELECT * FROM recurso WHERE id=? LIMIT 1');
      $prep->bindValue(1, $id);

      $prep->execute();

      $res_fetch = $prep->fetch(PDO::FETCH_ASSOC);

        $id_tipo_rec = $res_fetch['tipo'];
        $res_fetch['tipo'] = $this->getTipoRecursoPorID($id_tipo_rec);

        return $res_fetch;

    } catch (Exception $e) {
      return null;
    }
  }
}
