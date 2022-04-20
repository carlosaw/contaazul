<h1>Estoque</h1>
<input type="text" id="busca" data-type="search_inventory" />
<?php if($add_permission): ?>
	<div class="button"><a href="<?php echo BASE_URL; ?>inventory/add">Adicionar Produto</a></div>
<?php endif; ?><br/><br/>

<table border="0" width="100%">
	<tr>
		<th>Nome</th>
		<th>Preço</th>
		<th style="text-align:center">Quant.</th>
		<th width="90">Quant. Min.</th>
		<th style="text-align:center">Ações</th>
	</tr>

	<?php foreach($inventory_list as $product): ?>
		<tr>
			<td><?php echo $product['name']; ?></td>
			<td>R$ <?php echo number_format($product['price'], 2, ',', '.'); ?></td>
			<td width="60" style="text-align:center"><?php echo $product['quant']; ?></td>
			<td style="text-align:center"><?php
				if($product['min_quant'] > $product['quant']) {
					echo '<strong><span style="color:red">'.($product['min_quant']).'</span></strong>';
				} else {
					echo $product['min_quant'];
				}
				?>		
			</td>
				
			<td width="170">
				<div class="button button_small"><a href="<?php echo BASE_URL; ?>inventory/edit/<?php echo $product['id']; ?>">Editar</a>
				</div>
				<div class="button button_small"><a href="<?php echo BASE_URL; ?>inventory/delete/<?php echo $product['id']; ?>" onclick="return confirm('Tem certeza que deseja EXCLUIR?')">Excluir</a>
				</div>
			</td>
		</tr>
	<?php endforeach; ?>
</table>

<!--Cria a paginação-->
<div class="pagination">
	<?php for($q=1;$q<=$i_count;$q++): ?>	
		<div class="pag_item <?php echo($q==$p)?'pag_ativo':''; ?>"><a href="<?php echo BASE_URL; ?>/inventory?p=<?php echo $q; ?>"><?php echo $q; ?></a></div>
	<?php endfor; ?>
<div class="clear:booth"></div>
</div>