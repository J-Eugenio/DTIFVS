<?php

class Bug{
  private $conn;

  function __construct(){
    $this->conn = new Conexao;

    if(!isset($_SESSION)){
      session_start();
    }
  }

  public function cadastraBug($dados){
    try {
      $conn = $this->conn;
      $conec = $conn->getConexao();

      $prep = $conec->prepare('INSERT INTO bug (titulo, descricao, status, usuario) VALUES '.
      '(:titulo, :descricao, :status, :usuario)');

      foreach ($dados as $chave => $valor) {
        $prep->bindValue(':'.$chave, $valor);
      }

      $prep->bindValue(':usuario', $_SESSION['USER_ID']);

      $prep->execute();

      return array(
        'result' => 1,
        'mensagem' => 'Solicitação registrada com sucesso!'
      );

    } catch (Exception $e) {
      return array(
        'result' => 0,
        'mensagem' => 'Ocorreu um erro ao registrar a solicitação.'
      );
    }
  }

  public function buscaBug($termo){
    try {
      $conn = $this->conn;
      $conec = $conn->getConexao();

      $prep = $conec->prepare('SELECT t_bug.*, t_usu.nome AS nome_usu '.
      'FROM bug t_bug INNER JOIN usuario t_usu ON t_bug.usuario = t_usu.id '.
      'AND (t_bug.titulo LIKE? OR t_bug.descricao LIKE? or t_usu.nome LIKE?)'.
	  'AND t_bug.status = ? LIMIT 20');

      $prep->bindValue(1, '%'.$termo.'%');
      $prep->bindValue(2, '%'.$termo.'%');
      $prep->bindValue(3, '%'.$termo.'%');
      $prep->bindValue(4, 1);
	  
      $prep->execute();

      return $prep->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
      return null;
    }
  }

  public function buscaBugProfLogado($termo){
    try {
      $conn = $this->conn;
      $conec = $conn->getConexao();

      $prep = $conec->prepare('SELECT t_bug.*, t_usu.nome AS nome_usu '.
      'FROM bug t_bug INNER JOIN usuario t_usu ON t_bug.usuario = t_usu.id '.
      'AND t_bug.usuario = ? AND (t_bug.titulo LIKE? OR t_bug.descricao LIKE? or t_usu.nome LIKE?) LIMIT 20');

      $prep->bindValue(1, $_SESSION['USER_ID']);
      $prep->bindValue(2, '%'.$termo.'%');
      $prep->bindValue(3, '%'.$termo.'%');
      $prep->bindValue(4, '%'.$termo.'%');

      $prep->execute();

      return $prep->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
      return null;
    }
  }

  public function altStatusBug($id, $status){
    try {
      $conn = $this->conn;
      $conec = $conn->getConexao();

      $prep = $conec->prepare('UPDATE bug SET status=? WHERE idBug=?');

      $prep->bindValue(1, $status);
      $prep->bindValue(2, $id);

      $prep->execute();

      return array(
        'result' => 1,
        'mensagem' => 'Status de solicitação atualizada com sucesso!'
      );

    } catch (Exception $e) {
      return array(
        'result' => 0,
        'mensagem' => 'Ocorreu um erro ao atualizar o status da solicitação.'
      );
    }
  }
}
