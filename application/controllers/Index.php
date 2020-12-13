<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{

		$this->load->model('File');
		$dataFile = $this->File->getFilePublic();

		$data = array(
			'ActiveNavbar' => 'public',
			'fileName' => 'index',
			'dataFile' => $dataFile
		);
		$this->load->view('template/main', $data, FALSE);
	}

	public function loginAuth()
	{
		$res['status'] = false;
		$res['message'] = '<b>Đăng nhập thất bại:</b> Sai tên tài khoản hoặc mật khẩu';

		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$this->load->model('Account');
		$data = $this->Account->getAccount($username);
		if ($data && $data['ban'] != 1) {
			if (password_verify($password, $data['password'])) {
				unset($data['password']);
				$this->session->set_userdata( $data );
				$res['status'] = true;
				$res['message'] = 'Đăng nhập thành công';
			}
		}
		if ($data['ban'] == 1) {
			$res['message'] = 'Tài khoản đã bị khóa, vui lòng liên hệ QTV';
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($res));
	}

	public function logOut()
	{
		$this->session->sess_destroy();
		redirect('/','refresh');
	}

	public function changePass($username)
	{
		$res['status'] = false;
		$res['message'] = 'Sai mật khẩu hiện tại';

		$passwordOld = $this->input->post('passwordOld');
		$req['password'] = password_hash($this->input->post('passwordNew'), PASSWORD_DEFAULT);

		$this->load->model('Account');
		$data = $this->Account->getAccount($username);
		if ($data) {
			if (password_verify($passwordOld, $data['password'])){
				if ($this->Account->updateAccount($username, $req)) {
					$res['status'] = true;
					$res['message'] = 'Đổi mật khẩu thành công';
				}
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($res));
	}
}

/* End of file Index.php */
/* Location: ./application/controllers/Index.php */