<?php

class Usuario{
  private $connect;

  function __construct(){
    $this->connect = new Conexao();

    if(!isset($_SESSION)){
      session_start();
    }
  }
  public function logar($login, $senha){
    try {
      $connect = $this->connect;
      $conn = $connect->getConexao();

      $prep = $conn->prepare('SELECT id, nivel, senha FROM usuario WHERE (email = ? OR login = ?) AND senha = ? LIMIT 1');
      $prep->bindValue(1, $login);
      $prep->bindValue(2, $login);
      $prep->bindValue(3, $senha);

      $prep->execute();

      if($prep->rowCount() == 1){
        $usuario = $prep->fetch(PDO::FETCH_ASSOC);

        $_SESSION['USER_ID'] = $usuario['id'];
        $_SESSION['USER_NIVEL'] = $usuario['nivel'];

		if($usuario['senha'] == "professor123" || $usuario['senha'] == "fvs123"){
		return array(
          'result' => 2,
          'mensagem' => 'Login efetuado com sucesso!'
        );
		}
		else {
        return array(
          'result' => 1,
          'mensagem' => 'Login efetuado com sucesso!'
        );
		}
      }else{
        return array(
          'result' => 0,
          'mensagem' => 'Usuário ou senha incorretos.'
        );
      }
    } catch (Exception $e) {
      return array(
        'result' => 0,
        'mensagem' => 'Ocorreu um erro ao realizar o login.'
      );
    }

  }

  public function logoff(){
    session_destroy();
  }
  
  public function cadastrar($login, $senha, $nome, $cpf, $email, $nivel){
    try {
      $connect = $this->connect;
      $conn = $connect->getConexao();

      $prep = $conn->prepare('INSERT INTO usuario(login,senha,nome,cpf,email,nivel) VALUES (?,?,?,?,?,?)');
      $prep->bindValue(1, $login);
	  $prep->bindValue(2, $senha);
	  $prep->bindValue(3, $nome);
	  $prep->bindValue(4, $cpf);
	  $prep->bindValue(5, $email);
	  $prep->bindValue(6, $nivel);

      $prep->execute();

       return array(
          'result' => 1,
          'mensagem' => 'Cadastro de Usuário efetuado com sucesso!'
        );
    } catch (Exception $e) {
      return array(
          'result' => 0,
          'mensagem' => 'Ocorreu um problema ao cadastrar o usuário.'
        );
    }
  }
  
    public function alterarUsuario($login, $senha, $nome, $cpf, $email){
    try {
      $connect = $this->connect;
      $conn = $connect->getConexao();

	  $prep = $conn->prepare('UPDATE usuario SET senha=?,nome=?,cpf=?,email=? WHERE login=?');
	  
	  $prep->bindValue(1, $senha);
	  $prep->bindValue(2, $nome);
	  $prep->bindValue(3, $cpf);
	  $prep->bindValue(4, $email);
	  $prep->bindValue(5, $login);
	  
      $prep->execute();

       return array(
          'result' => 1,
          'mensagem' => 'Usuário atualizado com sucesso!'
        );
    } catch (Exception $e) {
      return array(
          'result' => 0,
          'mensagem' => 'Ocorreu um problema ao atualizar o usuário.'.$login.''
        );
    }
  }
  
    public function excluirUsuario($id){
    try {
      $connect = $this->connect;
      $conn = $connect->getConexao();

      $pre = $conn->prepare('DELETE FROM usuario WHERE id=?');
	  
      $pre->bindValue(1, $id);
	  $pre->execute();

      return array(
        'result' => 1,
        'mensagem'=> 'Usuário excluído com sucesso!'
      );

    } catch (Exception $e) {
      return array(
        'result' => 0,
        'mensagem'=> 'Ocorreu um erro ao tentar excluir o equipamento.'
      );
    }
  }
  
  public function buscarUsuarios($termo, $res_por_pagina = 20, $pagina_atual = 1){
    try {
      $connect = $this->connect;
      $conn = $connect->getConexao();

      $prep = $conn->prepare('SELECT tab_usu.* FROM usuario tab_usu'.
      ' WHERE ((tab_usu.nome LIKE? OR tab_usu.login LIKE? OR tab_usu.email LIKE? OR tab_usu.cpf LIKE?) AND tab_usu.nivel >?)');

      $prep->bindValue(1, '%'.$termo.'%');
      $prep->bindValue(2, '%'.$termo.'%');
	  $prep->bindValue(3, '%'.$termo.'%');
	  $prep->bindValue(4, '%'.$termo.'%');
	  $prep->bindValue(5, 1);

      $prep->execute();

      $res_fetch = $prep->fetchAll(PDO::FETCH_ASSOC);
      $qtd_resultados = $prep->rowCount();

      return motorBusca($res_fetch, $res_por_pagina, $pagina_atual, $qtd_resultados);

    } catch (Exception $e) {
      return null;
    }
  }
  
  
  public function alterar($id, $senha2){
    try {
      $connect = $this->connect;
      $conn = $connect->getConexao();

      $prep = $conn->prepare('UPDATE usuario SET usuario.senha=? WHERE usuario.id=?');
	  $prep->bindValue(1, $senha2);
	  $prep->bindValue(2, $id);

      $prep->execute();

       return array(
          'result' => 1,
          'mensagem' => 'Usuário atualizado com sucesso!'
        );
    } catch (Exception $e) {
      return array(
          'result' => 0,
          'mensagem' => 'Ocorreu um problema ao atualizar o usuário.'
        );
    }
  }
  
  public function getUsuarioPorId($id){
    try {
      $connect = $this->connect;
      $conn = $connect->getConexao();

      $prep = $conn->prepare('SELECT login,senha,email,nome,cpf FROM usuario WHERE id=? LIMIT 1');
      $prep->bindValue(1, $id);

      $prep->execute();

      return $prep->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      return null;
    }
  }
  
  public function getUsuarios(){
    try {
      $connect = $this->connect;
      $conn = $connect->getConexao();

      $prep = $conn->prepare('SELECT * FROM usuario');

      $prep->execute();

      return $prep->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      return null;
    }
  }

  public function estaLogado(){
    return isset($_SESSION['USER_ID']);
  }

  public function possuiAcessoProfessor(){
    return $this->estaLogado() && $_SESSION['USER_NIVEL'] == 2;
  }

  public function possuiAcessoAdm(){
    return $this->estaLogado() && $_SESSION['USER_NIVEL'] == 1;
  }

  public function getUsuarioLogado(){
    return $this->getUsuarioPorId($_SESSION['USER_ID']);
  }

  public function redirecNaoLogado(){
    if(!$this->estaLogado()){
      header('Location:'.URL_BASE.'/view/public/login.php');
    }
  }

  public function redirecLogado(){
    if($this->estaLogado()){
      header('Location: '.URL_BASE.'/view/usuario/pagina-usuario.php');
    }
  }

  public function redirecNaoProfessor(){
    if(!$this->possuiAcessoProfessor()){
      header('Location:'.URL_BASE.'/view/public/login.php');
    }
  }

  public function redirecNaoAdm(){
    if(!$this->possuiAcessoAdm()){
      header('Location:'.URL_BASE.'/view/public/login.php');
    }
  }

  public function getNivelAcessoTexto(){
    switch ($_SESSION['USER_NIVEL']) {
      case 1:
      return 'Administrador';
      break;
      case 2:
      return 'Professor';
      break;
      default:
      return 'Usuário';
      break;
    }
  }

  public function getIDUsuarioLogado(){
    return $_SESSION['USER_ID'];
  }
}
