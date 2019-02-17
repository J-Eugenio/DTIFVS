<?php
include_once '../../config/config.php';
include_once '../../config/Conexao.class.php';
include_once '../../config/conexao.php';
include_once '../../model/Usuario.class.php';


$usu_inst = new Usuario;
$usu_inst->redirecNaoAdm();
$usu_logado = $usu_inst->getUsuarioLogado();
$pagindice = isset($_GET['pagindice']) ? $_GET['pagindice'] : 1;
//referenciar o DomPDF com namespace
use Dompdf\Dompdf;

// include autoloader
$query = 0;
    if($_POST['filtro'] != 0):
        $data = $_POST['filtro'];
        $query = "SELECT *, usuario.nome as userName FROM reserva INNER JOIN usuario ON reserva.usuario = usuario.id INNER JOIN  recurso ON reserva.equipamento = recurso.id WHERE data LIKE '$data%'";
    else:
        $query = "SELECT *, usuario.nome as userName FROM reserva INNER JOIN usuario ON reserva.usuario = usuario.id INNER JOIN  recurso ON reserva.equipamento = recurso.id";
    endif;
require_once("dompdf/autoload.inc.php");
    $html = '<table border=1px solid black';  
    $html .= '<thead>';
    $html .= '<tr>';
    $html .= '<th scope="col">Nome</th>';
    $html .= '<th scope="col">Equipamento</th>';
    $html .= '<th scope="col">Data da entrega</th>';
    $html .= '<th scope="col">Hora da entrega</th>';
    $html .= '<th scope="col">Campus</th>';
    $html .= '<th scope="col">Sala</th>';
    $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';

        $lista_equips = mysqli_query($connect, $query);
foreach ($lista_equips as $equip_row):
    if($equip_row['entregue'] == 1 && $equip_row['devolucao'] == 0):
        $html .= '<tr><td>'.$equip_row['userName']. "</td>";
        $html .= '<td>'.$equip_row['nome']. "</td>";
        $html .= '<td>'.$equip_row['data']. "</td>";
        $html .= '<td>'.$equip_row['horaentregue']. "</td>";
        $html .= '<td>'.$equip_row['campus']. "</td>";
        $html .= '<td>'.$equip_row['sala']. "</td></tr>";
    endif;
endforeach;

//Criando a Instancia
    $dompdf = new DOMPDF();
    // Carrega seu HTML
    $dompdf->load_html('<h1 style="text-align: center;">Relatório de Reservas</h1>'.$html.'');
    //Renderizar o html
    $dompdf->render();

    //Exibibir a página
    $dompdf->stream("relatorio.pdf", 
    array("Attachment" => false //Para realizar o download somente alterar para true
    ));
    
?>
