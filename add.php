<?php
    require_once ('helpers.php');
    require_once ('functions.php');
    $required_fields = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];
    $errors = array();
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["submit"])) {
        foreach ($required_fields as $field) {
            if (readPOST($field) == false) {
            $errors[$field] = 'Поле не заполнено';
            }
            else {
            $_POST[$field] = test_input($_POST[$field]);
            }
        }
        $name = readPOST('lot-name');
        $category = readPOST('category');
        $message = readPOST('message');
        $lot_rate = (int)readPOST('lot-rate');
        $lot_step = (int)readPOST('lot-step');
        $lot_date = readPOST('lot-date');
        if (null !== $name) {
                if (strlen($name) <= 0 || strlen($name) > 10) {
                    $errors['lot-name'] = 'Длина имени лота должна быть от 0 до 50 символов';
            }
        }
        if (null !== $lot_date) {
            if (false === is_date_valid($lot_date)) {
                $errors['lot-date'] = 'Неверный формат даты';
            } 
            else {
                $time_1 = strtotime("now");
                $exp_stamp = strtotime($lot_date);
                $time_result = $exp_stamp - $time_1;
                $sutki = 86400;
                if ($time_result < $sutki) {
                    $errors['lot-date'] = 'Указанная дата должна быть больше текущей даты, хотя бы на один день';
                }
            }
        }   
        if (null !== $lot_rate) {
            if (!is_int($lot_rate) || $lot_rate <= 0) {
                $errors['lot-rate'] = 'Введите целое число больше нуля';
            }
        }
        if (null !== $lot_step) {
            if (!is_int($lot_step) || $lot_step <= 0) {
                $errors['lot-step'] = 'Введите целое число больше нуля';
            }
        }
        if (isset($_FILES['file'])) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_name = $_FILES['file']['tmp_name'];
            $file_size = $_FILES['file']['size'];
            $file_type = finfo_file($finfo, $file_name);
            if ($file_type !== 'image/png') {
                $errors['file'] = 'Загрузите картинку в нужном формате';
            } else {
                $file_path = 'uploads/' . $_FILES['file']['name'];
                move_uploaded_file($_FILES['file']['tmp_name'], $file_path);
            }
        }
        if (empty($errors)) {
        $con = connection();
        $sql = "INSERT INTO lot (title, description, img, start_price, expiration_date, bet_step, category_id) VALUES ((?), (?), (?), (?), (?), (?), (?))";
        $stmt = db_get_prepare_stmt($con, $sql, $data=[$name, $message, $file_path, $lot_rate, $lot_date, $lot_step, $category]);
        mysqli_stmt_execute($stmt);
        //Редирект, если нет ошибок
        $sql_for_id = "SELECT MAX(`id`) FROM lot";
        $result = mysqli_query($con, $sql_for_id);
        $rows = mysqli_fetch_assoc($result);
        $new_lot_id = $rows['MAX(`id`)'];
        header("Location: lot.php?id=".$new_lot_id);
        } else {
            print_r($errors);
        }
    }
    $con = connection();
    $categories_list = get_categories($con);
    $content = include_template('add.php', ['categories_list' => $categories_list, 'errors' => $errors]);
    $page = include_template('layout.php', ['main' => $content, 'title' => 'Добавление лота', 'categories_list' => $categories_list]);
    echo $page;
?>