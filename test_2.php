<?php
/* $dn = array(
    "countryName" => 'XX', //所在国家名称
    "stateOrProvinceName" => 'State', //所在省份名称
    "localityName" => 'SomewhereCity', //所在城市名称
    "organizationName" => 'MySelf',   //注册人姓名
    "organizationalUnitName" => 'Whatever', //组织名称
    "commonName" => 'mySelf', //公共名称
    "emailAddress" => 'user@domain.com' //邮箱
);
 
$privkeypass = '111111'; //私钥密码
$numberofdays = 365;     //有效时长
$cerpath = "./test.cer"; //生成证书路径
$pfxpath = "./test.pfx"; //密钥文件路径
 
//生成证书  
$privkey = openssl_pkey_new($dn);
$csr = openssl_csr_new($dn, $privkey);
$sscert = openssl_csr_sign($csr, null, $privkey, $numberofdays);
openssl_x509_export($sscert, $csrkey); //导出证书$csrkey
openssl_pkcs12_export($sscert, $privatekey, $privkey, $privkeypass); //导出密钥$privatekey
//生成证书文件
$fp = fopen($cerpath, "w");
fwrite($fp, $csrkey);
fclose($fp);
//生成密钥文件
$fp = fopen($pfxpath, "w");
fwrite($fp, $privatekey);
fclose($fp); */
$config = array(
    "digest_alg" => "sha512",
    "private_key_bits" => 4096,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
);
 
// Create the private and public key
$res = openssl_pkey_new($config);

// Extract the private key from $res to $privKey
openssl_pkey_export($res, $privKey);

// Extract the public key from $res to $pubKey
$pubKey = openssl_pkey_get_details($res);
$pubKey = $pubKey["key"];

$data = 'plaintext data goes here';

// Encrypt the data to $encrypted using the public key
openssl_public_encrypt($data, $encrypted, $pubKey);

// Decrypt the data using the private key and store the results in $decrypted
openssl_private_decrypt($encrypted, $decrypted, $privKey);

echo $decrypted;
?>