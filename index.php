<?php
    require_once ('helpers.php');
    require_once ('functions.php');
    function format_price ($num) {
        $num = ceil($num);
        if ($num < 1000) {
            $num = $num . " ₽";
            return $num;
        }
        $num = number_format($num, 0, ',', ' ');
        $num = $num . " ₽";
        return $num;
    }
    $categories = ["Ботинки", "Одежда", "Инструменты", "Разное"];
    $lots = [
        [
            'title' => '2014 Rossignol District Snowboard',
            'category' => 'Доски и лыжи',
            'price' => '10999',
            'URL' => 'img/lot-1.jpg',
            'expiration date' => '2020-07-02'
        ],
        [
            'title' => 'DC Ply Mens 2016/2017 Snowboard',
            'category' => 'Доски и лыжи',
            'price' => '159999',
            'URL' => 'img/lot-2.jpg',
            'expiration date' => '2020-07-03'
        ],
        [
            'title' => 'Крепления Union Contact Pro 2015 года размер L/XL',
            'category' => 'Крепления',
            'price' => '8000',
            'URL' => 'img/lot-3.jpg',
            'expiration date' => '2020-07-04'
        ],
        [
            'title' => 'Ботинки для сноуборда DC Mutiny Charocal',
            'category' => 'Ботинки',
            'price' => '10999',
            'URL' => 'img/lot-4.jpg',
            'expiration date' => '2020-07-17'
        ],
        [
            'title' => 'Куртка для сноуборда DC Mutiny Charocal',
            'category' => 'Одежда',
            'price' => '7500',
            'URL' => 'img/lot-5.jpg',
            'expiration date' => '2020-09-1'
        ],
        [
            'title' => 'Маска Oakley Canopy',
            'category' => 'Разное',
            'price' => '5400',
            'URL' => 'img/lot-6.jpg',
            'expiration date' => '2021-07-01'           
        ]
    ];

    date_default_timezone_set('Europe/Moscow');
    
    $con = connection();

    function get_lots ($con) {
        $lots_sql = "SELECT l.id, title, expiration_date, start_price, img, c.name AS category_name, b.price FROM lot l JOIN category c ON l.category_id = c.id JOIN bet b WHERE date_of_create < expiration_date && expiration_date > NOW() AND winner_id IS NULL GROUP BY l.id ORDER BY b.date DESC";
        $stmt_1 =  db_get_prepare_stmt($con, $lots_sql);
        mysqli_stmt_execute($stmt_1);
        $res = mysqli_stmt_get_result($stmt_1);
        $lots_list = mysqli_fetch_all($res, MYSQLI_ASSOC);
        return $lots_list;
    }

    $lots_list = get_lots($con);

    $categories_list = get_categories($con);

    $content = include_template('main.php', ['categories_list' => $categories_list, 'lots_list' => $lots_list]);
    $page = include_template('layout.php', ['main' => $content, 'title' => 'Главная', 'user_name' => 'Дима', 'categories_list' => $categories_list]);
    echo $page;
?>
