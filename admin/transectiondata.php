<?php

// database connection

require('./include/config.php');
// header('Content-Type: application/json');
$column  = array("id", "username", "amount", "transectionid", "date", "status");

$query = "SELECT * FROM transection ";

if (isset($_POST['search']['value'])) {
    $query .= '
    WHERE id LIKE "%' . $_POST['search']['value'] . '%" 
    or username LIKE "%' . $_POST['search']['value'] . '%" 
    OR amount LIKE "%' . $_POST['search']['value'] . '%" 
    OR transectionid LIKE "%' . $_POST['search']['value'] . '%" 
    OR date LIKE "%' . $_POST['search']['value'] . '%" 
    OR status LIKE "%' . $_POST['search']['value'] . '%" 
    OR date LIKE "%' . $_POST['search']['value'] . '%" 
    ';
}

if (isset($_POST['order'])) {
    $query .= 'ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= 'ORDER BY id ASC ';
}

$query1 = '';

if ($_POST['length'] != -1) {
    $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connection->prepare($query);
$statement->execute();

$number_filer_row = $statement->rowCount();


$statement = $connection->prepare($query . $query1);
$statement->execute();

$result = $statement->fetchAll();


$data = array();

foreach ($result as $row) {
    $sub_array = array();
    $sub_array[] = $row['id'];
    $id = $row['id'];
    $sub_array[] = $row['username'];
    $sub_array[] = $row['amount'];
    $sub_array[] = $row['transectionid'];
    $date = $row['date'];
    $date = strtotime($date);
    $date = date('d-M-Y', $date);
    $sub_array[] = $date;
    $status = $row['status'];
    if ($status == "accepted") {
        $sub_array[] = "<span class='badge badge-primary'>$status</span>";
    } elseif ($status == 'rejected') {
        $sub_array[] = "<span class='badge badge-danger'>$status</span>";
    } elseif ($status == 'completed') {
        $sub_array[] = "<span class='badge badge-success'>$status</span>";
    } elseif ($status == 'complete') {
        $sub_array[] = "<span class='badge badge-success'>$status</span>";
    }
    $sub_array[] = "<a class='text-success fas fa-eye' href='transectionview?view=$id'></a>";

    $data[] = $sub_array;
}

function count_all_data($connection)
{
    $query = "SELECT * FROM transection";
    $statement = $connection->prepare($query);
    $statement->execute();
    return $statement->rowCount();
}

$output = array(
    'draw' => intval($_POST['draw']),
    'recordsTotal' => count_all_data($connection),
    'recordsFiltered' => $number_filer_row,
    'data' => $data
);

echo json_encode($output);
