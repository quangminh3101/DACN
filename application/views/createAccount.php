<div class="row no-gutters mt-5">
    <div class="col-lg-4 offset-lg-4">
        <div class="card">
            <h5 class="card-header primary-color white-text text-center py-4">
                <strong>Tạo mới tài khoản</strong>
            </h5>

            <div class="card-body px-lg-5 pt-0">
                <form class="" method="post" style="color: #757575;" id="form-create-account">
                    <div class="row mt-4">
                        <div class="col-6">
                            <div class="md-form">
                                <input type="text" id="form-create-first-name" class="form-control validate" name="firstName">
                                <label for="form-create-first-name" class="">Họ và tên lót</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="md-form">
                                <input type="text" id="form-create-last-name" class="form-control validate" name="lastName">
                                <label for="form-create-last-name" class="">Tên</label>
                            </div>
                        </div>
                    </div>
                    <div class="md-form mt-3">
                        <input type="text" id="form-create-username" class="form-control validate" name="username">
                        <label for="form-create-username" class="">Tên tài khoản</label>
                    </div>
                    <div class="md-form mt-3">
                        <input type="password" id="form-create-password" class="form-control validate" name="password">
                        <label for="form-create-password" class="">Mật khẩu</label>
                    </div>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <?php if ($this->session->userdata('level') > 1): ?>
                            <label class="btn btn-danger form-check-label active">
                                <input class="form-check-input" type="radio" name="level" value="1" id="option1" autocomplete="off" checked>Level 1
                            </label>
                        <?php endif ?>
                        <?php if ($this->session->userdata('level') > 2): ?>
                        <label class="btn btn-danger form-check-label">
                            <input class="form-check-input" type="radio" name="level" value="2" id="option2" autocomplete="off">Level 2
                        </label>
                        <label class="btn btn-danger form-check-label">
                            <input class="form-check-input" type="radio" name="level" value="3" id="option3" autocomplete="off">Level 3
                        </label>
                        <?php endif ?>
                    </div>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-success">Tạo tài khoản</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('form-create-account').onsubmit = function(event) {
            event.preventDefault();

            let formData =  new FormData(this);

            $.ajax({
                url: '/CreateAccount/create',
                type: 'POST',
                dataType: 'json',
                processData: false,
                contentType: false,
                data: formData
            })
            .done(function(data) {
                if (data.status) {
                    ShowMsgModal('Thành công!', data.message, 4);
                } else {
                    ShowMsgModal('Thất bại!', data.message, 4, 'danger');
                }
            })
            .fail(function() {
                ShowMsgModal('Lỗi!', 'Không thể kết nối đến máy chủ', 4, 'danger');
            });          
        }
    })
</script>