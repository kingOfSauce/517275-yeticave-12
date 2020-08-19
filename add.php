<?php
    $required_fields = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date', 'file'];
    $erros = array();
    if ($_SERVER['REQUEST_METHOD'] == 'POST' and $_POST["submit"]) {
        foreach ($required_fields as $field) {
            if (isset($_POST[$field]) && $_POST[$field]) {
            $errors[$field] = 'Поле не заполнено';
            }
            else {
            $_POST[$field] = test_input($field);
            }
        }
        if (null !== $key = readPOST('name')) {
                if (strlen($_POST['lot-name'] <= 0 or $_POST['lot-name'] > 50)) {
                    $errors['lot-name'] = 'Длина имени лота должна быть от 0 до 50 символов';
            }
        }
        if (null !== $key = readPOST('lot-date')) {
            if (is_date_valid($_POST['lot-date']) == false) {
                $errors['lot-date'] = 'неверный формат даты';
            } 
            else if (strtotime($_POST['lot-date'] < strtotime("now"))) {
            }
        }   
        if (null !== $key = readPOST('file')) { 
            if (empty($_POST['file'])) {
                $errors['file'] = 'Файл не выбран';
            }
        }   
        if (null !== $key = readPOST('lot-rate')) {
            if (!is_int($_POST['lot-rate']) and $_POST['lot-rate'] <= 0) {
                $errors['lot-rate'] = 'Введите целое число больше нуля';
            }
        }
        if (null !== $key = readPOST('lot-step')) {
            if (!is_int($_POST['lot-step']) and $_POST['lot-step'] <= 0) {
                $errors['lot-step'] = 'Введите целое число больше нуля';
            }
        }
        if (null !== $key = readPOST('file')) {
            if (empty($_FILES)) {
                $errors['file'] = 'Файл не выбран';
            }
            else if (mime_content_type($_FILES['file']) != 'image/png' or mime_content_type($_FILES['file'] != 'image/jpeg')) {
                $errors['file'] = 'Тип файла не подходит';
            }
            else {
            $file_name = $_FILES['file']['name'];
            $file_path = __DIR__ . '/uploades';
            move_uploaded_file($_FILES['file']['tmp_name']. $file_path . $file_name);
            }
        }
        if (empty($errors)) {
        $con = connection();
        if ($_POST['category'] == 'Крепления') $category_id = 1;
        else if ($_POST['category'] == 'Куртки') $category_id = 2;
        else if ($_POST['category'] == 'Доски и лыжи') $category_id = 3;
        else if ($_POST['category'] == 'Обувь') $category_id = 4;
        else if ($_POST['category'] == 'Интсрументы') $category_id = 5;
        else if ($_POST['category'] == 'Разное') $category_id = 6;
        $sql = "INSERT INTO lot (title, description, img, start_price, expiration_date, bet_step, category_id) VALUES ((?), (?), (?), (?), (?), (?), (?))";
        $stmt = db_get_prepare_stmt($con, $sql, $data=[$_POST['lot-name'], $_POST['message'], $file_path, $_POST['lot-rate'], $_POST['lot-date'], $_POST['lot-step'], $category_id]);
        mysqli_stmt_execute($stmt);
        }
    }

    require ('helpers.php');
    require ('functions.php');
    $con = connection();
    $categories_list = get_categories($con);
    $content = include_template('add.php', ['categories_list' => $categories_list]);
    $page = include_template('layout.php', ['main' => $content, 'title' => 'Добавление лота', 'categories_list' => $categories_list]);
    echo $page;
?>