<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require 'vendor/autoload.php';

    use Zendesk\API\HttpClient as ZendeskAPI;

    $token     = "wCIkQ5uLqOqCKhDil8ETIhzJjFnvS9HvKQb5Kshi";
    $username  = "zendesk@pizzahut.co.il";
    $subdomain = "pizzahut151531209272";

    $client = new ZendeskAPI($subdomain);
    $client->setAuth('basic', ['username' => $username, 'token' => $token]);

    $before_week = date('Y-m-d', strtotime('-7 days'));
    $response = $client->search()->find("type:ticket created<$before_week", ['sort_by' => 'updated_at']);
    $tickets = $response->results;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body class="container">
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Subject</th>
                        <th>Description</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Url</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tickets as $ft) : ?>
                        <tr>
                            <td><?php echo $ft->id; ?></td>
                            <td><?php echo $ft->subject; ?></td>
                            <td style="max-width:900px"><?php echo $ft->description; ?></td>
                            <td><?php echo date('Y-m-d H:i:s', strtotime($ft->created_at)); ?></td>
                            <td><?php echo date('Y-m-d H:i:s', strtotime($ft->updated_at)); ?></td>
                            <td><a target="_blank" href="<?php echo $ft->url; ?>">Link</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html> 