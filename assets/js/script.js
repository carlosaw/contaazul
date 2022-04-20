$(function(){

	$('.tabitem').on('click', function(){
		//Remove a classe activetab
		$('.activetab').removeClass('activetab');//Remove todas as tabs
		$(this).addClass('activetab');//seleciona no click

		var item = $('.activetab').index();//index da classe
		$('.tabbody').hide();//esconde conteudo
		$('.tabbody').eq(item).show();//mostra conteudo

	});
	//$('.tabbody').eq(0).show(); //ou style="display-block" no view permissions.php
	// Animação no campo de buscas
	$('#busca').on('focus', function(){//Aumenta o campo de busca.
		$(this).animate({
			width:'250px'
		}, 'fast');// aumenta velocidade
	});
	$('#busca').on('blur', function(){//Volta ao normal o campo de busca.
		if($(this).val() == '') {//Verifica se tem escrita no campo volta
			$(this).animate({
				width:'100px'
			}, 'fast');
		}
		setTimeout(function(){//Delay para poder clicar search
			$('.searchresults').hide();
		}, 500);
		
	});

	// Campo de Busca
	$('#busca').on('keyup', function(){//Quando tira o mouse
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
						$('#busca').after('<div class="searchresults"></div>');
					}

					$('.searchresults').css('left', $('#busca').offset().left+'px');
					$('.searchresults').css('top', $('#busca').offset().top+$('#busca').height()+'px');

					var html = '';//Mostra os resultados na div search.

					for(var i in json) {
						html += '<div class="si"><a href="'+json[i].link+'" >'+json[i].name+'</a></div>';
					}

					$('.searchresults').html(html);
					$('.searchresults').show();
				}
			});
		}
	});
});