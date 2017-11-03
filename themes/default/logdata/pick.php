<?php if (!defined('FLUX_ROOT')) exit; ?>
<h2><?php echo htmlspecialchars(Flux::message('PickLogHeading')) ?></h2>
<?php if ($picks): ?>
<?php echo $paginator->infoText() ?>
<table class="horizontal-table">
	<tr>
		<th><?php echo $paginator->sortableColumn('Date', Flux::message('PickLogDateLabel')) ?></th>
		<th><?php echo $paginator->sortableColumn('CharID', Flux::message('PickLogCharacterLabel')) ?></th>
		<th><?php echo $paginator->sortableColumn('Action', Flux::message('PickLogTypeLabel')) ?></th>
		<th><?php echo $paginator->sortableColumn('Subject', Flux::message('PickLogSubjectLabel')) ?></th>
		<th><?php echo $paginator->sortableColumn('ItemID', Flux::message('PickLogItemLabel')) ?></th>
		<th><?php echo $paginator->sortableColumn('Source', Flux::message('PickLogSourceLabel')) ?></th>
		<th><?php echo $paginator->sortableColumn('Amount', Flux::message('PickLogAmountLabel')) ?></th>
		<th><?php echo $paginator->sortableColumn('ItemRefiningLevel', Flux::message('PickLogRefineLabel')) ?></th>
		<th><?php echo $paginator->sortableColumn('ItemSlot1', Flux::message('PickLogItemSerialLabel')) ?></th>
		<th><?php echo $paginator->sortableColumn('ItemSlot1', Flux::message('PickLogCard0Label')) ?></th>
		<th><?php echo $paginator->sortableColumn('ItemSlot2', Flux::message('PickLogCard1Label')) ?></th>
		<th><?php echo $paginator->sortableColumn('ItemSlot3', Flux::message('PickLogCard2Label')) ?></th>
		<th><?php echo $paginator->sortableColumn('ItemSlot4', Flux::message('PickLogCard3Label')) ?></th>
		<th><?php echo $paginator->sortableColumn('Mapname', Flux::message('PickLogMapLabel')) ?></th>
	</tr>
	<?php foreach ($picks as $pick): ?>
	<tr align="center">
		<td><?php echo $this->formatDateTime($pick->Date) ?></td>
		<td>
			<?php if ($pick->Source == 'Monster'): ?>
				<?php echo $pick->Name ?>
			<?php else: ?>
				<?php echo $this->linkToCharacter($pick->CharID, $pick->Name) ?>
			<?php endif ?>
		</td>
		<td><?php echo $pick->Action ?></td>
		<td><?php echo $pick->Subject ?></td>
		<td>
			<?php if ($pick->ItemName): ?>
				<?php if ($auth->actionAllowed('item', 'view')): ?>
					<?php echo $this->linkToItem($pick->ItemID, $pick->ItemName) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($pick->ItemName) ?>
				<?php endif ?>
			<?php elseif ($pick->ItemID): ?>
				<?php if ($auth->actionAllowed('item', 'view')): ?>
					<?php echo $this->linkToItem($pick->ItemID, $pick->ItemID) ?>
				<?php else: ?>
					<?php echo htmlspecialchars($pick->ItemID) ?>
				<?php endif ?>
			<?php else: ?>
				<span class="not-applicable"><?php echo htmlspecialchars(Flux::message('UnknownLabel')) ?></span>
			<?php endif ?>
		</td>
		<td><?php echo $pick->Source ?></td>
		<td><?php echo $pick->Amount >= 0 ? '+'.number_format($pick->Amount) : number_format($pick->Amount) ?></td>
		<td><?php echo $pick->ItemRefiningLevel ?></td>
		<!-- Card0 -->
		<td><?php echo $pick->ItemSerial ?></td>
		<td>
			<?php if ($pick->ItemSlot1): ?>
					<?php echo $this->linkToItem($pick->ItemSlot1, $pick->ItemSlot1) ?>
			<?php else: ?>
				<span class="not-applicable"><?php echo htmlspecialchars(Flux::message('NoneLabel')) ?></span>
			<?php endif ?>
		</td>
		<!-- Card1 -->
		<td>
			<?php if ($pick->ItemSlot2): ?>
					<?php echo $this->linkToItem($pick->ItemSlot2, $pick->ItemSlot2) ?>
			<?php else: ?>
				<span class="not-applicable"><?php echo htmlspecialchars(Flux::message('NoneLabel')) ?></span>
			<?php endif ?>
		</td>
		<!-- Card2 -->
		<td>
			<?php if ($pick->ItemSlot3): ?>
					<?php echo $this->linkToItem($pick->ItemSlot3, $pick->ItemSlot3) ?>
			<?php else: ?>
				<span class="not-applicable"><?php echo htmlspecialchars(Flux::message('NoneLabel')) ?></span>
			<?php endif ?>
		</td>
		<!-- Card3 -->
		<td>
			<?php if ($pick->ItemSlot4): ?>
					<?php echo $this->linkToItem($pick->ItemSlot4, $pick->ItemSlot4) ?>
			<?php else: ?>
				<span class="not-applicable"><?php echo htmlspecialchars(Flux::message('NoneLabel')) ?></span>
			<?php endif ?>
		</td>
		<td>
			<?php if ($pick->Mapname): ?>
				<?php echo htmlspecialchars(basename($pick->Mapname, '.gat')) ?>
			<?php else: ?>
				<span class="not-applicable"><?php echo htmlspecialchars(Flux::message('UnknownLabel')) ?></span>
			<?php endif ?>
		</td>
	</tr>
	<?php endforeach ?>
</table>
<?php echo $paginator->getHTML() ?>
<?php else: ?>
<p>
	<?php echo htmlspecialchars(Flux::message('PickLogNotFound')) ?>
	<a href="javascript:history.go(-1)"><?php echo htmlspecialchars(Flux::message('GoBackLabel')) ?></a>
</p>
<?php endif ?>