<?php

	# Substitua abaixo os dados, de acordo com o banco criado
	$user = "root"; 
	$password = ""; 
	$database = "trackcash"; 
	 
	# O hostname deve ser sempre localhost 
	public $hostname = "localhost"; 
	 
		 
	# Conecta com o servidor de banco de dados 
	mysql_connect( $hostname, $user, $password ) or die( ' Erro na conexão ' ); 
	 
	# Seleciona o banco de dados 
	mysql_select_db( $database ) or die( 'Erro na seleção do banco' );

?>