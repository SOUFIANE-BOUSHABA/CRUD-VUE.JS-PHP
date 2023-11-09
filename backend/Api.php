<?php
$conn = new mysqli('localhost', 'root', '', 'crud');

// Gestion des en-têtes CORS
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 1000');
}
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
    }

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
        header("Access-Control-Allow-Headers: Accept, Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token, Authorization");
    }
    exit(0);
}
$res = array('error' => false);
$action = '';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
}
if ($action == 'addusers') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $education = $_POST['education'];
    $sec = $_POST['secondname'];
    $sql = "INSERT INTO `user`(`id`, `firstname`, `email`, `education`, `secondname`) VALUES(NULL,'$name','$email','$education','$sec')";
    $result = $conn->query($sql);
    if ($result === true) {
        $res['error'] = false;
        $res['message'] = "User Added Successfully";
    } else {
        $res['error'] = true;
        $res['message'] = "Something Went Wrong";
        $res['sql_error'] = $conn->error; 
    }
}
if ($action == 'getusers') {
    $sql = "SELECT * FROM `user`";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $users = array();
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        $res['error'] = false;
        $res['users'] = $users;
    } else {
        $res['error'] = true;
        $res['message'] = "No Users Found";
    }
}
if ($action == 'deleteuser' && isset($_GET['id'])) {
    $userId = $_GET['id'];
    $sql = "DELETE FROM `user` WHERE `id` = $userId";
    $result = $conn->query($sql);

    if ($result === true) {
        $res['error'] = false;
        $res['message'] = "User Deleted Successfully";
    } else {
        $res['error'] = true;
        $res['message'] = "Something Went Wrong";
        $res['sql_error'] = $conn->error; 
    }
}
if ($action == 'updateuser') {
    $userId = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $education = $_POST['education'];
    $secondname = $_POST['secondname'];
    $sql = "UPDATE `user` SET `firstname`='$name', `email`='$email', `education`='$education', `secondname`='$secondname' WHERE `id`='$userId'";
    $result = $conn->query($sql);
    if ($result === true) {
        $res['error'] = false;
        $res['message'] = "User Updated Successfully";
    } else {
        $res['error'] = true;
        $res['message'] = "Something Went Wrong";
        $res['sql_error'] = $conn->error;
    }
}
$conn->close();
header("Content-type: application/json");
echo json_encode($res);
die();
?>
