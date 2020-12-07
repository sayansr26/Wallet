<?php 

// getting database connection

require('connection.php');

// starting query for getting data

$query = "SELECT * FROM w_request ORDER BY id ASC";

$statement = $connection->prepare($query);
$statement->execute();
$count = $statement->rowCount();

if($count > 0){
    $delimiter = ",";
    $filename = "withdraw_requests_" .date('Y-m-d') . ".csv";

    // create file pointer
    $f = fopen('php://memory', 'w');

    // set column header

    $fields = array(
        'Id','Username','Diamonds','Date','Status'
    );
    fputcsv($f,$fields,$delimiter);
    //output each row of the data, format line as csv and write to file pointer
    while($row=$statement->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $linedata = array(
            $row['id'],$row['username'],$row['coins'],$row['date'],$row['status']
        );
        fputcsv($f,$linedata,$delimiter);
    }
    //move back file on the beginning of the line
    fseek($f, 0);
    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    //output all remaining data on a file pointer
    fpassthru($f);
}
exit;
?>