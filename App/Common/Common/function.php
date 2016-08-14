<?php
/*
 * 多语言拼接函数
 */
function lang($world){
    $array = explode('_',$world);
    $lang  = '';
    foreach($array as $value){
        if($value) $lang .= L($value);
    }
    return $lang;
}

/*
 * 密码加密
 */
function password($password){
    $pwd = trim($password);
    return hash_hmac('md5',md5($pwd),$pwd);
}

/*
 * 判断字符串含有字符
 */
function checkstr($needle,$str){
    $tmparray = explode($needle,$str);
    if(count($tmparray)>1){
        return true;
    } else{
        return false;
    }
}
/*
 * @功能:curl 主动发送http请求
 * @参数:$url:请求的url,$method:请求的方式：get,post,delete,put,$postfields:需要发送的数据，要求为数组格式,$headers：头部
 * @返回：返回请求返回的结果
 */
function http( $url, $method = 'GET', array $postfields = array(), array $headers = array() ){
    $ci = curl_init();
    /* Curl settings */
    curl_setopt( $ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0 );
    curl_setopt( $ci, CURLOPT_CONNECTTIMEOUT, 30 );
    curl_setopt( $ci, CURLOPT_TIMEOUT, 30 );
    curl_setopt( $ci, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ci, CURLOPT_ENCODING, 'gzip' );
    curl_setopt( $ci, CURLOPT_FOLLOWLOCATION, true );
    curl_setopt( $ci, CURLOPT_MAXREDIRS, 5 );
    curl_setopt( $ci, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ci, CURLOPT_HEADER, false );

    switch( strtoupper( $method ) )
    {
        case 'POST':
            curl_setopt( $ci, CURLOPT_POST, true );
            if ( !empty( $postfields ) )
            {
                curl_setopt( $ci, CURLOPT_POSTFIELDS, http_build_query( $postfields ) );
            }
            break;
        case 'DELETE':
            curl_setopt( $ci, CURLOPT_CUSTOMREQUEST, 'DELETE' );
            if ( !empty( $postfields ) )
            {
                $url = "{$url}?" . http_build_query( $postfields );
            }
            break;
        case 'GET':
            if ( !empty( $postfields ) )
            {
                $url = "{$url}?" . http_build_query( $postfields );
            }
            break;
    }

    curl_setopt($ci, CURLOPT_URL, $url );
    curl_setopt($ci, CURLOPT_HTTPHEADER, $headers );
    curl_setopt($ci, CURLINFO_HEADER_OUT, true );

    $response = curl_exec( $ci );
    curl_close ($ci);
    return $response;
}