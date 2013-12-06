<?php
/* Tasklist Addon
 * Created and maintained by Akkarin
 * Current Version: 1.00.04
 */
 
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();
?>
<h2>Configurações da Equipe</h2>
<h3>Configurações atual Equipe</h3>
<?php if($stafflist): ?>
	<table class="horizontal-table" width="100%"> 
		<tbody>
		<tr>
			<th>Nome da conta</th>
			<th>Nome preferido</th>
			<th>Ativar E-mails</th>
			<th>Opções</th>
		</tr>
		<?php foreach($stafflist as $trow):?>
			<tr >
				<td><?php echo $trow->account_name?></td>
				<td><?php echo $trow->preferred_name?></td>
				<td>
					<?php if($trow->emailalerts=='0'): ?>Não<?php elseif($trow->emailalerts=='1'): ?>Sim<?php endif ?></td>
				<td>
				<a href="<?php echo $this->url('tasks', 'staffsettings', array('option' => 'delete', 'staffid' => $trow->account_id))?>" >Deletar</a></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php else: ?>
	<p>
		Não há nenhuma configuração atual para equipe<br/><br/>
	</p>
<?php endif ?>
<br />
<h3>Adicionar configurações da equipe</h3>
<form action="<?php echo $this->urlWithQs ?>" method="post">
	<table class="horizontal-table" width="100%">
		<tr>
			<th>Nome da conta</th>
			<th>Nome preferido</th>
			<th>Ativar E-mails</th>
		</tr>
		<tr>
			<td><input type="text" name="account_name" value="<?php echo $session->account->userid ?>" readonly="readonly" /></td>
			<td><input type="text" name="preferred_name" /></td>
			<td><input type="checkbox" name="emailalerts" value="1" /></td>
		</tr>
		<tr>
			<td colspan="3">
			<input type="hidden" name="account_id" value="<?php echo $session->account->account_id ?>" />
			<input type="submit" value="Adicionar Equipe"/></td>
		</tr>
    </table>
</form>
<br />
<h3>Atenção</h3>
<p>Enquanto o formulário acima sugere que e-mails podem ser enviados, ele será executado em uma versão futura. Assinalando a caixa não vai fazer nada, no entanto, quando você atualizar, configurações da equipe não precisam ser alteradas.</p>