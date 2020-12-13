<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Download extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->output->set_status_header(404);
	}

	public function files()
	{
		$id = $this->input->get('id');
		if ($id) {
			$keyPrivate = $this->input->get('keyPrivate');
			$this->load->model('File');
			$data = $this->File->getFileById($id);

			// chỉ chủ file mới được download
			if ($data['status'] == 0 && (!$this->session->has_userdata('username') || $data['user'] != $this->session->userdata('username')))
				$this->output->set_status_header(404);

			if ($data['keyPrivate'] == $keyPrivate) {
				$dataFile = $this->File->getFileDetailsByFileId($id);
				// Nếu chỉ có 1 file thì tải về luôn
				if (count($dataFile) == 1) {
					$dataFile = $dataFile[0];
					if(file_exists($dataFile['dirFile'])) {
				        header('Content-Description: File Transfer');
				        header('Content-Type: application/octet-stream');
				        header('Content-Disposition: attachment; filename="'.basename($dataFile['dirFile']).'"');
				        header('Expires: 0');
				        header('Cache-Control: must-revalidate');
				        header('Pragma: public');
				        header('Content-Length: ' . filesize($dataFile['dirFile']));
				        flush(); // Flush system output buffer
				        readfile($dataFile['dirFile']);
				        exit;
				    }
				} else { // Nếu nhiều file thì nén lại thành file zip
					// path file nén
					$zipname = 'download/user_download/'.$data['user'].'/'.$data['fileName'].'.zip';
					// tên file tải về
					$downloadzipname = $data['fileName'].'.zip';

					// Nếu file zip chưa tồn tại thì nén file
					if (!file_exists($zipname)) {
						// Nén file zip
						$zip = new ZipArchive;
						$zip->open($zipname, ZipArchive::CREATE);
						foreach ($dataFile as $value) {
							$zip->addFromString(basename($value['dirFile']), file_get_contents($value['dirFile']));
						}
						$zip->close();
					}

					// download file zip
					header('Content-Type: application/zip');
					header('Content-disposition: attachment; filename='.$downloadzipname);
					header('Content-Length: ' . filesize($zipname));
					readfile($zipname);
				}
			} else {
				$this->output->set_status_header(404);
			}
		}
	}

}

/* End of file Download.php */
/* Location: ./application/controllers/Download.php */