<?php

	function emailExists($conectionDB, $email){
		$resultado = mysqli_query($conectionDB, "SELECT id FROM registro_curriculos WHERE email='". $email ."' ");

		if($resultado->num_rows != 0){
			die("Email já existente no banco");
		}

	}
	//recebe o array do JSON
	$objetoJSON = $_POST['dados'];

	//capturando data atual;
	$date = date('d/m/Y');

	//Criando conexão
	$conn = mysqli_connect("localhost", "user","pass","db");

	//verificando se o email já existe no banco
	emailExists($conn, $objetoJSON["email"]);

	//Executando query de registro
	$result = mysqli_query($conn,"INSERT INTO registro_curriculos(titulo,email,adicional,dataRegistro,jaEnviado) VALUES ('". $objetoJSON["titulo"] ."', '". $objetoJSON["email"] ."', '". $objetoJSON["adicional"] ."', '".$date."', 0) ");

	if($result){
		echo "Registro salvo";
	}else{
		echo "Registro não salvo";
	}

?>

