<?php

// подключаем файл конфигурации базы данных mysql
include_once "config/database.php";
$database = new Database();
$db = $database->getConnection();


if (isset($_POST['submit'])) {

    // Разрешенные типы mime
    $fileMimes = array(
        'text/x-comma-separated-values',
        'text/comma-separated-values',
        'application/octet-stream',
        'application/vnd.ms-excel',
        'application/x-csv',
        'text/x-csv',
        'text/csv',
        'application/csv',
        'application/excel',
        'application/vnd.msexcel',
        'text/plain'
    );

    // Проверяем, является ли выбранный файл CSV-файлом
    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $fileMimes)) {

        // Открываем загруженный CSV-файл в режиме только для чтения
        $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

        // Пропускаем первую строку
        $getHeader = fgetcsv($csvFile, 10000, ";");

        if (array_search("LOGIN", $getHeader)) {
            // Парсим (разбираем) данные из файла CSV import_users построчно
            while (($getData = fgetcsv($csvFile, 10000, ";")) !== FALSE) {
                // Получаем данные строки
                $userId = $getData[0];
                $lastName = $getData[1];
                $name = $getData[2];
                $secondName = $getData[3];
                $departmentId = $getData[4];
                $workPosition = $getData[5];
                $email = $getData[6];
                $mobilePhone = $getData[7];
                $phone = $getData[8];
                $login = $getData[9];
                $password = $getData[10];
                // Делаем запрос к базе данных
                try {
                    $query1 = "INSERT INTO users (id, login, password) 
                        VALUES ('" . $userId . "', '" . $login . "', '" . $password . "')";
                    $query2 = "INSERT INTO users_info (last_name, name, second_name,email,mobile_phone,phone,user_id) 
                        VALUES ('" . $lastName . "', '" . $name . "', '" . $secondName . "', '" . $email . "','" . $mobilePhone . "','" . $phone . "','" . $userId . "')";
                    $query3 = "INSERT INTO users_work (department_id,work_position, user_id )
                        VALUES ('" . $departmentId . "', '" . $workPosition . "', '" . $userId . "')";
                    $stmt1 = $db->prepare($query1);
                    $stmt2 = $db->prepare($query2);
                    $stmt3 = $db->prepare($query3);
                    $stmt1->execute();
                    $stmt2->execute();
                    $stmt3->execute();
                } catch (PDOException $exception) {
                    echo 'Error: ' . $exception->getMessage() . '<p><a class="btn" href="index.php">Back</a></p>';
                    die();
                }

            }
            echo($_FILES['file']['name'] . ' parsing success <p><a class="btn" href="index.php">Back</a></p>');
        } else {
            // Парсим (разбираем) данные из файла CSV import_department построчно
            while (($getData = fgetcsv($csvFile, 10000, ";")) !== FALSE) {
                $departmentId = $getData[0];
                $parentId = $getData[1];
                $department = $getData[2];
                try {
                    $query1 = "INSERT INTO department (id, parent_id, name_department) VALUES ('" . $departmentId . "', '" . $parentId . "', '" . $department . "')";
                    $stmt1 = $db->prepare($query1);
                    $stmt1->execute();
                } catch (PDOException $exception) {
                    echo 'Error: ' . $exception->getMessage() . '<p><a class="btn" href="index.php">Back</a></p>';
                    die();
                }
            }
            echo($_FILES['file']['name'] . ' parsing success <p><a class="btn" href="index.php">Back</a></p>');
        }
        // Сохранение файла в папку upload
        if (0 < $_FILES['file']['error']) {
            echo 'Error: ' . $_FILES['file']['error'] . '<br>';
        } else {
            move_uploaded_file($_FILES['file']['tmp_name'], 'upload/' . $_FILES['file']['name']);
        }
        // Закрываем открытый CSV-файл
        fclose($csvFile);
    } else {
        echo "Please select valid file";
    }
}