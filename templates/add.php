 <?php
  $required_fields = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date', 'file'];
  $erros = array();

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST' and $_POST["submit"]) {
    foreach ($required_fields as $field) {
      if (empty($_POST[$field])) {
        $errors[$field] = 'Поле не заполнено';
      }
      else {
        $_POST[$field] = test_input($field);
      }
    }
    if (strlen($_POST['lot-name'] <= 0 or $_POST['lot-name'] > 50)) {
      $errors['lot-name'] = 'Длина имени лота должна быть от 0 до 50 символов';
    }
    if (is_date_valid($_POST['lot-date']) == false) {
      $errors['lot-date'] = 'неверный формат даты';
    } 
    else if (strtotime($_POST['lot-date'] < strtotime("now"))) {
    }
    if (empty($_POST['file'])) {
      $errors['file'] = 'Файл не выбран';
    }
    if (!is_int($_POST['lot-rate']) and $_POST['lot-rate'] <= 0) {
      $errors['lot-rate'] = 'Введите целое число больше нуля';
    }
    if (!is_int($_POST['lot-step']) and $_POST['lot-rate'] <= 0) {
      $errors['lot-rate'] = 'Введите целое число больше нуля';
    }
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
 ?> 
 <main>
    <nav class="nav">
      <ul class="nav__list container">
        <li class="nav__item">
          <a href="all-lots.html">Доски и лыжи</a>
        </li>
        <li class="nav__item">
          <a href="all-lots.html">Крепления</a>
        </li>
        <li class="nav__item">
          <a href="all-lots.html">Ботинки</a>
        </li>
        <li class="nav__item">
          <a href="all-lots.html">Одежда</a>
        </li>
        <li class="nav__item">
          <a href="all-lots.html">Инструменты</a>
        </li>
        <li class="nav__item">
          <a href="all-lots.html">Разное</a>
        </li>
      </ul>
    </nav>
    <form class="form form--add-lot container<?php echo count($errors) != 0 ? "form--invalid" : "" ?>" action="https://echo.htmlacademy.ru" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
      <h2>Добавление лота</h2>
      <div class="form__container-two">
        <div class="form__item <?php if ($errors["lot-name"]) {echo "form__item--invalid";}?> "> <!-- form__item--invalid -->
          <label for="lot-name">Наименование<sup>*</sup></label>
          <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" action="add.php">
          <span class="form__error"><?= $errors["lot-name"] ?></span>
        </div>
        <div class="form__item <?php echo $errors["category"] ? "form__item--invalid" : "" ?>">
          <label for="category">Категория <sup>*</sup></label>
          <select id="category" name="category">
          <?php foreach ($categories_list as $category): ?>
            <option><?= $category["name"] ?></option>
          <? endforeach; ?>
          </select>
          <span class="form__error"><?= $errors["category"] ?></span>
        </div>
      </div>
      <div class="form__item form__item--wide <?php echo $errors["message"] ? "form__item--invalid" : "" ?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="message" placeholder="Напишите описание лота" action="add.php"></textarea>
        <span class="form__error"><?= $errors["message"] ?></span>
      </div>
      <div class="form__item form__item--file <?php echo $errors["file"] ? "form__item--invalid" : "" ?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
          <input class="visually-hidden" type="file" id="lot-img" value="" name="file" action="add.php">
          <label for="lot-img">
            Добавить
          </label>
          <span class="form__error"><?= $errors["file"] ?></span>
        </div>
      </div>
      <div class="form__container-three">
        <div class="form__item form__item--small <?php echo $errors["lot-rate"] ? "form__item--invalid" : "" ?>">
          <label for="lot-rate">Начальная цена <sup>*</sup></label>
          <input id="lot-rate" type="text" name="lot-rate" placeholder="0" action="add.php">
          <span class="form__error"><?= $errors["lot-rate"] ?></span>
        </div>
        <div class="form__item form__item--small <?php echo $errors["lot-step"] ? "form__item--invalid" : "" ?>">
          <label for="lot-step" action="add.php">Шаг ставки <sup>*</sup></label>
          <input id="lot-step" type="text" name="lot-step" placeholder="0" action="add.php">
          <span class="form__error"><?= $errors["lot-step"] ?></span>
        </div>
        <div class="form__item <?php echo $errors["lot-date"] ? "form__item--invalid" : "" ?>">
          <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
          <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="Введите дату в формате ГГГГ-ММ-ДД" action="add.php">
          <span class="form__error"><?= $errors["lot-date"] ?></span>
        </div>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button" name="submit">Добавить лот</button>
    </form>
  </main>
</div>
