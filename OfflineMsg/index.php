<? 
	function __autoload($classname) {
		require_once "./class-{$classname}.php";
	}

	$obj = new OfflineMsg("hobo");
	if ($obj->OpenBDB() != false) {
		echo "Open Successful\n";
		$obj->WriteOffMsg("Test1\n");
		sleep(1);
		$obj->WriteOffMsg("Test2\n");

		while (!$obj->IsReadComplete()) {
			echo $obj->ReadOffMsg();
		}

		$obj->CloseBDB();
	}

?>

