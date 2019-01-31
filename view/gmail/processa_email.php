<?php

	require "./biblioteca/PHPMailer/Exception.php";
	require "./biblioteca/PHPMailer/OAuth.php";
	require "./biblioteca/PHPMailer/PHPMailer.php";
	require "./biblioteca/PHPMailer/POP3.php";
	require "./biblioteca/PHPMailer/SMTP.php";

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;


	class Mensagem {
		private $para = null;
		private $assunto = null;
		private $mensagem = null;
		public $status = array('codigo_status' => null, 'descricao_status' => '');	

		public function __get($atributo) {
			return $this->$atributo;
		}

		public function __set($atributo, $valor) {
			$this->$atributo = $valor;
		}

		public function mensagemValida() {
			if(empty($this->para) || empty($this->assunto) || empty($this->mensagem)) {
				return false;
			}

			return true;
		}
	}

	$mensagem = new Mensagem();

	$mensagem->__set('para', $_POST['para']);
	$mensagem->__set('assunto', $_POST['assunto']);
	$mensagem->__set('mensagem', $_POST['mensagem']);



	if(!$mensagem->mensagemValida()) {
		echo 'Mensagem não é válida';
		header('Location: email.php');
	} 


	$mail = new PHPMailer(true);
	try {
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
	    $mail->addAddress($mensagem->__get('para')); //para quem    
	    //$mail->addAddress('ellen@example.com');               
	    //$mail->addReplyTo('info@example.com', 'Information');
	    //$mail->addCC('cc@example.com');
	    //$mail->addBCC('bcc@example.com');

	    //Attachments
	    //$mail->addAttachment('/var/tmp/file.tar.gz');         
	    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    

	    //Content
	    $mail->isHTML(true);                                  
	    $mail->Subject = $mensagem->__get('assunto');
	    $mail->Body    = $mensagem->__get('mensagem');
	    $mail->AltBody = 'Ncessário utilizar um cliente que suporte todo o corpo da mensagem!';

	    $mail->send();

	    $mensagem->status['codigo_status'] = 1;
	    $mensagem->status['descricao_status'] = 'E-mail enviado com sucesso ao professor!';
	   
	    echo "<script> alert('Mensagem enviada com sucesso.');window.history.back(1);</script>";
	} catch (Exception $e) {
		$mensagem->status['codigo_status'] = 2;
		$mensagem->status['descricao_status'] =  'Este e-mail não foi enviado, por favor tente novamente. Detalhes do erro: ' .  $mail->ErrorInfo;
	   
	}

	?>