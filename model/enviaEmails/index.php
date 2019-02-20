<?php
	include('../telegramNotify/telegramMessageClass.php');

	function sendSingleEmail($titulo, $emailDestinatario, $adicional, $template, $conexaoDB){
		require_once('PHPMailerAutoload.php');

		//Alocando conteúdo do template
		//$template = str_replace(array('%ASSUNTO%','%DESTINATARIO%'), array($titulo,$emailDestinatario), $template);

		$mail = new PHPMailer;

		$mail->isSMTP();
		$mail->Host = 'mail.dankhor.com.br';
		$mail->SMTPAuth = true;
		$mail->SMTPDebug  = 1;
		$mail->Username = 'alberto@dankhor.com.br';
		$mail->Password = '1q2w3e4r5t6y7';
		$mail->SMTPSecure = 'ssl';
		$mail->Port = 465;

		$mail->setFrom('alberto@dankhor.com.br','Guilherme Reinheimer');
		$mail->AddAddress($emailDestinatario,'');
		$mail->AddAddress("guilhermealberto8@gmail.com");
		
		$mail->CharSet = 'UTF-8';		
	
		$mail->isHTML(true);
		$mail->Subject = 'Envio de currículo para '.$titulo;
		$mail->Body = $template;
		$mail->AltBody = 'Falha no envio do e-mail';
		if(!$mail->send()) {
			$registrarErro = mysqli_query($conexaoDB,"INSERT INTO error_logs(quem_originou_erro,descricao_erro) VALUES ('/autoSendCurr/model/enviaEmails/index.php','". $emailDestinatario ."')");
			throw new Exception('Erro: ' . $mail->ErrorInfo);
		} else {
			echo 'Contato enviado com sucesso!';
			$jaEnviado = mysqli_query($conexaoDB,"UPDATE registro_curriculos SET jaEnviado=1 WHERE email='".$emailDestinatario."'");
			if(!$jaEnviado){
				throw new Exception("Erro ... Ao atualizar o jaEnviado");				
			}
			TelegramNotify::sendMessage('Currículo enviado para:'.$emailDestinatario);
		}

	}//fim da function
	
	header("Content-Type: text/html; charset=ISO-8859-1"); 
        //header('Content-Type: text/html; charset=UTF-8');
	$conn = mysqli_connect("localhost", "dankhorc_alberto","1q2w3e4r5t6","dankhorc_albertodev");
	$resultado = mysqli_query($conn, "SELECT * FROM registro_curriculos WHERE jaEnviado=0");

	if($resultado->num_rows <= 0){
		TelegramNotify::sendMessage('Nenhum e-mail enviado hoje');
		die("Nenhum e-mail a ser enviado");
	}

	// $templateBase = file_get_contents('../../view/templateEmail/temp3.html'); //Carregando template 'Desenvolvedor Java - temp3'
	$templateBase = file_get_contents('../../view/templateEmail/temp4.html'); //Carregando template '{Desenvolvedor: Guilherme Reinheimer}' - temp4 - versão somente com experiência'


	while($linha = $resultado->fetch_assoc()){
        
		//echo $linha['titulo']." / ".$linha['email']." / ".$linha['adicional'];

        try{
        	sendSingleEmail($linha['titulo'], $linha['email'], $linha['adicional'], $templateBase, $conn);
        }catch (Exception $ex){
        	echo $ex;
        	continue;
        }
    }

    mysqli_close($conn);
?>
