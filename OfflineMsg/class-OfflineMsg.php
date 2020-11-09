<?php

class OfflineMsg {
	private $m_sUName; // user name
	private $m_hDbCon; // handler of db connection

	public function __construct($_name) {
		$this->m_sUName = $_name;
		// create a empty db for the user
		$file_name = "{$this->m_sUName}.db";
		if (!file_exists($file_name)) {
			touch($file_name);
		}
		else {
			// echo "Exist";
		}
	}
	public function __destruct() {
		// do nothing
	}

	public function OpenBDB() {
		$this->m_hDbCon = dba_open("{$this->m_sUName}.db", "c", "db4");
		return ($this->m_hDbCon) ? true : false;
	}
	public function CloseBDB() {
		if ($this->m_hDbCon) { dba_close($this->m_hDbCon); }
	}
	public function WriteOffMsg($_msg) {
		$timestamp = date('d-M-Y H:i:s A');
		$OK = dba_insert("{$this->m_sUName}_{$timestamp}", "$_msg", $this->m_hDbCon);
		// $OK = dba_replace("{$this->m_sUName}_{$timestamp}", "$_msg", $this->m_hDbCon);
		if ($OK) { echo $_msg; }
		return ($OK) ? true : false;
	}
	public function IsReadComplete() {
		return (dba_firstkey($this->m_hDbCon) == false) ? true : false;
	}
	public function ReadOffMsg() {
		$key = dba_firstkey($this->m_hDbCon);
		$msg = dba_fetch($key, $this->m_hDbCon);
		dba_delete($key, $this->m_hDbCon);
		return (dba_fetch($key, $this->m_hDbCon));
		/*
		while ($key != false) {
			echo $key . " " . dba_fetch($key, $db_conn);
			$key = dba_nextkey($db_conn);
		}
		*/
	}
}

?>

