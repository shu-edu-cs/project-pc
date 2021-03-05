<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function index(){
      $this->display();
    }

    public function loadMore(){
    	$limit_num=5;
    	$dataModel=new \Home\Model\marketbook();
	     $limit_start=0;
	     if(isset($_GET['page'])){
	     	$page=$_GET['page'];
	     	$limit_start=($page-1)*$limit_num;
	     }
	     $condition="";
	     if(isset($_GET['keyword']) && $_GET['keyword']!=''){
	     	$keyword=$_GET['keyword'];
	     	$keyword=str_replace("'", " ", $keyword);
	     	$condition=" where book_name like '%".$keyword."%' or author like '%".$keyword."%' ";
	     }
		
		$dataArray = $dataModel->getModelList($condition,$limit_start,$limit_num);
		echo json_encode($dataArray);
    }

    public function support(){

    	if(!isset($_POST['bookId']) && $_POST['bookId']>0){
    		echo '{"status":201,"msg":"请求数据异常"}';
    		return;
    	}
    	$ip=$this->get_real_ip();
    	$bookId=$_POST['bookId'];
    	$bookModel=new \Home\Model\marketbook();
    	$logModel=new \Home\Model\supportlog();
    	$data=$logModel->queryCheck($bookId,$ip);
    	if(count($data)>0){
    		echo '{"status":202,"msg":"你已经赞过了"}';
    		return;
    	}
    	$logModel->add($bookId,$ip);
    	$bookModel->bookSupport($bookId);
    	echo '{"status":200,"msg":"点赞成功"}';
    }

    function get_real_ip()
    {
	    $ip=FALSE;
	    //客户端IP 或 NONE
	    if(!empty($_SERVER["HTTP_CLIENT_IP"])){
	        $ip = $_SERVER["HTTP_CLIENT_IP"];
	    }
	    //多重代理服务器下的客户端真实IP地址（可能伪造）,如果没有使用代理，此字段为空
	    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	        $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
	        if ($ip) { array_unshift($ips, $ip); $ip = FALSE; }
	        for ($i = 0; $i < count($ips); $i++) {
	            if (!eregi ("^(10│172.16│192.168).", $ips[$i])) {
	                $ip = $ips[$i];
	                break;
	            }
	        }
	    }
	    //客户端IP 或 (最后一个)代理服务器 IP
	    return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
	}

	public function detail(){
		$model=array();
		if(isset($_GET['id'])&&$_GET['id']>0){
			$dataModel=new \Home\Model\marketbook();
			$data=$dataModel->getModel($_GET['id']);
			if(count($data)>0){
				$model=$data[0];
			}
		}
		$this->assign('model',$model);
		$this->display();
    }
    public function submitComment(){
    	if(!isset($_POST['bookid'])){
    		return $this->error('评论失败，图书参数异常',U('Index/index'));
    	}
    	$bookid=$_POST['bookid'];
    	$nickname=I("post.nickname");
    	$comment=I("post.comment");
    	if(empty($nickname)||strlen($comment)<10){
    		return $this->error('评论失败，评论数据不全',U('Index/detail?id='.$bookid));
    	}
    	$filter_words=$this->getMinganWords();
    	
		foreach($filter_words as $key){
			if(strstr($nickname,$key)){
				return $this->error('评论失败，昵称里面包含敏感文字',U('Index/detail?id='.$bookid));
	        }
	        if(strstr($comment,$key)){
				return $this->error('评论失败，评论内容里面包含敏感文字',U('Index/detail?id='.$bookid));
	        }
	    }
		$model=new \Home\Model\bookcomment();
		$ip=$this->get_real_ip();
		$data=$model->queryCheck($bookid,$ip);
		if(count($data)>=3){
			return $this->error('此书你已评论过多，看看其他书籍吧！！',U('Index/index'));
		}
		$model->add($bookid,$ip,$nickname,$comment);
		$this->success('评论成功',U('Index/detail?id='.$bookid));
    }

    public function loadMoreComment(){
    	$limit_num=5;
    	$dataModel=new \Home\Model\bookcomment();
	     $limit_start=0;
	     if(isset($_GET['page'])){
	     	$page=$_GET['page'];
	     	$limit_start=($page-1)*$limit_num;
	     }
		
		$dataArray = $dataModel->getPage($_GET['bookid'],$limit_start,$limit_num);
		echo json_encode($dataArray);
    }


    //获取敏感词文件
    private  function getMinganWords(){
        $shehuangwords=file_get_contents(APP_PATH."/sensi_words.txt");
       // $shehuangwords=iconv("GBK","UTF-8",$shehuangwords);
        $shehuangword_arr=explode("\r\n",$shehuangwords);
        return $shehuangword_arr;
    }
   
}
?>