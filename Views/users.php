<h1>Usuários</h1>

<div class="button"><a href="<?php echo BASE_URL; ?>users/add">Adicionar Usuário</a></div><br/><br/>

		<table border="0" width="100%">
			<tr>
				<th>Nome</th>
				<th>E-mail</th>
				<th>Grupo de permissões</th>
				<th style="text-align:center">Ações</th>
			</tr>
			<?php foreach($users_list as $us): ?>
				<tr>
					<td><?php echo $us['name']; ?></td>
					<td><?php echo $us['email']; ?></td>
					<td width="180"><?php echo $us['gname']; ?></td>
					<td width="170">
						<div class="button button_small"><a href="<?php echo BASE_URL; ?>users/edit/<?php echo $us['id']; ?>">Editar</a>
						</div>
						<div class="button button_small"><a href="<?php echo BASE_URL; ?>users/delete/<?php echo $us['id']; ?>" onclick="return confirm('Tem certeza que deseja EXCLUIR?')">Excluir</a>
						</div>
					</td>
				</tr>

			<?php endforeach; ?>
		</table>