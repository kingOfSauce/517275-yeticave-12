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
            $_POST[$field] = test_input($field);
            }
        }
        $name = readPOST('lot-name');
        $category = readPOST('category');
        $message = readPOST('message');
        $lot_rate = readPOST('lot-rate');
        $lot_step = readPOST('lot-step');
        $lot_date = readPOST('lot-date');
        if (null !== $name) {
                if (mb_strlen($name) <= 0 || mb_strlen($name) > 50) {
                    $errors['lot-name'] = 'Длина имени лота должна быть от 0 до 50 символов';
            }
        }
        if (null !== $lot_date) {
            if (false === is_date_valid($lot_date)) {
                $errors['lot-date'] = 'Неверный формат даты';
            } 
            else if (strtotime($lot_date) < strtotime("now")) {
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
        if (!isset($_FILES['file'])) {
            $errors['file'] = 'Файл не выбран';
        } else if (mime_content_type($_FILES['file']) != 'image/png' || mime_content_type($_FILES['file'] != 'image/jpeg')) {
            $errors['file'] = 'Тип файла не подходит';
        } else {
            $file_name = $_FILES['file']['name'];
            $file_path = __DIR__ . '/uploads';
            move_uploaded_file($_FILES['file']['tmp_name']. $file_path . $file_name);
        }
        if (empty($errors)) {
        $con = connection();
        if ($category == 'Крепления') $category_id = 1;
        else if ($category == 'Куртки') $category_id = 2;
        else if ($category == 'Доски и лыжи') $category_id = 3;
        else if ($category == 'Обувь') $category_id = 4;
        else if ($category == 'Интсрументы') $category_id = 5;
        else if ($category == 'Разное') $category_id = 6;
        else $errors['category'] = 'Выбранная категория не существует';
        $sql = "INSERT INTO lot (title, description, img, start_price, expiration_date, bet_step, category_id) VALUES ((?), (?), (?), (?), (?), (?), (?))";
        $stmt = db_get_prepare_stmt($con, $sql, $data=[$_POST['lot-name'], $_POST['message'], $file_path, $_POST['lot-rate'], $_POST['lot-date'], $_POST['lot-step'], $category_id]);
        mysqli_stmt_execute($stmt);
        }
    }
    $con = connection();
    $categories_list = get_categories($con);
    $content = include_template('add.php', ['categories_list' => $categories_list]);
    $page = include_template('layout.php', ['main' => $content, 'title' => 'Добавление лота', 'categories_list' => $categories_list]);
    echo $page;
?>