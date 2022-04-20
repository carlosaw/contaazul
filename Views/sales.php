<h1>Vendas</h1>
<?php if($edit_permission): ?>
<div class="button"><a href="<?php echo BASE_URL; ?>sales/add">Adicionar Venda</a></div><br/><br/>	
<?php endif; ?>
<table border="0" width="100%">
	<tr>
		<th>Cliente</th>
		<th>Data</th>
		<th style="text-align:center">Status</th>
		<th width="90">Valor</th>
		<th>Ações</th>
	</tr>

	<?php foreach($sales_list as $sale_item): ?>
		<tr>
			<td><?php echo $sale_item['name']; ?></td>
			<td><?php echo date('d/m/Y', strtotime($sale_item['date_sale'])); ?></td>
			<td style="text-align:center"><?php echo $statuses[$sale_item['status']]; ?></td>
			<td>R$ <?php echo number_format($sale_item['total_price'], 2, ',', '.'); ?></td>
								
			<td>
				<div class="button button_small"><a href="<?php echo BASE_URL; ?>sales/edit/<?php echo $sale_item['id']; ?>">Editar</a>
				</div>
				<?php if(!empty($sale_item['nfe_key'])): ?>
					<div class="button button_small"><a target="_blank" href="<?php echo BASE_URL; ?>sales/view_nfe/<?php echo $sale_item['nfe_key']; ?>">Ver NF-e</a>
					</div>
				<?php else: ?>
					<div class="button button_small"><a target="_blank" href="<?php echo BASE_URL; ?>sales/generate_nfe/<?php echo $sale_item['id']; ?>">Emitir NF-e</a>
					</div>
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>

</table>

<!--Cria a paginação-->
<div class="pagination">
	<?php for($q=1;$q<=$s_count;$q++): ?>

		<div class="pag_item <?php echo ($q==$p)?'pag_ativo':''; ?>"><a href="<?php echo BASE_URL; ?>sales?p=<?php echo $q; ?>"><?php echo $q; ?></a></div>
		<!--<div class="pag_item"><?php echo $q; ?></div>-->

	<?php endfor; ?>
<div class="clear:booth"></div>
</div>