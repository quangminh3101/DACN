<!-- <div class="container-lg mt-5" id="page-body"> -->
	<div class="row no-gutters mt-5">
		<!-- Grid column -->
		<div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
			<button class="btn btn-primary" data-toggle="collapse" data-target="#collapseOne"><i class="fas fa-file-upload pr-2" aria-hidden="true"></i>Thêm file</button>
			<div class="collapse" id="collapseOne">
				<!--Panel-->
				<div class="card card-body ml-1">
					<form action="" id="form-upload-file" enctype="multipart/form-data">
						<div class="md-form">
							<input type="text" id="form-upload-file-name" class="form-control" name="fileName">
							<label for="form-upload-file-name">Tên file</label>
						</div>
						<!-- file -->
						<div class="input-group mt-4">
							<div class="input-group-prepend">
								<span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
							</div>
							<div class="custom-file">
								<input type="file" name="fileUpload[]" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" multiple>
								<label class="custom-file-label" for="inputGroupFile01">Chọn file</label>
							</div>
						</div>
						<!-- /.file -->

						<div class="md-form mt-5">
							<textarea name="note" id="form-upload-note" class="md-textarea form-control" rows="3"></textarea>
							<label for="form-upload-note">Mô tả</label>
						</div>

						<div class="btn-group btn-group-toggle mt-3" data-toggle="buttons">
							<label class="btn btn-info form-check-label ml-0 active">
								<input class="form-check-input" type="radio" name="status" autocomplete="off" value="0" checked>Chỉ mình tôi
							</label>
							<label class="btn btn-info form-check-label active">
								<input class="form-check-input" type="radio" name="status" autocomplete="off" value="1">Share link
							</label>
							<label class="btn btn-info form-check-label active">
								<input class="form-check-input" type="radio" name="status" autocomplete="off" value="2">Công khai
							</label>
						</div>
						<div class="text-center mt-3 ">
							<button type="submit" class="btn btn-success">Tải lên</button>
						</div>
						<!-- progress -->
						<div class="progress mt-3">
							<div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</form>
				</div>
				<!--/.Panel-->
			</div>
		</div>
		<!-- Grid column -->
	</div>
	<div class="row no-gutters">
		<div class="col-10 offset-1">
			<table id="table-list-file" class="table table-borderless table-striped">
				<thead>
					<tr>
						<th class="th-sm font-weight-bold">File Name</th>
						<th class="font-weight-bold">Ghi chú</th>
						<th class="th-sm font-weight-bold">Size</th>
						<th class="th-sm font-weight-bold">File total</th>
						<th class="th-sm font-weight-bold">Ngày tải lên</th>
						<th class="th-sm font-weight-bold">Trạng thái</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($dataFile as $key => $value): ?>
						<tr class="file-items hoverable" data-id="<?php echo $value['id'] ?>">
							<td><a href="/download/files?<?php echo 'id='.$value['id'].'&keyPrivate='.$value['keyPrivate'] ?>" class="text-primary download-file-name" target="_blank"><?= $value['fileName']?></a></td>
							<td class="note"><?= $value['note']?></td>
							<td><?= $value['size']?></td>
							<td><?= $value['totalFile']?></td>
							<td class="dateUpload"><?= date('d/m/Y', $value['dateUpload'])?></td>

							<td class="status" style="color: 
							<?php if ($value['status'] == 0) echo '#FF3547';
								  else if ($value['status'] == 1) echo '#00C851';
								  else echo '#4285F4';?>">

								  <?php if ($value['status'] == 0) echo 'Chỉ mình tôi';
								  else if ($value['status'] == 1) echo 'Share link';
								  else echo 'Công khai';?>
							</td>
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
						<th class="th-sm font-weight-bold">Trạng thái</th>
					</tr>
				</tfoot>
			</table>

		</div>
	</div>
