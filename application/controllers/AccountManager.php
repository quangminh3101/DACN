<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AccountManager extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata('username') or $this->session->userdata('level') < 2)
			redirect('/','refresh');
	}

	public function index()
	{
		$this->load->model('Account');
		if ($this->session->userdata('username') == 'admin'){
			$dataAccount = $this->Account->getAllAccount();
			foreach ($dataAccount as $key => $value) {
				if ($value['username'] == 'admin') {
					unset($dataAccount[$key]);
					break;
				}
			}
		}
		else
			$dataAccount = $this->Account->getAccountByCreateBy($this->session->userdata('username'));
		$data = array(
			'ActiveNavbar' => 'account-manager',
			'fileName' => 'accountManager',
			'dataAccount' => $dataAccount
		);
		$this->load->view('template/main', $data, FALSE);
	}

	public function getInfoAccount($username)
	{
		$this->load->model('Account');
		$data = $this->Account->getAccount($username);
		// check người sửa phải người tạo không
		if ($data['createBy'] != $this->session->userdata('username')) {
			if ($this->session->userdata('username') != 'admin') {
				$this->output->set_status_header(500);
				exit;
			}
		}
		unset($data['password']);

		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function updateAccount($username)
	{
		$res['status'] = false;
		$res['message'] = "Cập nhật tài khoản <b>".$username."</b> thất bại";

		$data['firstName'] = $this->input->post('firstName');
		$data['lastName'] = $this->input->post('lastName');
		$data['ban'] = $this->input->post('banned');
		$data['level'] = $this->input->post('level');

		$this->load->model('Account');
		$dataAccount = $this->Account->getAccount($username);
		// check người sửa phải người tạo không
		if ($this->session->userdata('username') != 'admin') {
			if ($dataAccount['createBy'] != $this->session->userdata('username') || $data['level'] < 0 || $data['level'] > 3 || $data['level'] >= $this->session->userdata('level')) {
				$this->output->set_status_header(500);
				exit;
			}
		}

		if ($this->Account->updateAccount($username, $data)) {
			$res['status'] = true;
			$res['message'] = "Cập nhật tài khoản <b>".$username."</b> thành công";
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($res));
	}
}

/* End of file AccountManager.php */
/* Location: ./application/controllers/AccountManager.php */