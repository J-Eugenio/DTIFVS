<header>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <strong>Email: </strong><?php echo empty($usu_logado) ? 'Faça o login' : $usu_logado['email'];  ?>
		&nbsp;&nbsp;<strong>Telefone (FVS): 3561-2760
        &nbsp;&nbsp;
      </div>

    </div>
  </div>
</header>
<!-- HEADER END-->
<div class="navbar navbar-inverse set-radius-zero">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo URL_BASE ?>/view/usuario/pagina-usuario.php">
        <img src="../../img/logo.png"/>
      </a>
    </div>
    <div class="left-div">
      <div class="user-settings-wrapper">
        <ul class="nav text-right">

          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
              <span class="glyphicon glyphicon-user" style="font-size: 25px;"></span>
            </a>
            <div class="dropdown-menu dropdown-settings">
              <span><?php echo $usu_logado['nome'] ?></span>
              <hr/>
              <strong>Nível: </strong><span><?php echo $usu_inst->getNivelAcessoTexto(); ?></span><br/>
              <strong>Email: </strong><span><?php echo $usu_logado['email']; ?></span><br/>
              <strong>CPF: </strong><span><?php echo $usu_logado['cpf']; ?></span><br/>
              <hr/>
              <a href="<?php echo URL_BASE ?>/control/usuario-controle.php?acao=logoff" class="btn btn-danger btn-sm">
                <i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>

              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- LOGO HEADER END-->
  <section class="menu-section">
    <div class="container">
      <div class="row">
        <div class="col-md-16">
          <div class="navbar-collapse collapse ">
            <ul id="menu-top" class="nav navbar-nav navbar-left">
              <?php if($usu_inst->estaLogado()): ?>

                  <?php if($usu_inst->possuiAcessoProfessor()): ?>
				            <li><a class="menu-top-active" href="<?php echo URL_BASE ?>/view/usuario/pagina-usuario.php">
                        <i class="fa fa-home" aria-hidden="true"></i><span> Página inicial</span></a></li>
                    <li><a href="<?php echo URL_BASE ?>/view/professor/realizar-reserva.php">
                        <i class="fa fa-archive" aria-hidden="true"></i><span> Reservar Equipamento</span></a></li>
                    <li><a href="<?php echo URL_BASE ?>/view/professor/minhas-reservas.php">
                        <i class="fa fa-bars" aria-hidden="true"></i><span> Minhas Reservas</span></a></li>
					          <li><a href="<?php echo URL_BASE ?>/view/usuario/alterar-senha.php">
                        <i class="fa fa-lock" aria-hidden="true"></i><span> Alterar Senha</span></a></li>
                    <li><a href="<?php echo URL_BASE ?>/view/usuario/suporte.php">
                        <i class="fa fa-lock" aria-hidden="true"></i><span> Suporte de equipamentos</span></a></li>
                      <?php endif;
                      if($usu_inst->possuiAcessoAdm()):
                        ?>
										<li><a class="menu-top-active" href="<?php echo URL_BASE ?>/view/usuario/pagina-usuario.php">
                        <i class="fa fa-home" aria-hidden="true"></i><span> Página inicial</span></a></li>
                    <li><a href="<?php echo URL_BASE ?>/view/administrador/reservas-dia.php">
                        <i class="fa fa-calendar" aria-hidden="true"></i><span> Reservas para hoje</span></a></li>
						        <li><a href="<?php echo URL_BASE ?>/view/administrador/buscar-usuarios.php">
						            <i class="fa fa-users" aria-hidden="true"></i><span> Usuários</span></a></li>
                    <li><a href="<?php echo URL_BASE ?>/view/administrador/buscar-equipamento.php">
                        <i class="fa fa-search" aria-hidden="true"></i><span> Buscar Equipamentos</span></a></li>
                    <li><a href="<?php echo URL_BASE ?>/view/administrador/formulario-equipamento.php">
                        <i class="fa fa-plus" aria-hidden="true"></i><span> Cadastrar Equipamento</span></a></li>
                    <li><a href="<?php echo URL_BASE ?>/view/administrador/relatorio.php">
                        <i class="fa fa-plus" aria-hidden="true"></i><span> Relatorio</span></a></li>
                    <li><a href="<?php echo URL_BASE ?>/view/gmail/email.php"> 
                        <i class="fa fa-plus" aria-hidden="true"></i><span> Notificações</span></a></li>   
                          <?php endif; ?>

                          <li><a href="<?php echo URL_BASE ?>/control/usuario-controle.php?acao=logoff">
                            <i class="fa fa-sign-out" aria-hidden="true"></i><span> Sair</span></a></li>

                          <?php endif; ?>
                        </ul>
                      </div>
                    </div>

                  </div>
                </div>
              </section>
