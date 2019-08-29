
function inserir(){

	var dados = { 
		"orders":[  
      {  
	         "id_order": $('#pedido').val(),
	         "invoice":"1574",
	         "status":"4",
	         "date":"2018-12-10",
	         "partial_total":"829.90",
	         "taxes":"0",
	         "discount":$('#desconto').val(),
	         "shipment":"B2W Entregas",
	         "shipment_value":"25.50",
	         "shipment_code":"",
	         "shipment_date":"2018-12-11",
	         "delivered":"1",
	         "paid":"855.40",
	         "refunded":"0",
	         "total":"855.40",
	         "products":[  
	            {  
	               "sku":"123",
	               "quantity":"12",
	               "selling_price":"120.22",
	               "discount":"0.22"
	            },
	            {  
	               "sku":"123456",
	               "quantity":"122",
	               "selling_price":"10.222",
	               "discount":"0.211"
	            }
	         ],
	         "point_sale":"5",
	         "point_sale_code":"268461388701"
	      },
	      {  
	         "id_order":"1416",
	         "invoice":"1575",
	         "status":"2",
	         "date":"2018-12-10",
	         "partial_total":"100.90",
	         "taxes":"0",
	         "discount":"0",
	         "shipment":$("#fretes option:selected").val(),
	         "shipment_value":$('#valor_fretes').val(),
	         "shipment_code":$('#codigo_rastreio').val(),
	         "shipment_date":"2018-12-11",
	         "delivered":"1",
	         "paid":"111.40",
	         "refunded":"0",
	         "total":"111.40",
	         "products":[  
	            {  
	               "sku":"123",
	               "quantity":"1",
	               "selling_price":"100.90",
	               "discount":"0"
	            }
	         ],
	         "point_sale":$("#market option:selected").val(),
	         "point_sale_code":"268461388702"
	      }
	   ]
	};

	/*$('#pedido').val();
	$('#desconto').val();
	$('#codigo_rastreio').val();
	$('#valor_total').val();
	$('#valor_fretes').val();
	$("#market option:selected").val();
	$("#fretes option:selected").val();*/


	json = JSON.stringify(dados);

	console.log(json);

	var id_pedido = $('#pedido').val();

	if(id_pedido == '0000' || parseInt(id_pedido) <= 0){
		Swal.fire({
		  type: 'error',
		  title: 'Oops...',
		  text: 'O id do pedido não pode ser zero, tente novamente!',
		})
	}else{
		Swal.fire({
		  type: 'success',
		  title: 'Criação de pedido com sucesso!',
		  showConfirmButton: true,
		  timer: 3000
		});

		$.ajax({
			url: 'crud.php?metodo=cadastrar_pedidos',
			type: 'GET',
			data: {val: json},
			success: function(data){
				console.log(data);
				location.reload();
			}
		});

	}
}

function editar(){

	var dados = {
		 "orders": [ 
			 { 
	         	"id_order": $('#pedido').val(),
	        	"discount":$('#desconto').val(),
	        	//"point_sale":$("#market option:selected").val(),
			 },
			 {
				"id_order": $('#pedido').val(),
	         	"shipment":$("#fretes option:selected").val(),
	         	"shipment_value":$('#valor_fretes').val(),
	         	"shipment_code":$('#codigo_rastreio').val(),
			}
		]};

		let timerInterval
		Swal.fire({
		  title: 'Atualizando..',
		  html: 'Espere <strong></strong> segundos.',
		  timer: 2000,
		  onBeforeOpen: () => {
		    Swal.showLoading()
		    timerInterval = setInterval(() => {
		      Swal.getContent().querySelector('strong')
		        .textContent = Swal.getTimerLeft()
		    }, 100)
		  },
		  onClose: () => {
		    clearInterval(timerInterval)
		  }
		}).then((result) => {

		  	json = JSON.stringify(dados);

			console.log(json);

			Swal.fire({
			  type: 'success',
			  title: 'Atualizado com sucesso!',
			  showConfirmButton: true,
			  timer: 3000
			});

			$.ajax({
				url: 'crud.php?metodo=atualizar_pedido',
				type: 'GET',
				data: {val: json},
				success: function(data){
					console.log(data);
					location.reload();
				}
			});
		})

}

