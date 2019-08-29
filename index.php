<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<meta charset="UTF-8">
   	 	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    	<meta http-equiv="x-ua-compatible" content="ie=edge">
   		<meta name="theme-color" content="#33b5e5">
		<title>CRUD</title>
		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
		<!-- Bootstrap core CSS -->
		<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
		<!-- Material Design Bootstrap -->
		<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.2/css/mdb.min.css" rel="stylesheet">
		<!-- DataTables CSS -->
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<header>
			<div class="text-center m-2">
				<h1 style="font-weight: bold; font-size:75px; margin-bottom: 60px;"><font color="#d32f2f">C</font><font color="#388e3c">R</font><font color="#fbc02d">U</font><font color="#1976d2">D</font></h1>
			</div>
		</header>
		<?php
			//require 'src/SimpleXLSX.php';
			require 'Classes/PHPExcel.php';
		?>

		<?php
					    if(!empty($_FILES['file']['tmp_name'])){
								$file = $_FILES['file']['tmp_name'];

								$objReader = PHPExcel_IOFactory::createReader('Excel2007');
								$objReader->setReadDataOnly(true);
								$objPHPExcel = $objReader->load($file);

								$colunas = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();

								$total_colunas = PHPExcel_Cell::columnIndexFromString($colunas);

								$total_linhas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

								echo "<div class='modal fade' id='Modal3' tabindex='-1' role='dialog' aria-labelledby='Modal3' aria-hidden='true'>";
								echo		  "<div class='modal-dialog' role='document' style='max-width: 90%;'>";
								echo		    "<div class='modal-content'>";
								echo		    "<div class='modal-header text-center'>";
								echo		      "<h3 class='modal-title w-100 font-weight-bold' style='color: #388e3c;'>Tabela Pedidos</h3></br>";
								echo 	      "</div>";
								
								echo"<br><div class='table-responsive'><table id='table_panilha' class='table table-striped table-bordered dataTable' cellspacing='0' width='100%'' role='grid' aria-describedby='dtBasicExample_info' style='width: 100%; margin: auto 50px;'>";
									for($linha = 1; $linha <= $total_linhas; $linha++){
										echo "<thead><tr>";

										for($coluna=0; $coluna <= $total_colunas; $coluna++){
											if($linha == 1){
												echo "<th  scope='col'>".$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna,$linha)->getValue();
											}else{
												echo "<td scope='row'>".$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna,$linha)->getValue()."</td>";
											}

												echo "<th>".$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna,$linha)->getValue();
											}
										echo"</tr></thead>" ;

									}
								echo"</table></div>";

								echo		    "</div>";
								echo		  "</div>";
								echo		"</div>";

								
							
		?>

		<section>

			<?php 
					echo  "<div class='text-center'  style='    position: absolute; right: 85%;z-index: 10;'>";
					echo  "<a id='modal3' href='' class='float-right btn btn-green' data-toggle='modal' data-target='#Modal3'  title='Tabela Pedido'><i class='fas fa-file-excel'></i> Tabela Pedido</a>";
					echo  "</div>";
				}

			?>

			<div class="text-center">
				<a href="" class="float-right btn btn-red" data-toggle="modal" data-target="#Modal" onclick="inserirDadosCriar();" title="Criar pedido" style="right: 5%;"><i class="fas fa-plus-square"></i> </a>
			</div>

			<div class="text-center">
				<a id="modal2" href="" class="float-right btn btn-red" data-toggle="modal" data-target="#Modal2" title="Importar planilha" style="right: 5%;"> <i class="fas fa-upload"></i> </a>
			</div>

			<div class="col-md-12 table-responsive">
				
				<form action="#" method="POST">
					<input class="hidden" type="hidden" id="dados" name="dados"/>
					<table id="dtBasicExample" class="table table-striped table-bordered dataTable" cellspacing="0" width="100%" role="grid" aria-describedby="dtBasicExample_info" style="    width: 85%; margin: 10px auto;">
					  <thead>
					    <tr>
					      <th class="th-sm" scope="col">#</th>
					      <th class="th-sm" scope="col">MarketPlace</th>
					      <th class="th-sm" scope="col">Status</th>
					      <th class="th-sm" scope="col">Id Pedido</th>
					      <th class="th-sm" scope="col"></th>
					      <th class="th-sm" scope="col"></th>
					      <th class="th-sm" scope="col"></th>
					    </tr>
					  </thead>
					  <tbody id="table">
					   
					  </tbody>
					</table>
			  </form>

			  <!-- MODAL PARA CRIAR -->
			  	<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
				  aria-hidden="true">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header text-center">
				        <h4 class="modal-title w-100 font-weight-bold" style="color: #d32f2f;">Criar</h4></br>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>

				      <div class="modal-body mx-3">
				        <div class="md-form mb-5" id="divPedidos">
				          <i class="fas fas fa-store prefix grey-text"></i>
				          <input type="text" id="pedido" class="form-control validate" value="0000">
				          <label data-error="wrong" data-success="right" for="defaultForm-email">Id Pedido</label>
				        </div>

				        <div class="md-form "  id="divMarket">
				          <i class="fas fa-shopping-cart prefix grey-text"></i>
				          	<select class="browser-default custom-select form-control validate" id="market" style="margin-left: 2.5rem;width: calc(100% - 2.5rem); border: none; border-bottom: 1px solid #ced4da;">
						        <option value="" disabled>Marketplaces</option>
						        <option value="Mercado Livre">Mercado Livre</option>
						        <option value="Carrefour">Carrefour</option>
						        <option value="B2W">B2W</option>
						        <option value="Amazon">Amazon</option>
						        <option value="Shoptimão">Shoptimão</option>
						        <option value="Lojas Americanas">Lojas Americanas</option>
						        <option value="Magazine Luiza">Magazine Luiza</option>
						        <option value="Submarino">Submarino</option>
						        <option value="Shoptime">Shoptime</option>
						    </select>
				        </div>

				        <div class="md-form mb-4">
				          <i class="fas fa-percentage prefix grey-text"></i>
				          <input type="text" id="desconto" class="form-control validate" value="0.00">
				          <label data-error="wrong" data-success="right" for="defaultForm-pass">Desconto</label>
				        </div>

				        <div class="md-form mb-5">
				          <i class="fas fa-shipping-fast prefix grey-text"></i>
				          <select id="fretes" class="browser-default custom-select form-control" style="margin-left: 2.5rem;width: calc(100% - 2.5rem); border: none; border-bottom: 1px solid #ced4da;">
						        <option value="" disabled>Metodo de Entrega</option>
						        <option value="Frete">Frete</option>
						        <option value="PAC">PAC</option>
						        <option value="Sedex" selected>Sedex</option>
						        <option value="Correio">Correio</option>
						        <option value="B2W Entregas">B2W Entregas</option>
						    </select>
				        </div>

				        <div class="md-form mb-4">
				          <i class="fas fa-search prefix grey-text"></i>
				          <input type="text" id="codigo_rastreio" class="form-control validate"  value="BR01231056" id="codigo_rastreio">
				          <label data-error="wrong" data-success="right" for="defaultForm-pass">Codigo de Rastreio</label>
				        </div>

				        <div class="md-form mb-4">
				          <i class="fas fa-coins prefix grey-text"></i>
				          <input type="text" id="valor_fretes" class="form-control validate"  value="0.00" id="valor_fretes">
				          <label data-error="wrong" data-success="right" for="defaultForm-pass" >Valor do Frete</label>
				        </div>

				        <div class="md-form mb-4" id="divValorTotal">
				          <i class="fas fa-money-bill-wave prefix grey-text"></i>
				          <input type="text" id="valor_total" class="form-control validate"  value="0.00" id="valor_total">
				          <label data-error="wrong" data-success="right" for="defaultForm-pass" >Valor Total</label>
				        </div>
				      </div>
				      <div id="Modalfooter" class="modal-footer d-flex justify-content-center">
				        <button id="botaoModal" class="btn btn-red" onclick="inserir();">Criar</button>
				      </div>
				    </div>
				  </div>
				</div>

				<!-- MODAL PARA CRIAR -->
			  	<div class="modal fade" id="Modal2" tabindex="-1" role="dialog" aria-labelledby="Modal2"
				  aria-hidden="true">
				  <div class="modal-dialog" role="document" style="    max-width: 90%;">
				    <div class="modal-content">
				      <div class="modal-header text-center">
				       <h3 class="modal-title w-100 font-weight-bold" style="color: #d32f2f;">Importar Panilha</h3></br>
				      </div>
				        <form id="myForm" method="post" enctype="multipart/form-data" ajax="true">
							<div class="input-group p-4">
							  <div class="input-group-prepend">
							    <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
							  </div>
							  <div class="custom-file">
							    <input type="file" class="custom-file-input" id="inputGroupFile01"
							      aria-describedby="inputGroupFileAddon01" name="file">
							    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
							  </div>
							  	<button type="submit" href="#" id="enviar" class="input-group-text ml-1">Enviar</button>
							</div>
					    </form>
						
				    </div>
				  </div>
				</div>

			</div>
		</section>
		<!-- JQuery -->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<!-- Bootstrap tooltips -->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
		<!-- Bootstrap core JavaScript -->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
		<!-- MDB core JavaScript -->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.2/js/mdb.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

		<script type="text/javascript" src="crud.js"></script>

	</body>

	<script type="text/javascript">
		window.onload = function(){
			var dados = $('#dados').val();
			console.log(JSON.parse(dados));
			dados = JSON.parse(dados);
			var html = [];
			$.each(dados.data,function(key, value){
				console.log(value);
				html[key] = 	"<tr>";
				html[key] +=	"<tr>";
				html[key] +=  "<th scope='row'>"+key+"</th>";
				html[key] +=	 "<td>"+value.name+"</td>";
				html[key] +=	 "<td>"+value.status+"</td>";
				html[key] +=	 "<td>"+value.id_store+"</td>";
				html[key] +=	 "<td><button type='button' class='btn btn-yellow' data-toggle='modal' data-target='#Modal' onclick='inserirDadosEditar("+JSON.stringify(value)+");'  title='Atualizar'><i class='fas fa-edit'></i> Atualizar</button></td>";
				html[key] +=	 "<td><button type='button' class='btn btn-green' data-toggle='modal' data-target='#Modal' onclick='inserirDadosVisualizar("+JSON.stringify(value)+");'  title='Visualizar'><i class='fas fa-eye'></i> Visualizar</button></td>";
				html[key] +=	 "<td><button type='button' class='btn btn-blue' onclick='excluir("+value.id_order+");' title='Excluir'><i class='fas fa-trash-alt'></i> Excluir</button></td>";
				html[key] +=	 "<tr>";
				html[key] +=  "</tr>";
			});	
			$('#table').append(html);

			/*$('#inputGroupFile01').change(function (event) {
		      var tmppath = URL.createObjectURL(event.target.files[0]);
		      console.log(tmppath);

		      enviarXLSX(tmppath);
		   });

			document.getElementById('enviar').onclick = function () {
		      document.getElementById('inputGroupFile01').click();
		   };*/
		};
	</script>
</html>