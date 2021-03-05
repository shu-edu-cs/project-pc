<?php
namespace Home\Model;
use Think\Model;
class bookcomment{
 
  public function queryCheck($bookId,$ip){
     $model = M("book_comment");
     $sql="select id from book_comment where ip_address='".$ip."' and book_id=".$bookId;
     return $model->query($sql);
  }

  public function add($bookId,$ip,$name,$content){
     $model = M("book_comment");
     $data['ip_address']=$ip;
     $data['book_id']=$bookId;
     $data['create_time']=date("Y-m-d H:i:s");
     $data['nick_name']=$name;
     $data['comment_content']=$content;
     return $model->data($data)->add();
  }

  public function getPage($bookId,$limit_start,$limit_num){
     $model = M("book_comment");
     $sql="select nick_name,comment_content,create_time from book_comment where book_id=".$bookId;
     return $model->query($sql." order by id desc limit $limit_start,$limit_num");
  }

}   
?>