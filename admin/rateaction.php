
<?php

require('./include/config.php');

if ($_POST['action'] == 'edit') {
    $data = array(
        ':rate' => $_POST['rate'],
        ':id' => $_POST['id']
    );


    $query = "
    UPDATE exchnage_rate 
    SET rate = :rate 
    WHERE id = :id
    ";

    $statement = $connection->prepare($query);
    $statement->execute($data);

    echo json_encode($_POST);
}

if ($_POST['action'] == 'delete') {
    $query  = "
    DELETE FROM exchnage_rate 
    WHERE id = '" . $_POST['id'] . "'
    ";

    $statement = $connection->prepare($query);
    $statement->execute();
    echo json_encode($_POST);
}
