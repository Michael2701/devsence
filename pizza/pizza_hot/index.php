<?php 
    // ini_set('display_errors', true);
    // error_reporting(E_ALL);
    require_once "./php/connection.php";
    require './vendor/autoload.php';
    require_once './php/get_orders.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="./css/bootstrap.css">    
    <link rel="stylesheet" href="./css/datatables.css">
    <style>
        pre{
            float: left;
            margin-left: -10%;
            margin-top: 35px;
        }
        table{
            z-index:1;
        }
        .tosefet{
            font-size: 90%;
        }
    </style>    
</head>
<body class="container">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <!-- <a class="navbar-brand" href="#">Navbar</a> -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="cibus.php">Packages</a>
                </li>
            </ul>
        </div>
    </nav>
    <br><br><br>
    <div class="row">
        <div class="col-md-12">
            <table id="_table" class="table">
                <thead>
                    <tr>
                        <th>Order Products</th>
                        <th>Branch</th>
                        <th>Ordered To</th>
                        <th>Order ID</th>
                        <th>Order Number</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Created At</th>
                        <th>Status</th>
                        <th>Over The Min</th>
                        <th>DB Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data as $dt): ?>
                        <tr>
                            <td>
                                <table>
                                    <?php foreach($dt['order_products'] as $key => $value): ?>
                                    <tr>
                                        <td><?php echo $value ?></td>
                                        <td><?php echo $key ?></td>
                                    </tr>                            
                                    <?php endforeach; ?>
                                </table>
                            </td>
                            <td><?php echo $dt['restname'] ?></td>
                            <td><?php echo $dt['updated_at'] ?></td>
                            <td><?php echo $dt['external_number'] ?></td>
                            <td><?php echo $dt['order_id'] ?></td>
                            <td><?php echo $dt['name'] ?></td>
                            <td><?php echo $dt['phone'] ?></td>
                            <td><?php echo $dt['completed'] ?></td>
                            <td><?php echo $dt['status'] ?></td>
                            <td><?php echo $dt['overTheMin'] == 0 ? 'No' : 'Yes' ?></td>
                            <td><?php echo $dt['db_status'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="./js/jquery.js"></script>
    <script src="./js/datatables.js"></script>
    <script>
        $(document).ready(function() {
            $('#_table').DataTable();
        });
    </script>
</body>
</html>