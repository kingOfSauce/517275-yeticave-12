 <main>
    <nav class="nav">
      <ul class="nav__list container">
      <?php foreach ($categories_list as $category): ?>
        <li class="nav__item">
          <a href="all-lots.html"><?= $category['name']; ?></a>
        </li>
      <?php endforeach; ?>
      </ul>
    </nav>
    <form class="form form--add-lot container <?= $errors ? "form--invalid" : ''; ?>" action="add.php" method="POST" enctype="multipart/form-data">
      <h2>Добавление лота</h2>
      <div class="form__container-two">
        <div class="form__item <?= $errors["lot-name"] ? "form__item--invalid" : ""; ?>">
          <label for="lot-name">Наименование<sup>*</sup></label>
          <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value = "<?php if(isset($_POST['submit']) && isset($_POST['lot-name'])) {echo $_POST['lot-name'];} else {echo 'лох';} ?>">
          <span class="form__error"><?= $errors["lot-name"] ?></span>
        </div>
        <div class="form__item <?= $errors["category"] ? "form__item--invalid" : ""; ?>">
          <label for="category">Категория <sup>*</sup></label>
          <select id="category" name="category">
          <?php foreach ($categories_list as $category): ?>
            <option value = "<?= $category["id"] ?>"><?= $category["name"] ?></option>
          <? endforeach; ?>
          </select>
          <span class="form__error"><?= $errors["category"] ?></span>
        </div>
      </div>
      <div class="form__item form__item--wide <?= $errors["message"] ? "form__item--invalid" : ""; ?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="message" placeholder="Напишите описание лота"></textarea>
        <span class="form__error"><?= $errors["message"] ?></span>
      </div>
      <div class="form__item form__item--file <?= $errors["file"] ? "form__item--invalid" : ""; ?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
          <input class="visually-hidden" type="file" id="lot-img" value="" name="file">
          <label for="lot-img">
            Добавить
          </label>
          <span class="form__error"><?= $errors["file"] ?></span>
        </div>
      </div>
      <div class="form__container-three">
        <div class="form__item form__item--small <?= $errors["lot-rate"] ? "form__item--invalid" : ""; ?>">
          <label for="lot-rate">Начальная цена <sup>*</sup></label>
          <input id="lot-rate" type="text" name="lot-rate" placeholder="0" value = "<?= isset($_POST['lot-rate']) ? readPOST("lot-rate") : "ничего"; ?>">
          <span class="form__error"><?= $errors["lot-rate"] ?></span>
        </div>
        <div class="form__item form__item--small <?= $errors["lot-step"] ? "form__item--invalid" : ""; ?>">
          <label for="lot-step">Шаг ставки <sup>*</sup></label>
          <input id="lot-step" type="text" name="lot-step" placeholder="0">
          <span class="form__error"><?= $errors["lot-step"] ?></span>
        </div>
        <div class="form__item <?= $errors["lot-date"] ? "form__item--invalid" : ""; ?>">
          <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
          <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
          <span class="form__error"><?= $errors["lot-date"] ?></span>
        </div>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button" name="submit">Добавить лот</button>
    </form>
  </main>
</div>
