<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <?php 
                $categories = ["Ботинки", "Одежда", "Инструменты", "Разное"];
                $lots = [
                    [
                        'title' => '2014 Rossignol District Snowboard',
                        'category' => 'Доски и лыжи',
                        'price' => '10999',
                        'URL' => 'img/lot-1.jpg'
                    ],
                    [
                        'title' => 'DC Ply Mens 2016/2017 Snowboard',
                        'category' => 'Доски и лыжи',
                        'price' => '159999',
                        'URL' => 'img/lot-2.jpg'
                    ],
                    [
                        'title' => 'Крепления Union Contact Pro 2015 года размер L/XL',
                        'category' => 'Крепления',
                        'price' => '8000',
                        'URL' => '	img/lot-3.jpg'
                    ],
                    [
                        'title' => 'Ботинки для сноуборда DC Mutiny Charocal',
                        'category' => 'Ботинки',
                        'price' => '10999',
                        'URL' => 'img/lot-4.jpg'
                    ],
                    [
                        'title' => 'Куртка для сноуборда DC Mutiny Charocal',
                        'category' => 'Одежда',
                        'price' => '7500',
                        'URL' => 'img/lot-5.jpg'
                    ],
                    [
                        'title' => 'Маска Oakley Canopy',
                        'category' => 'Разное',
                        'price' => '5400',
                        'URL' => 'img/lot-6.jpg'           
                    ]
                ];
            ?>
            <li class="promo__item promo__item--boards">
                <a class="promo__link" href="pages/all-lots.html">Имя категории</a>
            </li>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <!--заполните этот список из массива с товарами-->
            <?php foreach ($lots as $lot): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?=$lot['URL']; ?>" width="350" height="260" alt="">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?=$lot['category']; ?></span>
                    <h3 class="lot__title"><a class="text-link" href="pages/lot.html"><?=$lot['title']; ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?= format_price($lot['price']); ?></span>
                        </div>
                        <div class="lot__timer timer">
                            12:23
                        </div>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>
</main>