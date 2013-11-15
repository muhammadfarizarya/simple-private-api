<?php
include 'config.php';
include 'core/function.php';
include 'check/function.php';

//header('Content-Type: application/json');

if(isset($_POST['getcontacts'])){
	if(json_encode(validateKey($_POST['api_key']))==1){
		echo json_encode(getAllContacts());
	}else{
		echo json_encode(array('errors' => 'Your key is Invalid'));
	}
}elseif(isset($_POST['getmessages'])){
	if(json_encode(validateKey($_POST['api_key']))==1){
		echo json_encode(getMessages($_POST['getmessages']));
	}else{
		echo json_encode(array('errors' => 'Your key is Invalid'));
	}
}elseif(isset($_POST['sendmessages'])){
	if(json_encode(validateKey($_POST['api_key']))==1){
		echo json_encode(sendToNumber($_POST['sendmessages'],$_POST['text']));
	}else{
		echo json_encode(array('errors' => 'Your key is Invalid'));
	}
}else{
	echo json_encode(array(
		'getcontact' => "Get All Contact", 
		'getmessages' => "Get All Messages by Number", 
		'sendmessages' => "Send Messages to Number"
	));
}
?>
