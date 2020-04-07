<?php

// ini_set('display_errors', true);
// error_reporting(E_ALL);

// require_once "./connection.php";
// require './../vendor/autoload.php';

use GuzzleHttp\Client;

function date_to_time($date){
    return date("H:i:s",strtotime($date)); 
}
function get_data($config){
    $url = "https://restapi.mysodexo.co.il/api/main.py";
    $client = new Client([
        'headers' => [ 'Content-Type' => 'application/json' ]
    ]);
    $response = $client->post($url,
        ['body' => json_encode($config)]
    );
    $res =  $response->getBody()->getContents();
    $res = json_decode($res);   
    return $res;
}


$res = get_data([
    "type" => "rest_contact_login",
    "user_login_name" => "net_3009_contact",
    "user_login_pswd" => "1234"
]);

$token = $res->token;


$packages = get_data([
    "type" => "get_packages",
    "expand" => "orders",
    "token" => $token
]);
// echo '<pre>';
// print_r($packages);
// echo '</pre>';
// die();

$query = [];
$ids = [];

foreach($packages->packages as $std){
    $query[] = $std->ID;

    // echo '<pre>';
    // print_r($std);
    // echo '</pre>';
    // die();

    //for packagez show on page
    
    // $orders = $package->package->orders;
    $order_products = [];
    if(isset($std->orders)){    
        foreach($std->orders as $ord){
            foreach($ord->requestedElements as $or){
                $arr = [];
                $order_products[$or->dishName] = $or->dishQuantity;
                if(!empty($or->sideDishGroups)){
                    foreach($or->sideDishGroups as $side_group){
                        foreach($side_group as $side_dishes){
                            if(is_array($side_dishes)){
                                foreach($side_dishes as $side_dish){
                                    $order_products["<p class='tosefet'>".$side_dish->sideDishName."</p>"] = $side_dish->sideDishQuantity;                        
                                }
                            }            
                        }
                    }
                }
            }
        }
    }
    // echo '<pre>';
    // print_r($order_products);
    // echo '</pre>';
    // die();

    $ids[] = [
        "restname"        => $std->RestName,
        "phone"           => ' - ', 
        "name"            => ' - ',
        'updated_at'      => date_to_time($std->toTime), 
        'status'          => $std->status,
        'order_id'        => ' - ',
        'db_status'       => ' - ',
        'completed'       => ' - ',
        'external_number' => $std->ID,
        'order_products'  => $order_products ,
        'overTheMin'       => $std->overTheMin
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

$stmt = $conn->prepare("SELECT phone, status_id, `number`, CONCAT(first_name, ' ',last_name ) as name, updated_at, external_number FROM orders WHERE external_number IN (".implode(',', $query).")"); 
$stmt->execute();


$stmt->setFetchMode(PDO::FETCH_ASSOC); 

$result =  $stmt->fetchAll();

$states = ['','queue', 'sent', 'failed'];
$good = [];
$i = 0;

foreach($ids as $id){
    $is_good = false;
    foreach($result as $res){
        if($res['external_number'] == $id['external_number']){
            $is_good = true;
            $good[] = [
                "restname"        => $id['restname'],
                "phone"           => $res['phone'], 
                "name"            => $res['name'],
                'updated_at'      => date_to_time($id['updated_at']), 
                'status'          => $id['status'],
                'order_id'        => $res['number'],
                'db_status'       => $states[$res['status_id']],
                'completed'       => date_to_time($res['updated_at']),
                'external_number' => $res['external_number'],
                'order_products'  => $id['order_products'],
                'overTheMin'       => $id['overTheMin']
            ];
        } 
    }
    if(!$is_good) $good[] = $id;
    $i++;
}

$data = $good;
