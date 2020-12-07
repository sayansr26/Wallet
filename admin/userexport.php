<?php 

// getting database connection

require('connection.php');

// starting query for getting data

$query = "SELECT * FROM user_info ORDER BY id ASC";

$statement = $connection->prepare($query);
$statement->execute();
$count = $statement->rowCount();

if($count > 0){
    $delimiter = ",";
    $filename = "user_info_" .date('Y-m-d') . ".csv";

    // create file pointer
    $f = fopen('php://memory', 'w');

    // set column header

    $fields = array(
        'Id','Name','Email','Username','Phone','Refer By','Refer Link', 'Reg Date', 'Points', 'Pay Account', 'Pay Mode', 'Pincode', 'Country', 'State', 'City', 'Address', 'Gender', 'DOB'
    );
    fputcsv($f,$fields,$delimiter);
    //output each row of the data, format line as csv and write to file pointer
    while($row=$statement->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $linedata = array(
            $row['id'],$row['name'],$row['email'],$row['username'],$row['phone'],$row['refer_by'],$row['refer_link'],$row['reg_date'],$row['points'],$row['paccount'],$row['pmode'],$row['pincode'],$row['country'],$row['state'],$row['city'],$row['address'],$row['gender'],$row['dob']
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