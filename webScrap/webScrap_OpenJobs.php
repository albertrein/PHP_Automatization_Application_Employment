<?php

	include('lib/simple_html_dom.php');
	include('../model/telegramNotify/telegramMessageClass.php');

	$context = stream_context_create(
    	array(
        	"http" => array(
            	"header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
        	)
    	)
	);

	$url = 'http://openjobs.com.br';

	$pagina = file_get_contents($url, false, $context);
	$html = str_get_html($pagina);


	foreach ($html->find('h2') as $tagTitulo) {
		$tagTituloText = strtolower($tagTitulo->innertext);
		if ((strpos($tagTituloText, 'java') !== false) || (strpos($tagTituloText, 'desenvolvedor') !== false)) {
			
			foreach ($tagTitulo->find('span[class=new]') as $spanTitulo) {
				TelegramNotify::sendMessage("OpenJobs:".$tagTitulo->find('span[class=titulo-vaga]',0)->innertext);
				sleep(5);
			}

		}
	}

?>