<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UploadFile extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$res['status'] = true;
		$files['fileName'] = $this->input->post('fileName');
		if (strlen($files['fileName']) == 0) {
			$res['status'] = false;
			$res['message'] = 'Vui lòng nhập tên file';
		} else if (!file_exists($_FILES['fileUpload']['tmp_name'][0]) || !is_uploaded_file($_FILES['fileUpload']['tmp_name'][0])) {
			$res['status'] = false;
			$res['message'] = 'Chưa chọn file upload';
		}



		// Xử lý file
		if ($res['status']) {
			$target_dir = "uploads/user_upload/".$this->session->userdata('username')."/";
			$files['size'] = 0;
			$files['totalFile'] = 0;
			foreach ($_FILES['fileUpload']['name'] as $key => $value) {
				$fileName = pathinfo($value)['filename'];
				$fileExtension = pathinfo($value)['extension'];

				$fileName_temp = $fileName;
				$numberFile = 1;
				while (file_exists($target_dir.$fileName_temp.'.'.$fileExtension)) {
					$fileName_temp = $fileName;
					$fileName_temp .= '_'.$numberFile;
					$numberFile++;
				}
				$file_details[] = $target_dir.$fileName_temp.'.'.$fileExtension;
				// upload file thành công
				if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"][$key], end($file_details))) {
					$files['size'] += $_FILES["fileUpload"]["size"][$key];
					$files['totalFile']++;
					$res['status'] = true;
				} else {
					$res['status'] = false;
					$res['message'] = 'Upload file <b>'.$value.'</b> thất bại';
					for ($i=0; $i < $key-1; $i++) { 
						unlink($target_dir.$_FILES['fileUpload']['name'][$i]);
					}
					break;
				}
			}
			$files['sizeBytes'] = $files['size'];
			$files['size'] = $this->FileSizeConvert($files['size']);
		}

		// Xử lý database
		if ($res['status']) {
			// random 15 ký tự 0-9 a-z A-Z
			$files['keyPrivate'] = $this->generateRandomString(15);

			$files['note'] = $this->input->post('note');
			$files['status'] = $this->input->post('status');
			$files['dateUpload'] = strtotime("now");
			$files['user'] = $this->session->userdata('username');

			$this->load->model('File');
			$files['id'] = $this->File->createFile($files, $file_details);
			if ($files['id']) {
				$res['status'] = true;
				$res['message'] = 'Upload file thành công';
				$res['data'] = $files;
			} else {
				foreach ($_FILES['fileUpload']['name'] as $key => $value) {
					unlink($target_dir.$value);
				}
				$res['status'] = false;
				$res['message'] = 'Tên file đã tồn tại';
			}
		}

		$this->output->set_content_type('application/json')->set_output(json_encode($res));
	}

	private function delete_directory($dirname) {
        if (is_dir($dirname))
           $dir_handle = opendir($dirname);
    	if (!$dir_handle)
        	return false;
    	while($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname."/".$file))
                    unlink($dirname."/".$file);
                else
                    delete_directory($dirname.'/'.$file);
            }
	    }
	    closedir($dir_handle);
	    rmdir($dirname);
	    return true;
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

	private function FileSizeConvert($bytes)
	{
	    $bytes = floatval($bytes);
	        $arBytes = array(
	            0 => array(
	                "UNIT" => "TB",
	                "VALUE" => pow(1024, 4)
	            ),
	            1 => array(
	                "UNIT" => "GB",
	                "VALUE" => pow(1024, 3)
	            ),
	            2 => array(
	                "UNIT" => "MB",
	                "VALUE" => pow(1024, 2)
	            ),
	            3 => array(
	                "UNIT" => "KB",
	                "VALUE" => 1024
	            ),
	            4 => array(
	                "UNIT" => "B",
	                "VALUE" => 1
	            ),
	        );

	    foreach($arBytes as $arItem)
	    {
	        if($bytes >= $arItem["VALUE"])
	        {
	            $result = $bytes / $arItem["VALUE"];
	            $result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
	            break;
	        }
	    }
	    return $result;
	}
}

/* End of file UploadFile.php */
/* Location: ./application/controllers/UploadFile.php */