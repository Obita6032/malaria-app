<?php 
 require_once('config.php');

 $query ="SELECT date, value FROM charts";
 $result =mysqli_query($dsn,$query);

 //format the data

 $data = [];
 while($row=mysqli_fetch_assoc($result)){
    $data[]=[
        'x'=>strtotime($row['date']) *1000,'y'=> intval($row['value'])
    ];
 }
 //configure the heights
 $ChartOptions =[
    'chart'=>[
        'type'=>'line'
    ],
    'series' =>[
        [
            'name'=> 'Data',
            'data'=>$data
        ]
    ]
        ];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DYNAMIC HIGHCHARTS CHART</title>
    <script src="https://code.highcharts.com/highcharts.js"></script>

</head>
<body>
    <div id="chartContainer"></div>

    //render the curl_share_strerror
    <script>
        Highcharts.chart('chartContainer', <?php echo json_encode($ChartOptions)?>);
    </script>
    
</body>
</html>