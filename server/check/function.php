<?php

function validateKey($key){
	$key=mysql_real_escape_string($key);
	$result=mysql_query("SELECT * FROM api.api_key aa WHERE aa.`key` ='{$key}' ");
	$total=mysql_num_rows($result);
	if($total>0){
		return 1;
	}else{
		return 0;
	}
}