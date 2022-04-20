<h1>Compras</h1>
<?php if($edit_permission): ?>
<div class="button"><a href="<?php echo BASE_URL; ?>purchases/add">Adicionar Compra</a></div><br/><br/>
<?php endif; ?>
<table border="0" width="100%">
	<tr>
		<th>Nome do Produto</th>
		<th style="text-align:center">Data da Compra</th>
		<th style="text-align:center">Status</th>
		<th style="text-align:center">Valor</th>
		<th style="text-align:center">Ações</th>
	</tr>
	<?php foreach($purchases_list as $purchase_item): ?>
		<tr>
			<td><?php echo $purchase_item['name']; ?></td>
			<td style="text-align:center"><?php echo date('d/m/Y', strtotime($purchase_item['date_purchase'])); ?></td>
			<td style="text-align:center"><?php echo $statuses[$purchase_item['status']]; ?></td>
			<td style="text-align:center"> R$ <?php echo number_format($purchase_item['total_price'], 2, ',', '.'); ?></td>
			<td width="80">
				<div class="button button_small"><a href="<?php echo BASE_URL; ?>purchases/edit/<?php echo $purchase_item['id']; ?>">Editar</a>
				</div>
			</td>
		</tr>		
	<?php endforeach; ?>	
</table>

<!--Cria a paginação-->
<div class="pagination">
	<?php for($q=1;$q<=$pu_count;$q++): ?>

		<div class="pag_item <?php echo ($q==$p)?'pag_ativo':''; ?>"><a href="<?php echo BASE_URL; ?>purchases?p=<?php echo $q; ?>"><?php echo $q; ?></a></div>

	<?php endfor; ?>
<div class="clear:booth"></div>
</div>