<?php
    $login = $_POST["login"];
    $password = $_POST["password"];

    $response = array();

    if (empty($login)) {
        $response["loginError"] = "Имя пользователя не может быть пустым";
    } else if (!preg_match("/^[a-zA-Z0-9]+$/", $login)) {
        $response["loginError"] = "Имя пользователя должно содержать только буквы и цифры";
    }

    if (empty($password)) {
        $response["passwordError"] = "Пароль не может быть пустым";
    } else if (strlen($password) < 8) {
        $response["passwordError"] = "Пароль должен быть не менее 8 символов";
    }

    echo json_encode($response);
    ?> 