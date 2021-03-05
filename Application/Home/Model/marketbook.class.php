<?php
namespace Home\Model;
use Think\Model;
class marketbook{
 
  public function getModelList($condition,$limit_start,$limit_num){
     $model = M("market_book");
     $sql="select id,book_name,public_name,author,publish_year,remark,support_count from market_book";
     return $model->query($sql.$condition." order by id desc limit $limit_start,$limit_num");
  }

  public function bookSupport($id){
    $model = M("market_book");
     return $model->execute("update market_book set support_count=support_count+1 where id=".$id);
  }

  public function getModel($id){
     $model = M("market_book");
     $sql="select * from market_book where id=".$id." limit 1";
     return $model->query($sql);
  }

}   
?>