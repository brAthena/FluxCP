<?php
/* Tasklist Addon
 * Created and maintained by Akkarin
 * Current Version: 1.00.04
 */
 
if (!defined('FLUX_ROOT')) exit;
$this->loginRequired();
?>
<?php if($tasklist): ?>
<h2><?php echo htmlspecialchars($trow->title) ?></h2>
	<table class="vertical-table" width="70%"> 
		<tbody>
		<tr>
			<th><?php  echo htmlspecialchars(Flux::message('TLHeaderTasks')) ?></th>
				<td><?php echo htmlspecialchars($trow->title) ?></td>
			<th><?php  echo htmlspecialchars(Flux::message('TLHeaderStatus')) ?></th>
				<td><?php echo htmlspecialchars(Flux::message('TLStatus'.$trow->status)) ?> <?php if($disps) echo $disps ?></td>
		</tr>
		<tr>
			<th><?php  echo htmlspecialchars(Flux::message('TLHeaderPriority')) ?></th>
			<td><?php if($trow->priority==1):?>
						<font color="red"><?php echo htmlspecialchars(Flux::message('TLPriority'.$trow->priority.'')) ?></font>
						<?php elseif($trow->priority==2):?>
						<font color="orange"><?php echo htmlspecialchars(Flux::message('TLPriority'.$trow->priority.'')) ?></font>
						<?php elseif($trow->priority==3):?>
						<?php echo htmlspecialchars(Flux::message('TLPriority'.$trow->priority)) ?>
						<?php endif ?></td>
			<th><?php  echo htmlspecialchars(Flux::message('TLHeaderOwner')) ?></th>
			<td>
			<?php if($trow->assigned=='0' || $trow->assigned!=$staffsess->preferred_name): ?>
						<span class="not-applicable"> <?php echo htmlspecialchars(Flux::message('TLNotAssigned')) ?> <?php echo $assignedlink ?></span>
					<?php elseif($trow->assigned==$staffsess->preferred_name): ?>
						<span><?php echo $trow->assigned?> <?php echo $assignedlink ?></span>
					<?php else: ?>
						<?php echo $trow->assigned?>
					<?php endif ?></td>
		</tr>
		<tr>
			<th><?php  echo htmlspecialchars(Flux::message('TLHeaderCreated')) ?></th>
				<td><?php echo htmlspecialchars($trow->created) ?></td>
			<th><?php  echo htmlspecialchars(Flux::message('TLHeaderModified')) ?></th>
				<td><?php echo htmlspecialchars($trow->modified) ?></td>
		</tr>
		<tr>
			<th><?php  echo htmlspecialchars(Flux::message('TLHeaderResources')) ?></th>
			<td colspan="3"><?php echo $resources ?></td></tr>
		</tr>
		<tr>
			<th><?php  echo htmlspecialchars(Flux::message('TLHeaderBody')) ?><br />&nbsp;<br />&nbsp;<br />&nbsp;</th>
			<td colspan="3"><?php echo $trow->body ?></td></tr>
		</tr>
		<tr>
			<td colspan="4">
				<?php if($trow->status==5): ?>
					Esta tarefa foi marcada como concluída. Gostaria de definir o status de volta para <strong>Nova Tarefa</strong>?<br/>
					<a href="<?php echo $this->url('tasks', 'viewtasks', array('update' => $taskID)) ?>">Sim, atualizá-la!</a>
				<?php elseif($trow->status==2): ?>
					Esta tarefa é definida para <strong>Aguardando Implementação</strong>. Gostaria de definir o status para <strong>Concluído</strong>?<br/>
					<a href="<?php echo $this->url('tasks', 'viewtasks', array('update' => $taskID)) ?>">Sim, atualizá-la!</a>
				<?php elseif($trow->status==1): ?>
					Esta tarefa foi marcada como <strong>Em andamento</strong>. Gostaria de definir o status para <strong>Aguardando Implementação</strong>?<br/>
					<a href="<?php echo $this->url('tasks', 'viewtasks', array('update' => $taskID)) ?>">Sim, atualizá-la!</a>
				<?php elseif($trow->status==0): ?>
					Esta tarefa foi marcada como <strong>Novo</strong>. Gostaria de definir o status para <strong>Em andamento</strong>?<br/>
					<a href="<?php echo $this->url('tasks', 'viewtasks', array('update' => $taskID)) ?>">Sim, atualizá-la!</a>
				<?php endif ?>   
			</td>
		</tr>
		</tbody>
	</table>
<?php else: ?>
	<p>
		<?php echo htmlspecialchars(Flux::message('TLHuh')) ?>
	</p>
<?php endif ?>