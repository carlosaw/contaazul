$(function(){
	
	$('input[name=price]').mask('000.000.000.000.000,00', {reverse:true, placeholder:"0,00"});
	$('input[name=vFrete]').mask('000.000.000.000.000,00', {reverse:true, placeholder:"0,00"});
	$('input[name=vSeg]').mask('000.000.000.000.000,00', {reverse:true, placeholder:"0,00"});
	$('input[name=vDesc]').mask('000.000.000.000.000,00', {reverse:true, placeholder:"0,00"});
	$('input[name=pPIS]').mask('000.000.000.000.000,00', {reverse:true, placeholder:"0,00"});
	$('input[name=pCOFINS]').mask('000.000.000.000.000,00', {reverse:true, placeholder:"0,00"});
	$('input[name=pICMS]').mask('000.000.000.000.000,00', {reverse:true, placeholder:"0,00"});

});