<div class="row no-gutters mt-5">
	<div class="col-10 offset-1">
		<table id="dtBasicExample" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="th-sm font-weight-bold">First Name</th>
					<th class="th-sm font-weight-bold">Last Name</th>
					<th class="th-sm font-weight-bold">UserName</th>
					<th class="th-sm font-weight-bold">Level</th>
					<th class="th-sm font-weight-bold">Khóa</th>
					<th class="th-sm font-weight-bold">Ngày tạo</th>
					<?php if ($this->session->userdata('username') == 'admin'): ?>
					<th class="th-sm font-weight-bold">Tạo bởi</th>
					<?php endif ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($dataAccount as $key => $value): ?>
					<tr class="account-items hoverable" data-username="<?= $value['username']?>">
						<td class="font-weight-normal"><?= $value['firstName']?></td>
						<td class="font-weight-normal"><?= $value['lastName']?></td>
						<td class="font-weight-normal"><?= $value['username']?></td>
						<td class="font-weight-normal" style="color: <?php if ($value['level'] == 3) echo "#FF3535"; else if ($value['level'] == 2) echo "#4285F4"; else echo "#000";?>"><?= $value['level']?></td>
						<?= $value['ban'] ? '<td class="font-weight-normal" style="color: #CE0012;">Khóa</td>' : '<td class="font-weight-normal" style="color: #00C851;">Mở</td>'?>
						<td class="font-weight-normal"><?= date('d/m/Y', $value['dateCreate'])?></td>
						<?php if ($this->session->userdata('username') == 'admin'): ?>
						<td class="font-weight-normal"><?= $value['createBy']?></td>
						<?php endif ?>
					</tr>
				<?php endforeach ?>
			</tbody>
			<tfoot>
				<tr>
					<th class="th-sm font-weight-bold">First Name</th>
					<th class="th-sm font-weight-bold">Last Name</th>
					<th class="th-sm font-weight-bold">UserName</th>
					<th class="th-sm font-weight-bold">Level</th>
					<th class="th-sm font-weight-bold">Khóa</th>
					<th class="th-sm font-weight-bold">Ngày tạo</th>
					<?php if ($this->session->userdata('username') == 'admin'): ?>
					<th class="th-sm font-weight-bold">Tạo bởi</th>
					<?php endif ?>
				</tr>
			</tfoot>
		</table>
	</div>
</div>

