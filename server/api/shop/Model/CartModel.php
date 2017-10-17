<?php

class CartModel extends Model
{

public function createCart($params)
{
    try{
        $sth = $this->pdo->prepare('INSERT INTO cart (book_id, client_id, count) '
                . 'VALUES (:book_id, :client_id, :count)');
        $sth->execute($params);
        if($this->pdo->lastInsertId()>0)
            return ['status'=>200, 'data'=>1];
         else 
            return ['status'=>500, 'clientCode'=>'0006'];
    }catch(PDOException $err){
        file_put_contents('errors.txt', $err->getMessage(), FILE_APPEND); 
        return ['status'=>500, 'clientCode'=>'0006'];
    }
}


public function getCountCartByClient($client_id)
{
    try{
        $sth = $this->pdo->prepare("SELECT SUM(count)as count_cart FROM cart WHERE client_id = :client_id");
        $sth->execute(['client_id' => $client_id]);
        $result = $sth->fetch(\PDO::FETCH_NUM);
        return ['status'=>200, 'data'=>$result[0]];
    }catch(PDOException $err){
        file_put_contents('errors.txt', $err->getMessage(), FILE_APPEND); 
        return ['status'=>500, 'clientCode'=>'0006'];
    }
}
/*
public function updatetCart($params)
{
     try{
        $sth = $this->pdo->prepare("UPDATE `orders_rest` SET `status` = 0 WHERE id = :id_order AND id_user=:id_user");
        $sth->execute($params);
        $count =  $sth->rowCount();
        if($count>0)
            return ['status'=>200, 'data'=>['order_update']];
         else 
             return ['status'=>500, 'data'=>['error update']];
    }catch(PDOException $err){
        file_put_contents('errors.txt', $err->getMessage(), FILE_APPEND); 
        return ['status'=>500, 'data'=>[]];
    }
}
*/
}
