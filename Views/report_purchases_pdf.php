<style type="text/css">
th { text-align:left;  }
</style>
<h1>Relatório de Compras</h1>
<fieldset>
<?php
	if(isset($filters['user_name']) && !empty($filters['user_name'])) {
		echo "Filtrado pelo Produto: ".$filters['user_name']."<br/>";
	}
	if(!empty($filters['period1']) && !empty($filters['period2'])) {
		echo "No período: ".date('d/m/Y', strtotime($filters['period1']))." a ".date('d/m/Y', strtotime($filters['period2']))."<br/>";
	}
?>	
</fieldset>
<br/>

<table border="0" width="100%">
	<tr>
		<th style="width:300px;">Produto</th>
		<hr/>
		<th style="text-align:center;">Data</th>
		<hr/>
		<th style="text-align:center;">Status</th>
		<hr/>
		<th style="text-align:center;">Valor</th>
		<hr/>
	</tr>
	<?php foreach($purchases_list as $purchase_item): ?>
		<tr>
			<td><?php echo $purchase_item['name']; ?></td>
			<td style="text-align:center;"><?php echo date('d/m/Y', strtotime($purchase_item['date_purchase'])); ?></td>
			<td style="text-align:center;"><?php echo $statuses[$purchase_item['status']]; ?></td>
			<td style="text-align:center;"> R$ <?php echo number_format($purchase_item['total_price'], 2, ',', '.'); ?></td>
		</tr>		
	<?php endforeach; ?>	
</table>