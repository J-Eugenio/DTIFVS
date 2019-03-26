<?php

	require "./biblioteca/PHPMailer/Exception.php";
	require "./biblioteca/PHPMailer/OAuth.php";
	require "./biblioteca/PHPMailer/PHPMailer.php";
	require "./biblioteca/PHPMailer/POP3.php";
	require "./biblioteca/PHPMailer/SMTP.php";
	include_once '../../config/conexao.php';

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	$msg = $_POST['msg'];

	$salvarMSG = "INSERT INTO notificacao (msg) VALUES ('$msg')";
	mysqli_query($connect, $salvarMSG);
	class Mensagem {
		public $status = array('codigo_status' => null, 'descricao_status' => '');	
	}

	$mensagem = new Mensagem();


	$mail = new PHPMailer(true);
	try {
	    
	    
	    while($total = mysqli_fetch_row($dados)){
		    	//Server settings
		    $mail->SMTPDebug = false; 
		    $mail->isSMTP();
		    $mail->Host = 'smtp.gmail.com';                    //adicionando host gmail
		    $mail->SMTPAuth = true;                               
		    $mail->Username = 'dawngrade20.com@gmail.com';    //adicionando nome do email via smtp             
		    $mail->Password = 'Thiagoalencar1';              //adicionando senha da conta             
		    $mail->SMTPSecure = 'tls';                       //criptografia smtp  
		    $mail->Port = 587;                               //porta de comunicação     

	    	//Recipients
	    	$mail->setFrom('dawngrade20.com@gmail.com', 'Email_teste'); //remetente da mensagem MUDEM ESSE EMAIL PARA UM DO DTI
	    	$mail->addAddress($total[1]); //para quem
			//$total[0];//nome
			//$total[1];//email
			//$total[2];//equipameto
			//Content
	    	$mail->isHTML(true);                                  
	    	$mail->Subject = 'Equipamento Pendente';
	    	$mail->Body    = $msg;
	    	$mail->AltBody = 'Ncessário utilizar um cliente que suporte todo o corpo da mensagem!';

	    	$mail->send();

	    
	    	
		}

		$mensagem->status['codigo_status'] = 1;
	    $mensagem->status['descricao_status'] = 'E-mail enviado com sucesso ao professor!';
	    //Attachments
	    //$mail->addAttachment('/var/tmp/file.tar.gz');         
	    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    

	    
	   
	    echo "<script> alert('Mensagem enviada com sucesso.');window.history.back(1);</script>";
	} catch (Exception $e) {
		$mensagem->status['codigo_status'] = 2;
		$mensagem->status['descricao_status'] =  'Este e-mail não foi enviado, por favor tente novamente. Detalhes do erro: ' .  $mail->ErrorInfo;
		echo $mail->ErrorInfo."<br>";
		echo var_dump($total[1]);
	   
	}

	?>