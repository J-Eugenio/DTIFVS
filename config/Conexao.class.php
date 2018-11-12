<?php

class Conexao{
  public function getConexao(){
    $link = new PDO('mysql:host='.DATABASE_HOST.';dbname='.DATABASE_NAME.';charset='.DATABASE_CHARSET,
    DATABASE_USERNAME,
    DATABASE_PASSWORD);
    return $link;
  }
}

function motorBusca($res_fetch, $res_por_pagina = 20, $pagina_atual = 1, $qtd_resultados){
  if($pagina_atual < 0){
    $pagina_atual = 1;
  }

  $pagina_atual = empty($pagina_atual) ? 1 : $pagina_atual;
  $comeco_res = ($pagina_atual-1) * $res_por_pagina;

  $res_slice = array_slice($res_fetch, $comeco_res, $res_por_pagina);
  $limites_pagina = ceil($qtd_resultados/$res_por_pagina);

  $limites_pagina = $limites_pagina == 0 ? 1 : $limites_pagina;

  return array(
    'qtd_resultados' => $qtd_resultados,
    'resultados' => $res_slice,
    'primeira_pag' => $pagina_atual == 1,
    'ultima_pag' => $qtd_resultados <= $comeco_res+$res_por_pagina,
    'pagina_atual' => $pagina_atual,
    'limites_pagina' => $limites_pagina
  );
}
