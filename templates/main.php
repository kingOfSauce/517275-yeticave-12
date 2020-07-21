    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">  
        <?php
        $con = mysqli_connect("localhost", "root", "root", "yeticave");
        if ($con == false) {
            echo "Ошибка подключения к БД" . mysqli_connect_error();
        }
        else {
            //echo "Подключение прошло успешно";
            mysqli_set_charset($con, "utf8mb4_unicode_ci");
            $lots_sql = "SELECT title, expiration_date, start_price, img, c.name AS category_name, b.price FROM lot l JOIN category c ON l.category_id = c.id JOIN bet b WHERE date_of_create < expiration_date && expiration_date > NOW() AND winner_id IS NULL GROUP BY l.id ORDER BY b.date DESC";
            $result_lots = mysqli_query($con, $lots_sql);
            $rows = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);
            $categories_sql = "SELECT * FROM category";
            $result_categories = mysqli_query($con, $categories_sql);
            $categories_ar = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);
        }
        
        foreach ($categories_ar as $category): ?>  
            <li class="promo__item promo__item--boards">
                <a class="promo__link" href="pages/all-lots.html"><?= htmlspecialchars($category['name']); ?></a>
            </li>
        <?php endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <!--заполните этот список из массива с товарами-->
            <?php foreach ($rows as $row): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?=htmlspecialchars($row['img']); ?>" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?=htmlspecialchars($row['category_name']); ?></span>
                    <h3 class="lot__title"><a class="text-link" href="pages/lot.html"><?=htmlspecialchars($row['title']); ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?= htmlspecialchars(format_price($row['price'])); ?></span>
                        </div>
                        <?php $exp_time = count_date($row['expiration_date']); ?>
                        <div class="lot__timer timer<?= ($exp_time['hours'] == 0) ? " timer--finishing" : ""; ?>">
                            <?= $exp_time['hours'] . ":" . $exp_time['minutes']; ?>
                        </div>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>
