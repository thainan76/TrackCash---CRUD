<?php
	
	require_once("consulta.php");

	$consulta = new Consulta();

	if($_GET['metodo'] == "adicionar"){

		$obj = json_decode($_GET['val']);

		$_dados['loja'] = $obj->loja;
		$_dados['market'] = $obj->marketplace;
		$_dados['senha'] = $obj->senha;
		$_dados['token'] = $obj->token;
		$_dados['usuario'] = $obj->usuario;

		$retorno = $consulta->adicionar($_dados);

		return json_encode((Object)$retorno);
	}

	if($_GET['metodo'] == "consulta_pedidos_todos"){

		$retorno = $consulta->consulta_pedidos_todos();

		echo json_encode((Object)$retorno);

		return json_encode((Object)$retorno);
	}

	if($_GET['metodo'] == "atualizar_pedido"){

		$obj = json_decode($_GET['val']);

		$retorno = $consulta->atualiza_pedidos($obj);

		echo json_encode((Object)$retorno);

		return json_encode((Object)$retorno);
	}

	if($_GET['metodo'] == "excluir_pedido"){

		$obj = json_decode($_GET['val']);

		$order = $obj->pedido;
		
		$retorno = $consulta->excluir_pedido($order);

		echo json_encode((Object)$retorno);

		return json_encode((Object)$retorno);
	}

	if($_GET['metodo'] == "cadastrar_pedidos"){

		$obj = json_decode($_GET['val']);

		//$order = $obj->pedido;
		
		$retorno = $consulta->cadastrar_pedidos($obj);

		echo json_encode((Object)$retorno);

		return json_encode((Object)$retorno);
	}

?>