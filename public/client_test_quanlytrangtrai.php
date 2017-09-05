<?php
define("HTTP_USER", sha1("me2be@sunmedia.com"));
define('HTTP_PWD', null);
define('BASE_URL', 'http://quanlytrangtrai.vn');
define('KEY', '312ffc66c320c6193ec354e3906328b0');

// register normal
$uri = '/rest/v1/user/login';
$arg = array(
    'username' => 'vietnq',
    'password' => 'e10adc3949ba59abbe56e057f20f883e'
);
HttpHelper('GET', $arg, $uri);
die();


function makeSignature($method, $url, $Args = array())
{
    ksort($Args);
    $method = strtoupper($method);
    $data = $method . '&' . urlencode($url) . '&' . urlencode(http_build_query($Args));
    $signature = implode('', $Args);

    $signature = md5($signature);
    return $signature;
}

function HttpHelper($method, $args, $uri)
{

    $method = strtoupper($method);

    $signature = makeSignature($method, $uri, $args);
//    echo $signature;
    $url_signature = BASE_URL . $uri;

    $args['signature'] = $signature;
    $fields_string = http_build_query($args);


    //echo $fields_string;
    if ($method == 'GET')
        $url_signature .= '?' . $fields_string;
    //$url_signature .='?'.$fields_string;
    // var_dump($url_signature);die;

    $curl = curl_init($url_signature);

//    echo $url_signature;
    // BaoKim with Signture
    // $curl = curl_init($url . 'signature='.$signature);


    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

    if ($method == 'POST') {
        curl_setopt($curl, CURLOPT_POST, sizeof($args));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
    }
    if ($method == 'PUT') {
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
    }

    //@curl_setopt($curl, CURLOPT_HTTPHEADER, "Authorization: Basic " . base64_encode(HTTP_USER . ":" . HTTP_PWD));
    // Lấy Data
    $data = curl_exec($curl);
    $error = curl_error($curl);
    //var_dump($error);
    $httpStatus = curl_getinfo($curl);
    $result = json_decode($httpStatus, false);
    var_dump($result);die;
    echo '<pre>';print_r($httpStatus);echo '</pre>';
//    $data = strip_tags($data, '<span>,<div>,<script><ul><li><title><meta><link>');
    print_r($data);
}

?>