<div class="modal fade" id="form-edit-account-box" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="" id="form-edit-account">
				<div class="modal-header text-center">
					<h4 class="modal-title w-100 font-weight-bold">Chỉnh sửa tài khoản</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body mx-3">

					<div class="row">
						<div class="col-6">
							<div class="md-form input-group mb-3">
								<input name="firstName" id="form-edit-account-firstName" type="text" class="form-control mt-2" placeholder="File Name" aria-label="Username" aria-describedby="material-addon1">
								<label for="form-edit-account-firstName">Họ và tên lót</label>
							</div>
						</div>
						<div class="col-6">
							<div class="md-form input-group mb-3">
								<input name="lastName" id="form-edit-account-lastName" type="text" class="form-control mt-2" placeholder="File Name" aria-label="Username" aria-describedby="material-addon1">
								<label for="form-edit-account-lastName">Tên</label>
							</div>
						</div>
					</div>

					<div class="custom-control custom-switch mt-3">
						<input type="checkbox" name="banned" class="custom-control-input" id="form-edit-account-banned">
						<label class="custom-control-label" for="form-edit-account-banned">Khóa tài khoản</label>
					</div>
					<div class="btn-group btn-group-toggle mt-3" data-toggle="buttons">
                        <?php if ($this->session->userdata('level') > 1): ?>
                        <label class="btn btn-danger form-check-label active">
                            <input class="form-check-input" type="radio" name="level" value="1" autocomplete="off" checked>Level 1
                        </label>
                        <?php endif ?>
                        <?php if ($this->session->userdata('level') > 2): ?>
                        <label class="btn btn-danger form-check-label">
                            <input class="form-check-input" type="radio" name="level" value="2" autocomplete="off">Level 2
                        </label>
                        <label class="btn btn-danger form-check-label">
                            <input class="form-check-input" type="radio" name="level" value="3" autocomplete="off">Level 3
                        </label>
                        <?php endif ?>
                    </div>
				</div>
				<div class="modal-footer d-flex justify-content-center">
					<button type="submit" class="btn btn-outline-success waves-effect"><i class="fas fa-check-circle pr-2" aria-hidden="true"></i>Cập nhật</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>

	$(document).ready(function () {
		$('#dtBasicExample').DataTable();
		$('.dataTables_length').addClass('bs-select');

		let elementEdit;

		// Chuột phải sửa file
		document.querySelectorAll('.account-items').forEach( function(element, index) {
			element.oncontextmenu = function(e) {
				e.preventDefault();
				
				let formEdit = document.getElementById('form-edit-account-box');
				let username = this.getAttribute('data-username');

				elementEdit = this;
				$.ajax({
					url: '/AccountManager/getInfoAccount/'+username,
					type: 'GET',
					dataType: 'json'
				})
				.done(function(data) {
					formEdit.querySelector('input[name="firstName"]').value = data.firstName;
					formEdit.querySelector('input[name="lastName"]').value = data.lastName;
					if (data.ban != '0') {
						formEdit.querySelector('input[name="banned"]').checked = true;
					}
					// console.log(formEdit.querySelector('input[name="status"][value="'+data.status+'"]'));
					
					formEdit.querySelectorAll('input[name="level"]').forEach(function(element) {
						element.removeAttribute('checked');
						element.parentElement.classList.remove('active');
					})
					formEdit.querySelector('input[name="level"][value="'+data.level+'"]').setAttribute('checked', true);
					formEdit.querySelector('input[name="level"][value="'+data.level+'"]').parentElement.classList.add('active');
					$('#form-edit-account-box').modal('show');
				})
			}
		});

		document.getElementById('form-edit-account').onsubmit = function(event) {
			event.preventDefault();

			let formData = new FormData(this);
			formData.append('banned', this.querySelector('input[name="banned"]').checked ? '1' : '0')

			$.ajax({
				url: 'AccountManager/updateAccount/'+elementEdit.getAttribute('data-username'),
				type: 'POST',
				dataType: 'json',
	            processData: false,
	            contentType: false,
				data: formData
			})
			.done(function(data) {
				if (data.status) {
					elementEdit.querySelector('td:nth-child(1)').innerText = formData.get('firstName');
					elementEdit.querySelector('td:nth-child(2)').innerText = formData.get('lastName');
					// Cập nhật cột level
					if (formData.get('level') == 3) {
						elementEdit.querySelector('td:nth-child(4)').innerText = '3';
						elementEdit.querySelector('td:nth-child(4)').style.color = '#FF3535';
					} else if (formData.get('level') == 2) {
						elementEdit.querySelector('td:nth-child(4)').innerText = '2';
						elementEdit.querySelector('td:nth-child(4)').style.color = '#4285F4';
					} else {
						elementEdit.querySelector('td:nth-child(4)').innerText = '1';
						elementEdit.querySelector('td:nth-child(4)').style.color = '#000000';
					}
					// Cập nhật cột trạng thái khóa acc
					if (formData.get('banned') != '0') {
						elementEdit.querySelector('td:nth-child(5)').innerText = 'Khóa';
						elementEdit.querySelector('td:nth-child(5)').style.color = '#CE0012';
					} else {
						elementEdit.querySelector('td:nth-child(5)').innerText = 'Mở';
						elementEdit.querySelector('td:nth-child(5)').style.color = '#00C851';
					}
					ShowMsgModal('Thành công!', data.message, 4);
					$('#form-edit-account-box').modal('hide');
				} else {
					ShowMsgModal('Thất bại!', data.message, 4, 'danger');
				}
			})
			.fail(function() {
				ShowMsgModal('Lỗi!', 'Không thể kết nối đến máy chủ', 4, 'danger');
			});
			
		}
	});
</script>