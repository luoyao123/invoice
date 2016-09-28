<?php
$ch = curl_init();
$post_data ='{\"usercode\":\"001\",\"invoices\":[{\"fpDm\":\"011001600111\",\"fpHm\":\"22818001\"},{\"fpDm\":\"011001600111\",\"fpHm\":\"22818115\"}]}';
$header = array(
    'Content-Type: application/x-www-form-urlencoded;charset=UTF-8',
    'Host:localhost:8072'
);
$url = 'http://192.168.52.101:9003/piaoeda-web/api/einvoice/delete?appId=testerCA&ts=2132131231';
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FAILONERROR, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
//curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_POST, 1); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_TIMEOUT, 25);
//curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch,CURLINFO_HEADER_OUT,true);
curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
$document = curl_exec($ch);
$data = json_decode($document);
$a = curl_getinfo($ch,CURLINFO_HEADER_OUT);
//$document = curl_exec($ch); //执行预定义的CURL
$info=curl_getinfo($ch); //得到返回信息的特性
curl_close($ch);
?>