<!-- </div> -->
<div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="" id="form-edit-file">
				<div class="modal-header text-center">
					<h4 class="modal-title w-100 font-weight-bold">Chỉnh sửa file</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body mx-3">
					<div class="md-form input-group mb-3">
						<input name="fileName" id="form-edit-upload-file-name" type="text" class="form-control mt-2" placeholder="File Name" aria-label="Username" aria-describedby="material-addon1">
						<label for="form-edit-upload-file-name">Tên file</label>
					</div>
					<div class="md-form input-group mt-1">
						<textarea name="note" id="form-edit-upload-note" class="md-textarea form-control mt-2" placeholder="Note" aria-label="With textarea"></textarea>
						<label for="form-edit-upload-note">Ghi chú</label>
					</div>
					<div class="btn-group btn-group-toggle mt-3" data-toggle="buttons">
						<label class="btn btn-info form-check-label ml-0 active">
							<input class="form-check-input" type="radio" name="status" autocomplete="off" value="0" checked>Chỉ mình tôi
						</label>
						<label class="btn btn-info form-check-label">
							<input class="form-check-input" type="radio" name="status" autocomplete="off" value="1">Share link
						</label>
						<label class="btn btn-info form-check-label">
							<input class="form-check-input" type="radio" name="status" autocomplete="off" value="2">Công khai
						</label>
					</div>
				</div>
				<div class="modal-footer d-flex justify-content-center">
					<button type="submit" class="btn btn-outline-success waves-effect"><i class="fas fa-check-circle pr-2" aria-hidden="true"></i>Sửa file</button>
					<button type="button" class="btn btn-outline-danger waves-effect button-delete-file" data-id=""><i class="fas fa-trash-alt pr-2" aria-hidden="true"></i>Xóa file</button>
				</div>
			</form>
		</div>
	</div>
</div>

<h1><?= round($sizeUse/$this->session->userdata('maxSize')*100).'%' ?></h1>

