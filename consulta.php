<?php

class Consulta{
 	
	public function conexao(){

		$user = "root"; 
		$password = ""; 
		$database = "trackcash"; 
		 
		$hostname = "localhost"; 
		 
		$conexao = mysqli_connect( $hostname, $user, $password, $database  ) or die( ' Erro na conexão ' ); 
		 
		return $conexao;
	}

	public function adicionar($_dados){

		$_bd = $this->conexao();
		
		if($_dados['loja']) $value = " loja = '".$_dados['loja']."' ";

		if($_dados['market']) $value = " marketplace = '".$_dados['market']."' ";

		if($_dados['senha']) $value2 =  ", senha = '".$_dados['senha']."' ";

		if($_dados['token']) $value3 = ", token = '".$_dados['token']."' ";

		if($_dados['usuario']) $value4 =  ", usuario =  '".$_dados['usuario']."' ";

		$_sql = "INSERT INTO user SET $value $value2 $value3 $value4 ;";

		print_r($_sql);

		$result_query = mysqli_query($_bd, $_sql) or die ( ' Erro na conexão ' );

		return $_sql;
	}

	public function token(){
		 $token = base64_encode('usuario@api.com.br:teste123');

		 return $token;
	}

	public function visualizar($_dados){

		$id_user =  $_dados['id'];

		$_bd = $this->conexao();
		
		$_sql = "SELECT id, marketplace, usuario, senha, token, loja FROM user WHERE id = {$id_user}";


		print_r($_sql);

		$result_query = mysqli_query($_bd, $_sql) or die ( ' Erro na conexão ' );

		while($row = mysqli_fetch($result_query)){
			$linha[$a] = $row[$a];

			$_consulta[$a]['id'] =  $linha[$a][0];
			$_consulta[$a]['market'] =  $linha[$a][1];
			$_consulta[$a]['usuario'] =  $linha[$a][2];
			$_consulta[$a]['senha'] =  $linha[$a][3];
			$_consulta[$a]['token'] =  $linha[$a][4];
			$_consulta[$a]['loja'] =  $linha[$a][5];

		}

		$_consulta['sql'] = $_sql;

		return $_consulta;
	}

	public function consulta_pedidos_todos(){

		$token = $this->token();

		$curl = curl_init("https://trackcash.com.br/api/orders"); 

		$headers = array( 
		"Content-Type: application/json; charset=utf-8", 
		"token: {$token}" 
		); 

		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET"); 

		curl_setopt($curl, CURLOPT_HEADER, false); 

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 

		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 

		$response = curl_exec($curl); 

		$return = json_decode($response); 

		return $return;
	}

	public function excluir_pedido($order){

		$token = $this->token();

		$curl = curl_init("https://trackcash.com.br/api/order/{$order}"); 

		$headers = array( 
		"Content-Type: application/json; charset=utf-8", 
		"token: {$token}" 
		); 

		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE"); 

		curl_setopt($curl, CURLOPT_HEADER, false); 

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 

		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 

		$response = curl_exec($curl); 

		$return = json_decode($response); 

		return $return;
	}

	public function cadastrar_pedidos($body){

		$token = $this->token();

		$curl = curl_init("https://trackcash.com.br/api/orders"); 

		$headers = array( 
		"Content-Type: application/json; charset=utf-8", 
		"token: {$token}" 
		); 

		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST"); 

		curl_setopt($curl, CURLOPT_HEADER, false); 

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 

		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 

		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body)); 

		$response = curl_exec($curl); 

		$return = json_decode($response); 

		return $return;
	}

	public function atualiza_pedidos($body){

		$token = $this->token();

		$curl = curl_init("https://trackcash.com.br/api/orders"); 

		$headers = array( 
		"Content-Type: application/json; charset=utf-8", 
		"token: {$token}" 
		); 

		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT"); 

		curl_setopt($curl, CURLOPT_HEADER, false); 

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 

		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 

		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body)); 

		$response = curl_exec($curl); 

		$return = json_decode($response); 

		return $return;
	}



}	

?>