function excluir(pedido){

	var dados = {};

	dados.pedido = pedido;

	json = JSON.stringify(dados);

	console.log(json);

	const swalWithBootstrapButtons = Swal.mixin({
	  customClass: {
	    confirmButton: 'btn btn-success',
	    cancelButton: 'btn btn-danger'
	  },
	  buttonsStyling: false,
	})

	swalWithBootstrapButtons.fire({
	  title: 'Você tem certeza?',
	  text: "Você pode perder tudo!",
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonText: 'Sim, deletar!',
	  cancelButtonText: 'Não, cancelar!',
	  reverseButtons: true
	}).then((result) => {
	  if (result.value) {
	    swalWithBootstrapButtons.fire(
	      'Deletado!',
	      'Seu pedido foi excluido.',
	      'success'
	    )

	    $.ajax({
			url: 'crud.php?metodo=excluir_pedido',
			type: 'GET',
			data: {val: json},
			success: function(data){
				console.log(data);
				location.reload();

			}
		});

	  } else if (
	    result.dismiss === Swal.DismissReason.cancel
	  ) {
	    swalWithBootstrapButtons.fire(
	      'Cancelado',
	      'Seu pedido está salvo! :)',
	      'error'
	    )
	  }
	})
}

function inserirDadosEditar(dados){

	console.log(dados);

	//$('#pedido').val(dados.id_order);
	$('#divPedidos').css('display','none');
	$('#desconto').val(dados.discount);
	$('#codigo_rastreio').val(dados.shipment_code);
	//$('#valor_total').val(dados.total);
	$('#divValorTotal').css('display','none');
	$('#valor_fretes').val(dados.shipment_value);
	//$("#market").val(dados.point_sale);
	$('#divMarket').css('display','none');
	$("#fretes").val(dados.shipment);

	$('input').blur();
	$('i').addClass("active");
	$('label').addClass("active");
	$('input').removeClass('valid');


	if(dados.delivered == 1)	$('#delivered').val("Entregue");
	else $('#delivered').val("A Caminho");

	$('#Modalfooter').addClass('modal-footer d-flex justify-content-center hidden');
	$('#Modalfooter').css('display', 'block');

	$('#botaoModal').text('Atualizar');
	$('#botaoModal').removeAttr('onclick');
	$('#botaoModal').attr('onclick','editar();');
	$('#botaoModal').removeClass('btn-red');
	$('#botaoModal').addClass('btn-yellow');

	$('h4').text('Atualizar');
	$('h4').css('color','#fbc02d');

}

function inserirDadosVisualizar(dados){

	console.log(dados);

	$('#divValorTotal').css('display','block');
	$('#divMarket').css('display','block');
	$('#divPedidos').css('display','block');

	$('#pedido').val(dados.id_order);
	$('#desconto').val(dados.discount);
	$('#codigo_rastreio').val(dados.shipment_code);
	$('#valor_total').val(dados.total);
	$('#valor_fretes').val(dados.shipment_value);
	$("#market").val(dados.point_sale);
	$("#fretes").val(dados.shipment);

	$('input').blur();
	$('i').addClass("active");
	$('label').addClass("active");

	$('input').attr('readonly');
	$('input').removeClass('valid');

	$('#Modalfooter').removeClass('modal-footer d-flex justify-content-center hidden');
	$('#Modalfooter').css('display', 'none');

	$('h4').text('Visualizar');
	$('h4').css('color','#388e3c');
}

function inserirDadosCriar(){


	$('#divValorTotal').css('display','block');
	$('#divMarket').css('display','block');
	$('#divPedidos').css('display','block');

	$('#pedido').val('0000');
	$('#desconto').val('0.00');
	$('#codigo_rastreio').val('BR01231056');
	$('#valor_total').val('0.00');
	$('#valor_fretes').val('0.00');
	$("#market").val('');
	$("#fretes").val('');
	
	$('input').blur();
	$('i').removeClass("active");
	$('label').addClass("active");
	$('input').removeClass('valid');

	$('#Modalfooter').addClass('modal-footer d-flex justify-content-center hidden');
	$('#Modalfooter').css('display', 'block');

	$('#botaoModal').text('Criar');
	$('#botaoModal').removeAttr('onclick');
	$('#botaoModal').attr('onclick','inserir();');
	$('#botaoModal').removeClass('btn-yellow');
	$('#botaoModal').removeClass('btn-green');
	$('#botaoModal').addClass('btn-red');

	$('h4').text('Criar');
	$('h4').css('color','rgb(211, 47, 47)');

}


function pegaAPI(){
	
	var pedidos;

	$.ajax({
		url: 'crud.php?metodo=consulta_pedidos_todos',
		type: 'GET',
		data:'',
		async: false,
		success: function(data){
			data = JSON.parse(data);
			pedidos = data;
			console.log(data);

			$('#dados').val(JSON.stringify(data));

		}
	});

	//json = JSON.stringify(pedidos);
	
	/*$.ajax({
		url: 'index.php',
		type: 'GET',
		dataType: 'json',
		//data: {val: json},
		async: false,
		success: function(data){
			console.log(data);
		}
	});*/
}

$(document).ready(function(){
	pegaAPI();
});