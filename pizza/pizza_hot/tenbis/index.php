<?php 
    // ini_set('display_errors', true);
    // error_reporting(E_ALL);
    require_once "./../php/connection.php";
    require './../vendor/autoload.php';
    require_once './../php/tenbis_orders.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="./../css/bootstrap.css">    
    <link rel="stylesheet" href="./../css/datatables.css">
    <style>
        body{
            margin-top: 50px;
        }
    </style>    
</head>
<body class="container">
    <table id="_table" class="table">
        <thead>
            <tr>
                <th>Branch</th>
                <th>Order ID</th>
                <th>Order Number</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Status</th>
                <th>DB Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data as $dt): ?>
                <tr>
                    <td><?php echo $dt['restname'] ?></td>
                    <td><?php echo $dt['external_number'] ?></td>
                    <td><?php echo $dt['order_id'] ?></td>
                    <td><?php echo $dt['name'] ?></td>
                    <td><?php echo $dt['phone'] ?></td>
                    <td><?php echo $dt['status'] ?></td>
                    <td><?php echo $dt['db_status'] ?></td>
                    <td><?php echo $dt['updated_at'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
   
    <script src="./../js/jquery.js"></script>
    <script src="./../js/datatables.js"></script>
    <script>
        $(document).ready(function() {
            $('#_table').DataTable();
        } );
    </script>
</body>
</html>