<script>
	$(document).ready(function () {
		$('#table-list-file').DataTable();
		$('.dataTables_length').addClass('bs-select');
	});

	var elementEdit;

	// Upload file
	document.getElementById('form-upload-file').onsubmit = function(event) {
		event.preventDefault();

		let formData = new FormData(this);
		let formElement = this;
		let progressbar = formElement.querySelector('.progress-bar');
		if (formData.get('fileName').length == 0) {
			ShowMsgModal('Thất bại!', 'Vui lòng nhập tên file', 4, 'danger');
			return;
		}

		let btnUploadElement = formElement.querySelector('button[type="submit"]');
		btnUploadElement.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Tải lên...`;
		btnUploadElement.disabled = true;
		$.ajax({
			xhr: function() {
				progressbar.style.backgroundColor = '#007BFF';
		        let request = new window.XMLHttpRequest();
		        request.upload.addEventListener('progress', function(e) {
	                let percent_complete = (e.loaded / e.total)*100;
	                progressbar.style.width = percent_complete+'%';
	                progressbar.setAttribute('aria-valuenow', percent_complete);
	            });
		       return request;
		    },
			url: '/UploadFile',
			type: 'POST',
			dataType: 'json',
			processData: false,
	        contentType: false,
			data: formData,
		})
		.done(function(data) {
			if (data.status) {
				let statusColor = '#4285F4';
				let statusText = 'Công khai';
				if (data.data.status == 0) {
					statusColor = '#FF3547';
					statusText = 'Chỉ mình tôi';
				} else if (data.data.status == 1) {
					statusColor = '#00C851';
					statusText = 'Share link';
				}
				let html = `<tr class="file-items hoverable" data-id="${data.data.id}">
								<td><a href="/download/files?id=${data.data.id}&keyPrivate=${data.data.keyPrivate}" class="text-primary download-file-name" target="_blank">${data.data.fileName}</a></td>
								<td class="note">${data.data.note}</td>
								<td>${data.data.size}</td>
								<td>${data.data.totalFile}</td>
								<td class="dateUpload">${data.data.dateUpload}</td>
								<td class="status" style="color: ${statusColor};">${statusText}</td>
							</tr>`;
				$('#table-list-file tbody').append(html);
				document.querySelector('#table-list-file tbody tr:last-child').oncontextmenu = function(e) {
					e.preventDefault();
					fEdit(this);
				}
				if (document.querySelector('#table-list-file tbody .odd .dataTables_empty'))
					document.querySelector('#table-list-file tbody .odd .dataTables_empty').parentElement.remove();

				document.querySelector('#table-list-file tbody tr:last-child .download-file-name').oncontextmenu = function(e) {
					e.stopPropagation();
				}

				ShowMsgModal('Thành công!', data.message, 4);
				progressbar.style.backgroundColor = '#00C851';
			} else {
				ShowMsgModal('Thất bại!', data.message, 4, 'danger');
				progressbar.style.backgroundColor = '#FF3547';
			}

		})
		.fail(function() {
			ShowMsgModal('Lỗi!', 'Không thể kết nối đến máy chủ', 4, 'danger');
			progressbar.style.backgroundColor = '#FF3547';
		})
		.always(function() {
			btnUploadElement.innerHTML = `Tải lên`;
			btnUploadElement.disabled = false;
		});
		
	}

	// Chuột phải show form sửa file
	document.querySelectorAll('.file-items').forEach( function(element, index) {
		element.oncontextmenu = function(e) {
			e.preventDefault();
			fEdit(this);
		}
	});

	function fEdit(element) {
		let formEdit = document.getElementById('modalContactForm');
		let id = element.getAttribute('data-id');

		elementEdit = element;
		$.ajax({
			url: '/Personal/getDataFile/'+id,
			type: 'GET',
			dataType: 'json'
		})
		.done(function(data) {
			formEdit.querySelector('input[name="fileName"]').value = data.fileName;
			formEdit.querySelector('textarea[name="note"]').value = data.note;
			
			formEdit.querySelectorAll('input[name="status"]').forEach(function(element) {
				element.removeAttribute('checked');
				element.parentElement.classList.remove('active');
			})
			formEdit.querySelector('input[name="status"][value="'+data.status+'"]').setAttribute('checked', true);
			formEdit.querySelector('input[name="status"][value="'+data.status+'"]').parentElement.classList.add('active');
			$('#modalContactForm').modal('show');
		})
		.fail(function() {
			ShowMsgModal('Lỗi!', 'Không thể kết nối đến máy chủ', 4, 'danger');
		});
	}

	document.querySelectorAll('.download-file-name').forEach( function(element, index) {
		element.oncontextmenu = function(e) {
			e.stopPropagation();
		}
	});

	// Sửa file
	document.getElementById('form-edit-file').onsubmit = function(event) {
		event.preventDefault();
		let formData = new FormData(this);
		let id = elementEdit.getAttribute('data-id');
		$.ajax({
			url: '/Personal/editFile/'+id,
			type: 'POST',
			dataType: 'json',
			processData: false,
	        contentType: false,
			data: formData,
		})
		.done(function(data) {
			if (data.status) {
				elementEdit.querySelector('.download-file-name').innerText = data.data.fileName;
				elementEdit.querySelector('.download-file-name').setAttribute('href', `/download/files?id=${id}&keyPrivate=${data.data.keyPrivate}`);
				elementEdit.querySelector('.note').innerText = data.data.note;
				elementEdit.querySelector('.dateUpload').innerText = data.data.dateUpload;
				if (data.data.status == 0) {
					elementEdit.querySelector('.status').style.color = '#FF3547';
					elementEdit.querySelector('.status').innerText = 'Chỉ mình tôi';
				} else if (data.data.status == 1) {
					elementEdit.querySelector('.status').style.color = '#00C851';
					elementEdit.querySelector('.status').innerText = 'Share link';
				} else {
					elementEdit.querySelector('.status').style.color = '#4285F4';
					elementEdit.querySelector('.status').innerText = 'Công khai';
				}

				ShowMsgModal('Thành công!', data.message, 4);
				$('#modalContactForm').modal('hide');
			} else {
				ShowMsgModal('Thất bại!', data.message, 4, 'danger');
			}
		})
		.fail(function() {
			ShowMsgModal('Lỗi!', 'Không thể kết nối đến máy chủ', 4, 'danger');
		});
	}

	// Xóa file
	document.querySelector('#form-edit-file .button-delete-file').onclick = function() {
		$('#modalContactForm').modal('hide');
		$.ajax({
			url: '/Personal/deleteFile/'+elementEdit.getAttribute('data-id'),
			type: 'DELETE',
			dataType: 'json'
		})
		.done(function(data) {
			if (data.status) {
				ShowMsgModal('Thành công!', data.message, 4);
				elementEdit.remove();
				if (document.querySelectorAll('#table-list-file tbody tr').length == 0) {
					let html = `<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">No data available in table</td></tr>`;
					$('#table-list-file tbody').append(html);
				}
			} else {
				ShowMsgModal('Thất bại!', data.message, 4, 'danger');
			}
		})
		.fail(function() {
			ShowMsgModal('Lỗi!', 'Không thể kết nối đến máy chủ', 4, 'danger');
		});
	}
</script>