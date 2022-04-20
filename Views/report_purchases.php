<h1>Relatório de Compras</h1>
<form method="GET" onsubmit="return openPopup(this)">
	<div class="report-grid-4">
		Produto:<br/>
		<input type="text" name="user_name" />
	</div>
	<div class="report-grid-4">
		Período:<br/>
		<input type="date" name="period1" /><br/>
		Até:<br/>
		<input type="date" name="period2" /><br/>		
	</div>
	
	<div class="report-grid-4">
		Status da Compra:<br/>
		<select name="status">
			<option value="">Todos os status</option>
			<?php foreach($statuses as $statusKey => $statusValue): ?>
				<option value="<?php echo $statusKey; ?>"><?php echo $statusValue; ?></option>	
			<?php endforeach; ?>
		</select>
	</div>

	<div class="report-grid-4">
		Ordenação:<br/>
		<select name="order">
			<option value="date_desc">Mais Recente</option>
			<option value="date_asc">Mais Antigo</option>
			<option value="status">Status da Venda</option>
		</select>
	</div>

	<div style="clear:both"></div>

	<div style="text-align:center">
		<input type="submit" value="Gerar Relatório" />
	</div>
	
</form>

<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/report_purchases.js"></script>