<?php
	include('lib/simple_html_dom.php');
	include('../model/registraDados/registraClass.php');

	$context = stream_context_create(
    	array(
        	"http" => array(
            	"header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
        	)
    	)
	);


	for($i = 1; $i <= 15; $i++){
		sleep(5);

		$pagina = file_get_contents("https://www.vagaspoa.com.br/page/".$i, false, $context);
		$html = str_get_html($pagina);

		$registraDadosExtraidos = new regitraNovosCurricos();
		
		foreach ($html->find('article') as $articleAtual) {
			$saidaTitulos = strtolower($articleAtual->find('a',0)->innertext);
			if ((strpos($saidaTitulos, 'java') !== false) || (strpos($saidaTitulos, 'desenvolvedor') !== false)) { //busca no titulo do article
				
				$email = $articleAtual->find('strong',0);
				if(strpos($email, '#008000') !== false){ //Verifica se o article está em destaque
					$email = $articleAtual->find('a',7)->innertext;			
				}else{
					$email = $articleAtual->find('strong',0)->innertext;
				}
				$saidaTitulos = str_replace("&#8211;", "", $saidaTitulos);
				$email = str_replace(" ", "", $email);

				$registraDadosExtraidos->setTituloNovoRegistro($saidaTitulos);
				$registraDadosExtraidos->setEmailNovoRegistro($email);
				$registraDadosExtraidos->insereNovoRegistro();

				// echo "Titulo:".$saidaTitulos." // E-mail:".$email;
			}
		}
	}

?>