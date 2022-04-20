<h1>Compras - Adicionar</h1>

<?php if(isset($error_msg) && !empty($error_msg)): ?>
	<div class="warn"><?php echo $error_msg; ?></div>
<?php endif; ?>

<form method="POST">
	<label for="user_name">Nome do Usuário</label><br/>
	<input type="hidden" name="user_id" />
	<input type="text" name="user_name" id="user_name" data-type="search_users"/>
	<br/><br/><br/>

	<label for="total_price">Preço da Compra</label>
	<input type="text" name="total_price" id="total_price" disabled="disabled" /><br/><br/>

	<label for="status">Status da Venda</label><br/>
	<select name="status" id="status">
		<option value="0">Aguardando Pgto.</option>
		<option value="1">Pago</option>
		<option value="2">Cancelado</option>
	</select><br/><br/><br/>
	<hr/><br/>

	<a href="<?php echo BASE_URL; ?>inventory/add"><input type="button" value="Cadastrar Produto" class="button_small" /></a><br/><br/>

	<fieldset>
		<legend>Produtos Cadastrados</legend>
		<input type="text" name="add_prod" id="add_prod" data-type="search_products" />
				
	</fieldset><br/>

	<table border="0" width="100%" id="products_table">
		<tr>
			<th>Nome do Produto</th>
			<th>Quantidade</th>
			<th>Preço Unit.</th>
			<th>Sub-Total</th>
			<th>Excluir</th>
		</tr>
	</table>

	<hr/>

	<input type="submit" value="Adicionar Compra" />
</form>

<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery.mask.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/script_purchases_add.js"></script>