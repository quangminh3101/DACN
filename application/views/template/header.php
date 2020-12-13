<header>
	<nav class="mb-1 navbar navbar-expand-lg navbar-dark default-color">
		<a class="font-weight-bold navbar-logo" href="/">Files</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333"
		aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent-333">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item <?php if ($ActiveNavbar == 'public') echo 'active'; ?>">
					<a class="nav-link" href="/">Public</a>
				</li>
				<?php if ($this->session->userdata('username')): ?>
				<li class="nav-item <?php if ($ActiveNavbar == 'personal') echo 'active'; ?>">
					<a class="nav-link" href="/Personal">Personal</a>
				</li>
				<?php endif ?>
				<?php if ($this->session->userdata('username') && $this->session->userdata('level') > 1): ?>
				<li class="nav-item <?php if ($ActiveNavbar == 'create-account') echo 'active'; ?>">
					<a class="nav-link" href="/CreateAccount">Tạo tài khoản</a>
				</li>
				<li class="nav-item <?php if ($ActiveNavbar == 'account-manager') echo 'active'; ?>">
					<a class="nav-link" href="/AccountManager">Quản lý tài khoản</a>
				</li>
				<?php endif ?>
			</ul>
			<ul class="navbar-nav ml-auto nav-flex-icons">
				<?php if (!$this->session->has_userdata('username')): ?>
					<li class="nav-item">
						<span class="nav-link waves-effect waves-light" data-toggle="modal" data-target="#modalLoginForm" id="button-login">Đăng nhập</span>
					</li>
				<?php else: ?>
					<li class="nav-item dropdown d-flex align-items-center">
						<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fas fa-user"></i>
						</a>
						<span class="badge badge-danger" style="font-size: 16px;"><?php echo $this->session->userdata('username'); ?></span>
						<div class="dropdown-menu dropdown-menu-right dropdown-default custom-dropdown"
							aria-labelledby="navbarDropdownMenuLink-333">
							<a class="dropdown-item" href="/changePass" data-toggle="modal" data-target="#modalChangePassForm" id="button-change-pass">Đổi mật khẩu</a>
							<a class="dropdown-item" href="/Index/logOut">Đăng xuất</a>
						</div>
					</li>
					<li class="nav-item d-flex align-items-center">
						
					</li>
				<?php endif ?>
			</ul>
		</div>
	</nav>
</header>

<?php if (!$this->session->has_userdata('username')): ?>
	<div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form action="/" id="form-login">
					<div class="modal-header text-center">
						<h4 class="modal-title w-100 font-weight-bold">Đăng nhập</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body mx-3">
						<div class="md-form mb-5">
							<i class="fas fa-user prefix grey-text"></i>
							<input name="username" type="text" id="defaultForm-username" class="form-control validate">
							<label data-error="wrong" data-success="right" for="defaultForm-username">Tên tài khoản</label>
						</div>
						<div class="md-form mb-4">
							<i class="fas fa-lock prefix grey-text"></i>
							<input name="password" type="password" id="defaultForm-pass" class="form-control">
							<label data-error="wrong" data-success="right" for="defaultForm-pass">Mật khẩu</label>
						</div>
						<div class="form-row">
							<span class="message-error"></span>
						</div>
					</div>
					<div class="modal-footer d-flex justify-content-center">
						<button type="submit" class="btn btn-default">Đăng nhập</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php else: ?>
	<div class="modal fade" id="modalChangePassForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form action="/" id="form-change-pass">
					<div class="modal-header text-center">
						<h4 class="modal-title w-100 font-weight-bold">Đổi mật khẩu</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body mx-3">
						<div class="md-form mb-5">
							<i class="fas fa-key prefix grey-text"></i>
							<input name="passwordOld" type="password" id="defaultForm-passwordOld" class="form-control validate">
							<label data-error="wrong" data-success="right" for="defaultForm-passwordOld">Mật khẩu hiện tại</label>
						</div>
						<div class="md-form mb-4">
							<i class="fas fa-lock prefix grey-text"></i>
							<input name="passwordNew" type="password" id="defaultForm-passwordNew" class="form-control">
							<label data-error="wrong" data-success="right" for="defaultForm-passwordNew">Mật khẩu mới</label>
						</div>
						<div class="form-row">
							<span class="message-error"></span>
						</div>
					</div>
					<div class="modal-footer d-flex justify-content-center">
						<button type="submit" class="btn btn-default">Đổi mật khẩu</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php endif ?>

<script>
	<?php if ($this->session->has_userdata('username')): ?>
		document.querySelectorAll('#form-change-pass input').forEach( function(element, index) {
		element.onclick = () => document.querySelector('#form-change-pass .message-error').innerText = "";
		});
		document.getElementById('form-change-pass').onsubmit = function(e) {
			e.preventDefault();

			let formElement = this;
			let formData = new FormData(this);

			$.ajax({
				url: '/Index/changePass/<?php echo $this->session->userdata('username'); ?>',
				type: 'POST',
				dataType: 'json',
				processData: false,
		        contentType: false,
				data: formData,
			})
			.done(function(data) {
				if (data.status) {
					document.querySelector('#modalChangePassForm').click();
					ShowMsgModal('Thành công!', data.message, 4);
				} else {
					ShowMsgModal('Thất bại!', data.message, 4, 'danger');
				}
			})
            .fail(function() {
                ShowMsgModal('Lỗi!', 'Không thể kết nối đến máy chủ', 4, 'danger');
            });
		}
	<?php else: ?>
		document.querySelectorAll('#form-login input').forEach( function(element, index) {
			element.onclick = () => document.querySelector('#form-login .message-error').innerText = "";
		});
		document.getElementById('form-login').onsubmit = function(e) {
			e.preventDefault();

			let formElement = this;
			let formData = new FormData(this);

			$.ajax({
				url: '/Index/loginAuth',
				type: 'POST',
				dataType: 'json',
				processData: false,
		        contentType: false,
				data: formData,
			})
			.done(function(data) {
				if (data.status) {
					location.reload();
				} else {
					formElement.querySelector('.message-error').innerHTML = data.message;
				}
			})
		}
	<?php endif ?>
</script>