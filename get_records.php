<?php

include("connection.php");
include("functions.php");

    $query = "";
    $exit = array();
    $query = "SELECT * FROM users ";

    if(isset($_POST["search"]["value"])) {
        $query .= 'WHERE name LIKE "%' . $_POST["search"]["value"] . '%" ';
        $query .= 'OR name LIKE "%' . $_POST["search"]["value"] . '%" ';
    }

    if(isset($_POST["order"])) {
        $query .= 'ORDER BY' . $_POST['order']['0']['column'] . ' ' . 
        $_POST['order'][0]['dir'] . ' ';
    } else{
        $query .= 'ORDER BY id DESC ';
    }

    if($_POST["length"] != -1){
        $query .= 'LIMIT ' . ($_POST["start"] . ',' . ($_POST["length"]));
    }

    $stmt = $connection->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $data = array();
    $filtered_rows = $stmt->rowCount();

    foreach($result as $row){
        $image = '';
        if($row["image"] != ''){
            $image = '<img src="img/' . $row['image'] . '" class="img-thumbnail"
            width="50" height="50"';
        } else{
            $image = '';
        }

        $sub_array = array();
        $sub_array[] = $row["id"];
        $sub_array[] = $row["name"];
        $sub_array[] = $row["last_name"];
        $sub_array[] = $row["phone"];
        $sub_array[] = $row["email"];
        $sub_array[] = $image;
        $sub_array[] = $row["creation_date"];
        $sub_array[] = '<button type="button" name="edit" id="' . $row["id"] . '"
        class="btn btn-warning btn-xs edit">Edit</button>';
        $sub_array[] = '<button type="button" name="delete" id="' . $row["id"] . '"
        class="btn btn-warning btn-xs delete">Delete</button>';
        $data = $sub_array;
    }

    $exit = array(
        "draw" => intval($_POST["draw"]),
        "recordsTotal" => $filtered_rows,
        "recordsFiltered" => get_all_records(),
        "data" => $data
    );

    echo json_encode($exit);
