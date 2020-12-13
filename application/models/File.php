<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class File extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function createFile($data, $file_details)
	{
		$this->db->trans_start();
		$this->db->insert('files', $data);
		$fileId = $this->db->insert_id();
		$fileDetails['fileId'] = $fileId;
		foreach ($file_details as $key => $value) {
			$fileDetails['dirFile'] = $value;
			$this->db->insert('file_details', $fileDetails);	 
		}
		return $this->db->trans_complete() ? $fileId : false;
	}

	public function getFileById($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('files', 0, 1)->row_array();
	}

	public function getFileByUserId($UID)
	{
		$this->db->where('user', $UID);
		return $this->db->get('files')->result_array();
	}
	
	public function getFilePublic()
	{
		$this->db->where('status', '2');
		return $this->db->get('files')->result_array();
	}

	public function updateFile($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update('files', $data);
	}

	public function deleteFile($id)
	{
		$this->db->where('id', $id);
		return $this->db->delete('files');
	}

	public function getFileDetailsByFileId($id)
	{
		$this->db->where('fileId', $id);
		return $this->db->get('file_details')->result_array();
	}
}

/* End of file File.php */
/* Location: ./application/models/File.php */