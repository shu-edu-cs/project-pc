<?php
	/*唯一编号,数值型 */
	function microtime_pk_id()
	{
	    $time_array = explode(" ", microtime());
	    return substr($time_array[1], 1).substr($time_array[0], 2,5).rand(1000,9999);
	}
	/*生成guid*/
	function create_guid() {
	   mt_srand ( ( double ) microtime () * 10000 ); // optional for php 4.2.0 and up.
	   $charid = strtoupper ( md5 ( uniqid ( rand (), true ) ) );
	   $hyphen = chr ( 45 ); 
	   $uuid = substr ( $charid, 0, 8 ) . $hyphen . substr ( $charid, 8, 4 ) . $hyphen . substr ( $charid, 12, 4 ) . $hyphen . substr ( $charid, 16, 4 ) . $hyphen . substr ( $charid, 20, 12 ); 
	   return $uuid;
	}
	
	 /* 获取当前页面完整URL地址 */
	 function get_url() {
	    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
	    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
	    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
	    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
	    return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
	 }
	/* 提交请求
	* @param $data string 需要提交的数据 'user=xxx&qq=xxx&id=xxx&post=xxx'....
	* @param $url string 要提交的url 'http://192.168.1.12/xxx/xxx/api/';
	*/
 	function curl_post($url,$data,$timeout=5)
    {
	   $headerArray[] ='token:' . cookie('loginToken');  
	   $headerArray[] ='Content-Type:application/json;charset=UTF-8';
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL,C("API_URL").$url);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_HEADER, 0);
       curl_setopt($ch, CURLOPT_POST, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_HTTPHEADER,$headerArray);
       curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
       $result = curl_exec ($ch);
       curl_close($ch);
      writeLog("接口地址：".$url."，参数：".$data."，返回结果：".$result);
       if ($result == NULL) {
          return "接口调用失败";
       }
       $jsonData=json_decode($result,true);
       if($jsonData['code']!='200'){
          return $jsonData['msg'];
       }
       return $jsonData;
    }
    function curl_post_file($url,$data,$timeout=60)
    {
	     $headerArray[] ='token:' . cookie('loginToken');  
	     $headerArray[] ='Content-Type:multipart/form-data';
       $headerArray[] ='Expect:';
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL,C("UPLOAD_API_URL").$url);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_HEADER, 0);
       curl_setopt($ch, CURLOPT_POST, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_HTTPHEADER,$headerArray);
       curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
       $result = curl_exec ($ch);
       curl_close($ch);
       writeLog("上传接口地址：".$url."，参数：".json_encode($data)."，返回结果：".$result);
       if ($result == NULL) {
           return 0;
       }
       return $result;
    }

  
	/*生成数字随机数*/	
	function rand_number($min, $max) {
		return sprintf("%0".strlen($max)."d", mt_rand($min,$max));
	 }
	
	//日志记录
    function writeLog($log_content)
    {
        file_put_contents("log/".date('Y-m-d').".txt", date('Y-m-d H:i:s')." ".$log_content."\r\n", FILE_APPEND);
    }
/**
 * 二维数组根据某个字段排序
 * @param array $array 要排序的数组
 * @param string $keys   要排序的键字段
 * @param string $sort  排序类型  SORT_ASC     SORT_DESC 
 * @return array 排序后的数组
 */
function arraySort($array, $keys, $sort = SORT_ASC) {
    $keysValue = [];
    foreach ($array as $k => $v) {
        $keysValue[$k] = $v[$keys];
    }
    array_multisort($keysValue, $sort, $array);
    return $array;
}
function checkLogin(){
  if(cookie("loginToken")==null){
    return false;
  }
  return true;
}
function checkAdminLogin(){
  if(strtolower(cookie("loginName"))!="admin"){
    return false;
  }
  return true;
}

?>