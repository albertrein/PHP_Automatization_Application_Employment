<?php
	/*
	*	Classe para registro de novos curriculos na base de dados
	*	Envia o titulo e o email para registro
	*/
	class regitraNovosCurricos{
		public $tituloNovoRegistro = '';
		public $emailNovoRegistro = '';
		
		
		public function getTitulo(){
			return $this->tituloNovoRegistro;
		}

		public function setTituloNovoRegistro($setTitulo){
			$this->tituloNovoRegistro = $setTitulo;
		}

		public function setEmailNovoRegistro($setEmail){
			$this->emailNovoRegistro = $setEmail;
		}

		public function getEmailNovoRegistro(){
			return $this->emailNovoRegistro;
		}

		public function insereNovoRegistro(){
			//capturando data atual;
			$date = date('d/m/Y');

			//Criando conexão
			$conn = mysqli_connect("localhost", "user","pass","db");

			//verificando se o email já existe no banco
			if($this->emailExists($conn, $this->emailNovoRegistro) != 0){
				echo "Email já existente no banco";
				return 1;
			}

			//Executando query de registro
			$result = mysqli_query($conn,"INSERT INTO registro_curriculos(titulo,email,adicional,dataRegistro,jaEnviado) VALUES ('". $this->tituloNovoRegistro ."', '". $this->emailNovoRegistro ."', 'NULL', '".$date."', 0) ");

			if($result){
				echo "Registro salvo";
			}else{
				echo "Registro não salvo";
			}
		}

		private function emailExists($conectionDB, $email){
			$resultado = mysqli_query($conectionDB, "SELECT id FROM registro_curriculos WHERE email='". $email ."' ");
			return $resultado->num_rows;
		}

	}	

?>