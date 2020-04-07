<?php

// require_once "./connection.php";
// require './../vendor/autoload.php';

use GuzzleHttp\Client;

    function rand_str($len=12){
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($permitted_chars), 0, $len);    
    }

    function get_data($url){
        $client = new Client([
            'headers' => [ 'Content-Type' => 'application/json' ]
        ]);
        $response = $client->request('GET',$url);
        $res =  $response->getBody()->getContents();
        $res_array = json_decode($res);
        return $res_array;        
    }

    $code1 = rand_str();
    $url = "https://www.10bis.co.il/api/reshome/v2/reshomeservice.svc/Login/pizzaHutOrdersInPos/16pi87zza/21138/$code1";
    $res_array  = get_data($url);
    $token = $res_array->Data->Token;

    // print_r($token);
    // die(); 

    $code2 = rand_str();
    $url2 = "https://www.10bis.co.il/api/reshome/v2/reshomeservice.svc/GetTodaysOrders/$token/All/$code2";
    $packages  = get_data($url2);
    $orders = $packages->Data;

    // echo '<pre>';
    // print_r($orders);
    // echo '</pre>';
    // die(); 

    $data = [];

    foreach($orders as $order){
        
        $order_id = $order->OrderID;
        $pool_id = $order->PoolID;

        if($order_id != '0'){
            $code3 = rand_str();
            $url3 = "https://www.10bis.co.il/api/reshome/v2/reshomeservice.svc/GetSingleOrder/$order_id/$token/$code3";
            $data[] = get_data($url3);
        }
        if($pool_id != 0){

        }
    }

    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';
    // die(); 

    $query = [];
    $ids = [];
    
    foreach($data as $std){
        $query[] = $std->Data->Order->OrderId;
        $ids[] = [
            "restname"        => $std->Data->Order->restaurant->FullAddress,
            "phone"           => $std->Data->Order->Header->UserPhone, 
            "name"            => $std->Data->Order->user->FirstName.$std->Data->Order->user->LastName,
            'updated_at'      => $std->Data->Order->Times->entered->EnteredDate, 
            'status'          => $std->Data->orderStatus,
            'order_id'        => $std->Data->Order->OrderId,
            'db_status'       => ' - ',
            'external_number' => ' - '
        ];
    }

    // echo '<pre>';
    // print_r($ids);
    // echo '</pre>';
    // die();

    if(count($query) == 0){
        $data = [];
        return;
    }

    $stmt = $conn->prepare("SELECT phone, status_id, `number`, CONCAT(first_name, last_name ) as name, updated_at, external_number FROM orders WHERE external_number IN (".implode(',', $query).")"); 
    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC); 

    $result =  $stmt->fetchAll();

    $states = ['','queue', 'sent', 'failed'];
    $good = [];
    $i = 0;

    foreach($ids as $id){
        foreach($result as $res){
            if($res['external_number'] == $id['external_number']){
                $good[] = [
                    "restname"        => $res['restname'],
                    "phone"           => $res['phone'], 
                    "name"            => $res['name'],
                    'updated_at'      => $res['updated_at'], 
                    'status'          => $id['status'],
                    'order_id'        => $res['number'],
                    'db_status'       => $states[$res['status_id']],
                    'external_number' => $res['external_number']
                ];
                unset($ids[$i]);
            } 
        }
        $i++;
    }

    $data = array_merge($ids, $good);