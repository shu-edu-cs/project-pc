<?php
namespace Home\Model;
use Think\Model;
class supportlog{
 
  public function queryCheck($bookId,$ip){
     $model = M("support_log");
     $sql="select id from support_log where ip_address='".$ip."' and book_id=".$bookId;
     return $model->query($sql);
  }

  public function add($bookId,$ip){
     $model = M("support_log");
     $data['ip_address']=$ip;
     $data['book_id']=$bookId;
     $data['create_time']=date("Y-m-d H:i:s");
     return $model->data($data)->add();
  }

}   
?>