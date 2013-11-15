<?php

function getAllContacts(){
	$temp=array();
	$query=mysql_query("SELECT * FROM sms.contact sc ORDER BY sc.name");
	while($row=mysql_fetch_array($query)){
		$temp[]=$row;
	}

	return $temp;
}

function getMessages($number){
	$number = mysql_real_escape_string($number);

	$query=mysql_query("SELECT * FROM sms.inbox si WHERE si.SenderNumber = '{$number}' ORDER BY si.UpdatedInDB");
	$errors = array('errors' => 'Pesan Tidak ditemukan' );
	if(mysql_num_rows($query)<1){
		return $errors;
	}else{
		$temp=array();
		while ($row=mysql_fetch_array($query)) {
			$temp[]=$row;
		}
		return $temp;
	}

}

function sendToNumber($number,$text){
	$number = mysql_real_escape_string($number);
	$text = mysql_real_escape_string($text);

	$errors=array();
	if($number==""){
		$errors[]="Masukan Nomor Tujuan";
	}elseif($text==""){
		$errors[]="Masukan Text yang akan dikirim";
	}

	$key = (empty($errors)) ? mysql_query("INSERT INTO sms.outbox(DestinationNumber,TextDecoded) VALUES ('{$number}','{$text}')") : false;

	if($key==false){
		return array('errors' => $errors );
	}
}