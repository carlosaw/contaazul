$('input[name=address_zipcode]').on('blur', function(){
		//console.log("SAIU DO CAMPO DE CEP");
	var cep = $(this).val();

	$.ajax({
		url:'https://api.postmon.com.br/v1/cep/'+cep,
		type:'GET',
		dataType:'json',
		success:function(json){
			console.log(json);
			if(typeof json.logradouro != 'undefined') {
				$('input[name=address]').val(json.logradouro);
				$('input[name=address_neighb]').val(json.bairro);
				$('input[name=address_city]').val(json.cidade);
				$('input[name=address_state]').val(json.estado);
				$('input[name=address_country]').val("Brasil");
				$('input[name=address_number]').focus();
			}
		}
	});

});

function changeState(obj) {
	var state = $(obj).val();//Pega estado selecionado

	$.ajax({//Pega as cidades do estado selecionado
		url:BASE_URL+'ajax/get_city_list',
		type:'GET',
		data:{state:state},
		dataType:'json',
		success:function(json) {
			var html = '';
			for(var i in json.cities) {
				html += '<option value="'+json.cities[i].CodigoMunicipio+'">'+json.cities[i].Nome+'</option>';
			}
			$('select[name=address_city]').html(html);
		}
	});
}