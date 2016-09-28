<?php
$pfxpath = 'E:\crm_invoice\pro22.pfx';
//私钥加密
$cer_key = file_get_contents($pfxpath); //获取密钥内容
openssl_pkcs12_read($cer_key, $certs, $privkeypass);
openssl_sign($data, $signMsg, $certs['pkey'],OPENSSL_ALGO_SHA1); //注册生成加密信息
$signMsg = base64_encode($signMsg); //base64转码加密信息
echo $signMsg;

?>