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
        pre {
            width: 100%;
            padding: 0;
            margin: 0;
            overflow: auto;
            overflow-y: hidden;
            font-size: 12px;
            line-height: 20px;
            background: #efefef;
            border: 1px solid #777;
            background: url(lines.png) repeat 0 0;
        }
        pre code {
            padding: 10px;
            color: #333;
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
                <li class="nav-item active">
                    <a class="nav-link" href="/">Table</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="row">
        <div class="col-md-12">
            <pre>
                <code>
                    <?php print_r($packages->packages) ?>
                </code>
            </pre>
        </div>
    </div>
</body>
</html>