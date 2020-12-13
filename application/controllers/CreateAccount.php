<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CreateAccount extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata('username') or $this->session->userdata('level') < 2)
			redirect('/','refresh');
	}

	public function index()
	{
		$data = array(
			'ActiveNavbar' => 'create-account',
			'fileName' => 'createAccount'
		);
		$this->load->view('template/main', $data, FALSE);
	}

	public function create()
	{
		$res['status'] = true;
		$res['message'] = "Tạo tài khoản thành công";

		$data['firstName'] = $this->input->post('firstName');
		$data['lastName'] = $this->input->post('lastName');
		$data['username'] = $this->input->post('username');
		$data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
		$data['level'] = $this->input->post('level');
		$data['createBy'] = $this->session->userdata('username');
		$data['dateCreate'] = strtotime('now');
		foreach ($data as $key => $value) {
			if (strlen($value) == 0) {
				$res['status'] = false;
				$res['message'] = "Vui lòng điền đủ các trường";
			}
		}
		if ($data['level'] < 1 || $data['level'] > 3) {
			$this->output->set_status_header(500);
			exit;
		}

		// check level
		if ($this->input->post('level') >= $this->session->userdata('level') && $this->session->userdata('level') != 3){
			$this->output->set_status_header(500);
			exit;
		}
		// Tạo folder + tạo acc
		if ($res['status']) {
			$this->load->model('Account');
			if (!file_exists('uploads/user_upload/'.$data['username']) && $this->Account->createAccount($data) && mkdir('uploads/user_upload/'.$data['username'], 0777, true) && mkdir('download/user_download/'.$data['username'], 0777, true)) {
				chmod('uploads/user_upload/'.$data['username'], 0777);
				chmod('download/user_download/'.$data['username'], 0777);
			} else {
				$res['status'] = false;
				$res['message'] = "Tên tài khoản đã tồn tại";
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($res));
	}

}

/* End of file CreateAccount.php */
/* Location: ./application/controllers/CreateAccount.php */