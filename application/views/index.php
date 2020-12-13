<!-- <div class="container-lg mt-5" id="page-body"> -->
	<div class="row no-gutters mt-5">
		<div class="col-10 offset-1">
			<table id="dtBasicExample" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th class="th-sm font-weight-bold">File Name</th>
						<th class="font-weight-bold">Ghi chú</th>
						<th class="th-sm font-weight-bold">Size</th>
						<th class="th-sm font-weight-bold">File total</th>
						<th class="th-sm font-weight-bold">Ngày tải lên</th>
						<th class="th-sm font-weight-bold">Upload By</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($dataFile as $key => $value): ?>
						<tr class="hoverable">
							<td><a href="/download/files?<?php echo 'id='.$value['id'].'&keyPrivate='.$value['keyPrivate'] ?>" class="text-primary download-file-name" target="_blank"><?= $value['fileName']?></a></td>
							<td><?= $value['note']?></td>
							<td><?= $value['size']?></td>
							<td><?= $value['totalFile']?></td>
							<td><?= date('d/m/Y', $value['dateUpload'])?></td>
							<td><?= $value['user']?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
				<tfoot>
				<tr>
					<th class="th-sm font-weight-bold">File Name</th>
					<th class="font-weight-bold">Ghi chú</th>
					<th class="th-sm font-weight-bold">Size</th>
					<th class="th-sm font-weight-bold">File total</th>
					<th class="th-sm font-weight-bold">Ngày tải lên</th>
					<th class="th-sm font-weight-bold">Upload By</th>
				</tr>
				</tfoot>
			</table>
		</div>
	</div>
<!-- </div> -->

<script>
	$(document).ready(function () {
		$('#dtBasicExample').DataTable();
		$('.dataTables_length').addClass('bs-select');
	});
</script>