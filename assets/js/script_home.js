var rel1 = new Chart(document.getElementById("rel1"), {// Classe do Carth.js
	type:'line', // Tipo de Gráfico 'Line=Linhas, bar=Barras.
	data:{ // Dados
		labels:days_list, // Itens da Horizontal
		datasets:[{ // Itens da Vertical
			label:'Receita',
			data:revenue_list,
			fill:false,
			backgroundColor:'#0000FF',
			borderColor:'#0000FF'
		},
		{
			label:'Despesas',
			data:expenses_list,
			fill:false,
			backgroundColor:'#FF0000',
			borderColor:'#FF0000'
		}] 
	}
});

var rel2 = new Chart(document.getElementById("rel2"), {// Classe do Carth.js
	type:'pie', // Tipo de Gráfico 'Line=Linhas, bar=Barras.
	data:{ // Dados
		labels:status_name_list, // Itens da Horizontal
		datasets: [{
			data:status_list,
			backgroundColor:['#FFCE56', '#36A2EB', '#FF6384']
		}] 
	}
});