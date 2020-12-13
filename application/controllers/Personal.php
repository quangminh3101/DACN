<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Personal extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->has_userdata('username'))
			redirect('/','refresh');
	}

	public function index()
	{
		$this->load->model('File');
		$dataFile = $this->File->getFileByUserId($this->session->userdata('username'));

		$bytes = 0;
		foreach ($dataFile as $value) {
			$bytes += $value['sizeBytes'];
		}

		$data = array(
			'ActiveNavbar' => 'personal',
			'fileName' => 'personal',
			'sizeUse' => $bytes,
			'dataFile' => $dataFile
		);
		
		$this->load->view('template/main', $data, FALSE);
	}

	public function getDataFile($id)
	{
		$this->load->model('File');
		$data = $this->File->getFileById($id);
		if ($this->session->has_userdata('username') && $this->session->userdata('username') == $data['user']) {
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}

	public function editFile($id)
	{
		$res['status'] = false;
		$res['message'] = 'Cập nhật file thất bại';

		$data['fileName'] = $this->input->post('fileName');
		$data['note'] = $this->input->post('note');
		$data['status'] = $this->input->post('status');
		$data['keyPrivate'] = $this->generateRandomString(15);
		$data['dateUpload'] = strtotime("now");

		$this->load->model('File');
		if ($this->File->updateFile($id, $data)) {
			$res['status'] = true;
			$res['message'] = 'Cập nhật file thành công';
			$data['dateUpload'] = date('d/m/Y' , $data['dateUpload']);
			$data['keyPrivate'] = $data['keyPrivate'];
			$res['data'] = $data;
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($res));
	}

	public function deleteFile($id)
	{
		$method = $this->input->server('REQUEST_METHOD');
		if ($method == 'DELETE') {
			$res['status'] = false;
			$res['message'] = 'Xóa file thất bại';

			$this->load->model('File');
			$data = $this->File->getFileDetailsByFileId($id);
			foreach ($data as $key => $value) {
				unlink($value['dirFile']);
			}

			// Xóa file nén zip nếu có
			$data = $this->File->getFileById($id);
			if ($data && file_exists('download/user_download/'.$data['user']."/".$data['fileName'].'.zip')) {
				unlink('download/user_download/'.$data['user']."/".$data['fileName'].'.zip');
			}

			if ($this->File->deleteFile($id)) {
				$res['status'] = true;
				$res['message'] = 'Xóa file thành công';
			}

			$this->output->set_content_type('application/json')->set_output(json_encode($res));
		}
		else
			$this->output->set_status_header(500);
	}

	private function generateRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
}

/* End of file Private.php */
/* Location: ./application/controllers/Private.php */