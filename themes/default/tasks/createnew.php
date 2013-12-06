<?php
/* Tasklist Addon
 * Created and maintained by Akkarin
 * Current Version: 1.00.04
 */
 
if (!defined('FLUX_ROOT')) exit;

?>
<h2><?php echo htmlspecialchars(Flux::message('TaskListAdd')) ?></h2>
<form action="<?php echo $this->urlWithQs ?>" method="post">
	<table class="vertical-table" width="70%">
		<tr>
			<th>Nome da Tarefa</th>
			<td><input type="text" name="title" id="title" /></td>
		</tr>
		<tr>
			<th>URL de Referência</th>
			<td><input type="text" name="link" id="link" /> Lista separada de URLs com vírgulas (,)</td>
		</tr>
		<tr>
			<th>Atribuir à</th>
			<td><select name="assign"><?php echo $staffselect ?></select></td>
		</tr>
		<tr>
			<th>Prioridade</th>
			<td><select name="priority" id="priority"><option value="3">Baixa</option><option value="2">Alta</option><option value="1">Urgente</option></select></td>
		</tr>
		<tr>
			<th>Caixa de Mensagem</th>
			<td>
				<textarea name="body"></textarea><br />
				Dica: Você pode usar html na caixa!
			</td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" value="Adicionar"/></td>
		</tr>
    </table>
</form>