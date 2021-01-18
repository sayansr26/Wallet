<?php

// database connection

require('./include/config.php');
// header('Content-Type: application/json');
$column  = array("banificary", "account", "ifsc", "bank_name", "phone");

$query = "SELECT * FROM accounts ";

if (isset($_POST['search']['value'])) {
    $query .= '
    WHERE banificary LIKE "%' . $_POST['search']['value'] . '%" 
    OR account LIKE "%' . $_POST['search']['value'] . '%" 
    OR ifsc LIKE "%' . $_POST['search']['value'] . '%" 
    OR bank_name LIKE "%' . $_POST['search']['value'] . '%" 
    OR phone LIKE "%' . $_POST['search']['value'] . '%" 
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
    $sub_array[] = $row['phone'];
    $sub_array[] = $row['account'];
    $sub_array[] = $row['ifsc'];
    $sub_array[] = $row['bank_name'];
    $sub_array[] = $row['banificary'];

    $data[] = $sub_array;
}

function count_all_data($connection)
{
    $query = "SELECT * FROM accounts";
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
