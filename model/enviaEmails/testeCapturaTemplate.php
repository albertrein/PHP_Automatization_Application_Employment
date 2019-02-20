<?php
    /*
        * Testando templates
    */

    	//Carregando template para teste
    	
    		$template = file_get_contents('../../view/templateEmail/temp4.html');
    		if($template == false){
    			die("Não foi possível abrir o arquivo");
    		}


    	require_once('PHPMailerAutoload.php');

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
		//$mail->AddAddress($emailDestinatario,'');
		$mail->AddAddress("guilhermealberto8@gmail.com");
		
		$mail->CharSet = 'UTF-8';		
	
		$mail->isHTML(true);
		$mail->Subject = 'Testando templates .::.';
		$mail->Body = $template;
		$mail->AltBody = 'Falha no envio do e-mail';
		if(!$mail->send()) {
			throw new Exception('Erro: ' . $mail->ErrorInfo);
		} else {
			echo 'Contato enviado com sucesso!';			
		}


?>