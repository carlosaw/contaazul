function selectClient(obj) {
	var id = $(obj).attr('data-id');
	var name = $(obj).html();

	$('.searchresults').hide();
	$('#client_name').val(name);
	$('input[name=client_id]').val(id);
}
function updateSubTotal(obj) {
	var quant = $(obj).val();
	if(quant <= 0) {
		$(obj).val(1);
		quant = 1;
	}
	var price = $(obj).attr('data-price');
	var subtotal = price * quant;

	//volta para tr e procura subtotal e mostra ele.
	$(obj).closest('tr').find('.subtotal').html('R$ '+subtotal);

	updateTotal();
}
function updateTotal() {
	var total = 0;
	for(var q=0;q<$('.p_quant').length;q++) {
		var quant = $('.p_quant').eq(q);
		var price = quant.attr('data-price');
		var subtotal = price * parseInt(quant.val());
		total += subtotal;
	}
	$('input[name=total_price]').val(total);
}

function excluirProd(obj) {
	$(obj).closest('tr').remove();
	updateTotal();
}

function addProd(obj) {
	$('#add_prod').val('');
	var id = $(obj).attr('data-id');
	var name = $(obj).attr('data-name');
	var price = $(obj).attr('data-price');

	$('.searchresults').hide();
	
	if( $('input[name="quant['+id+']"]').length == 0 ) {
		var tr = 
		'<tr>'+
			'<td>'+name+'</td>'+
			'<td>'+
				/*'<a href="javascript:;"><img src="'+BASE_URL+'assets/images/less.png'+'" border="0" width="20" /></a>'+*/
				'<input type="number" name="quant['+id+']" class="p_quant" value="1" onchange="updateSubTotal(this)" data-price="'+price+'" />'+
				/*'<a href="javascript:;"><img src="'+BASE_URL+'assets/images/more.png'+'" border="0" width="20" /></a>'+*/
			'</td>'+
			'<td>R$ '+price+'</td>'+
			'<td class="subtotal">R$ '+price+'</td>'+
			'<td>'+
				'<a href="javascript:;" onclick="excluirProd(this)">Excluir</a>'+
			'</td>'+
		'</tr>';

		$('#products_table').append(tr);
	} else {
		alert("Este produto já está adicionado, aumente a quantidade");
	}
	updateTotal();
}

$(function(){

	$('input[name=total_price]').mask('000.000.000.000.000,00', {reverse:true, placeholder:"0,00"});

	$('.client_add_button').on('click', function(e){
		e.preventDefault();
		var name = $('#client_name').val();

		if(name != '' && name.length >= 4) {
			if(confirm('Voce deseja adicionar um cliente com nome: '+name+' ?')) {
				alert("Adiconando cliente: "+name);
				$.ajax({
					url:BASE_URL+'ajax/add_client',
					type:'POST',
					data:{name:name},
					dataType:'json',
					success:function(json) {
						$('.searchresults').hide();
						$('input[name=client_id]').val(json.id);
					}
				});
				return false;
			}
		}
	});	

	$('#client_name').on('keyup', function(){//Quando tira o mouse
		var datatype = $(this).attr('data-type');
		var q = $(this).val();

		if(datatype != '') {
			$.ajax({
				url:BASE_URL+'ajax/'+datatype,
				type:'GET',
				data:{q:q},
				dataType:'json',
				success:function(json) {
					if( $('.searchresults').length == 0 ) {//Se div não existir, cria.
						$('#client_name').after('<div class="searchresults"></div>');
					}

					$('.searchresults').css('left', $('#client_name').offset().left+'px');
					$('.searchresults').css('top', $('#client_name').offset().top+$('#client_name').height()+'px');
					//$('.searchresults').show();

					var html = '';//Mostra os resultados na div search.

					for(var i in json) {

						html += '<div class="si"><a href="javascript:;" onclick="selectClient(this)" data-id="'+json[i].id+'">'+json[i].name+'</a></div>';
					}

					$('.searchresults').html(html);
					$('.searchresults').show();
				}
			});
		}
	});

	$('#add_prod').on('keyup', function(){//Quando tira o mouse
		var datatype = $(this).attr('data-type');
		var q = $(this).val();

		if(datatype != '') {
			$.ajax({
				url:BASE_URL+'ajax/'+datatype,
				type:'GET',
				data:{q:q},
				dataType:'json',
				success:function(json) {
					if( $('.searchresults').length == 0 ) {//Se div não existir, cria.
						$('#add_prod').after('<div class="searchresults"></div>');
					}

					$('.searchresults').css('left', $('#add_prod').offset().left+'px');
					$('.searchresults').css('top', $('#add_prod').offset().top+$('#add_prod').height()+'px');
					//$('.searchresults').show();

					var html = '';//Mostra os resultados na div search.

					for(var i in json) {

						html += '<div class="si"><a href="javascript:;" onclick="addProd(this)" data-id="'+json[i].id+'" data-price="'+json[i].price+'" data-name="'+json[i].name+'">'+json[i].name+' - R$ '+json[i].price+'</a></div>';
					}

					$('.searchresults').html(html);
					$('.searchresults').show();
				}
			});
		}
	});
});