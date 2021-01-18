<?php

// database connection

require('./include/config.php');
// header('Content-Type: application/json');
$column  = array("fname", "email", "phone", "username", "balance");

$query = "SELECT * FROM user_data ";

if (isset($_POST['search']['value'])) {
    $query .= '
    WHERE fname LIKE "%' . $_POST['search']['value'] . '%" 
    OR email LIKE "%' . $_POST['search']['value'] . '%" 
    OR phone LIKE "%' . $_POST['search']['value'] . '%" 
    OR username LIKE "%' . $_POST['search']['value'] . '%" 
    OR balance LIKE "%' . $_POST['search']['value'] . '%" 
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
    $sub_array[] = $row['fname'];
    $sub_array[] = $row['email'];
    $sub_array[] = $row['phone'];
    $sub_array[] = $row['username'];
    $sub_array[] = $row['balance'];

    $data[] = $sub_array;
}

function count_all_data($connection)
{
    $query = "SELECT * FROM user_data";
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
