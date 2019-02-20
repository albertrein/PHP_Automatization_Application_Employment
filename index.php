<?php
	if(isset($_POST['dados'])){
		include('model/registraDados/registraClass.php');
		$registraDadosExtraidos = new regitraNovosCurricos();
		$registraDadosExtraidos->setTituloNovoRegistro($_POST['dados']["titulo"]);
		$registraDadosExtraidos->setEmailNovoRegistro($_POST['dados']["email"]);
		$registraDadosExtraidos->insereNovoRegistro();
		exit(0);	
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Registro de novas vagas</title>
	<style type="text/css"></style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<style type="text/css">
		.content{
			padding: 50px 40px;
			background: #fff;
			width: 50%;
			text-align: center;
			-webkit-box-shadow: 0 2px 3px rgba(0,0,0,0.2);
			-moz-box-shadow: 0 2px 3px rgba(0,0,0,0.2);
			box-shadow: 0 2px 3px rgba(0,0,0,0.2);
			margin: 0 auto;			
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
		}
		.content input{
			font-size: 3em;
    		margin: 34px;
		}

		.content input.tt{
			text-transform: lowercase;
		}

		.content textarea{
			font-size: 2em;
			margin: 54px;
		}

		button{
			display: block;
			width: 100%;
			height: 83px;
		}
	</style>
</head>
<body>
	<div class="content">
		<form class="formulario" action="#" method="post">
			<input class="tt" type="text" name="titulo" placeholder="Título da vaga:" required="">
			<input class="t1" type="email" name="email" placeholder="E-mail do destinatário:" required="">
			<textarea class="t3" hy placeholder="Adicionais:" cols="50" name="adicional" hidden></textarea>
			<button type="submit" class="save">Envia dados</button>
		</form>		
	</div>

<script type="text/javascript">
	/*let formularioToEnterClick = document.querySelector('.content').addEventListener("keyup", function(event) {
	  	event.preventDefault();
	  	if (event.keyCode === 13) {
	    	document.querySelector(".save").click();
	  	}
	});*/

	let formulario = document.querySelector('.formulario').addEventListener("submit", function(e){
		e.preventDefault();
		let parserJSON = parseInputsToJson(e);

		//Enviando objeto JSON para PHP
		 $.ajax({
              type: 'POST',
              url: 'index.php',
              data: {
                  'dados':parserJSON,
              },
              success: function(data) {
                console.log("Registro response:",data);
                document.querySelector('.tt').value = "";
                document.querySelector('.t1').value = "";
              }
            });
	});

	function parseInputsToJson(entradas){
		objetoJSON = {};
		for(let itemAtual of entradas.target.children){
			objetoJSON[itemAtual.name] = itemAtual.value;
		}
		return objetoJSON;
	}
</script>

</body>
</html>