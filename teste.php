<?php
   include_once 'config/config.php';
   include_once 'config/Conexao.class.php';
   include_once 'model/Reserva.class.php';

   $inst = new Reserva;

   $res = $inst->podeRealizarReserva('2017-10-31', '13:00', '15:30', 11);

   echo $res;
 ?>
