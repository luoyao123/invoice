<?php
namespace invoice\invoiceCrmApi;
use \Firebase\JWT\JWT;
$requestdatas = array(array(
    'FPQQLSH'       =>  '201609270401332343TA01001',
    'XSF_NSRSBH'    =>  '97621763199P',
    'XSF_MC'        =>  '',
    'testname'      =>  '',
    'XSF_DZDH'      =>  '',
    'testdzdh'      =>  '',
    'GMF_MC'        =>  '测试客户',
    'JSHJ'          =>  '1',
    'HJJE'          =>  '0.85',
    'HJSE'          =>  '0.15',
    'items'         =>  array(
                            'XMMC' => '01',
                            'XMSL' => '1.0000000000',
                            'XMJE' => '0.85',
                            'SE'   => '0.15',
                            'XMJSHJ' => '1',
                            'SL'   => '0.17',
                        ),
));
$email=[[
        "fpqqlsh"=>"201609270401332343TA01001",
        "address"=>"lebh@yonyou.com",
        "title"=>"inovice",
        "content"=>"inovice"]];
RestInvoice::insertWithArray($requestdatas,$email,null,null);

Class RestInvoice{
    /**
     * 
     * @param string $url
     * @param string $post_data
     */
    public static function set_post($url,$post_data,$header){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 25);
        curl_setopt($ch,CURLINFO_HEADER_OUT,true);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
        $document = curl_exec($ch);
        /* $data = json_decode($document);
        $a = curl_getinfo($ch,CURLINFO_HEADER_OUT); */
        curl_close($ch);
    }
    //上传pdf
    /**
     * 
     * @param string $usercode
     * @param string $useremail
     * @param string $usermobile
     * @param array  $pdfFiles : 包含文件名$fileName 和base64后的content
     * 
     * fix:文件base64在哪完成，
     */
    public static function uploadpdf($usercode,$useremail,$usermobile,$pdfFiles){
        $post_data = array(
            'usercode'=>$usercode,
            'useremail'=>$useremail,
            'usermobile'=>$usermobile,
            'pdfFiles'=>$pdfFiles,
        );
        $post_data = json_encode($post_data);
        $header = self::getHeader('json');
        self::set_post('http://192.168.52.101:9003/invoiceclient-web/api/invoiceApplyDemo/insertAndApply?appid=testerCA', $post_data,$header);
        
    }
    /**
     * 
     * @param String $usercode
     * @param array $invoices
     */
    public static function delete($usercode,$invoices){
        $post_data = array(
            'usercode' => $usercode,
            'invoices' => $invoices,
        );
        $post_data = json_encode($post_data);
        $header = self::getHeader('json');
        self::set_post('http://192.168.52.101:9003/piaoeda-web/api/einvoice/delete?appId=testerCA&ts=2132131231', $post_data,$header);
    }
    
    /**
     * 
     * 发票查询
     * @param string $fpqqlsh
     */
    
    public static function queryInvoiceStatus($fpqqlsh){
        $post_data = "fpqqlsh=$fpqqlsh";
        $header = self::getHeader('form');
        self::set_post('http://192.168.52.101:9003/invoiceclient-web/api/invoiceApply/queryInvoiceStatus?appId=testerCA', $post_data,$header);
    }
    
    /**
     * 
     * @param array $requestdatas 二元数组
     * @param array $email
     * @param array $sms
     * @param array $url
     */
    public static function insertWithArray($requestdatas,$email,$sms,$url){
        $jwt = JWT::encode($requestdatas, $key);
        $post_data  = "requestdatas=".json_encode($requestdatas);
        $post_data .= "&email=".json_encode($email);
        $header = self::getHeader('form');
        self::set_post('http://192.168.52.101:9003/invoiceclient-web/api/invoiceApplyDemo/insertAndApply?appid=testerCA', $post_data,$header);
    }
    
    /**
     * 
     * 获得请求头
     * @param string $type
     */
    public static function getHeader($type){
        switch($type){
            case 'json':
                $header = array(
                    'Content-Type: application/json;charset=UTF-8',
                );
                break;
            case 'form':
                $header = array(
                    'Content-Type:application/x-www-form-urlencoded; charset=UTF-8',
                );
                break;
        }
        return $header;
    }
}