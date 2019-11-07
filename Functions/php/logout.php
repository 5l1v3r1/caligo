<?php
require('DBConnection/SQLiteDeviceConnection.php');
header('Content-type: application/json');
$sqlite = new SQLiteDeviceConnection();
$pdo = $sqlite->connect();
$session=$_POST["session"];
if ($pdo!=null){
	$response=$sqlite->checkStatus($session);
	if (count($response)>0){
		$sqlite = new SQLiteDeviceConnection();
		$pdo = $sqlite->connect();
		$res=$sqlite->logout();
		if ($res){
			file_put_contents("connectedDevices.txt", "");
			$response=array(
				"status"=>"success",
				"logout" =>1
			);
		}
		else{
			 $response=array(
                "status" => "success",
                "logout"=>0
                );
		}
	}
	else{
		$response=array(
		"status" => "success",
		"logout"=>0
		);
	}
}
else{
	$response=array(
		"status" => "success",
		"connection" => "Connection could not be established"
	);
}	
echo json_encode($response);
?>
