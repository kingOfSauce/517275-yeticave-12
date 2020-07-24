<?php
    require ('helpers.php');
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
    function count_date ($exp_date) {
        $exp_stamp = strtotime($exp_date);
        $cur_stamp = strtotime("now");
        $diff = $exp_stamp - $cur_stamp; 
        $hours = floor($diff / 3600);
        $mins = floor((($exp_stamp - $hours * 3600) - $cur_stamp) / 60);
        $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
        $mins = str_pad($mins, 2, "0", STR_PAD_LEFT);
        $rest_of_time = [
            'hours' => $hours,
            'minutes' => $mins
        ];
        return $rest_of_time;
    }

    function connection () {
        $con = mysqli_connect("localhost", "root", "root", "yeticave");
        if ($con == false) {
            echo "Ошибка подключения к БД" . mysqli_connect_error();
            exit();
        }
        else {
            // echo "Подключение прошло успешно";
            mysqli_set_charset($con, "utf8mb4_unicode_ci");
            return $con;
        }
    }
    $con = connection();
    
    function get_lots ($con) {
        $sql = "SELECT title, expiration_date, start_price, img, c.name AS category_name, b.price FROM lot l JOIN category c ON l.category_id = c.id JOIN bet b WHERE date_of_create < expiration_date && expiration_date > NOW() AND winner_id IS NULL GROUP BY l.id ORDER BY b.date DESC";
        $result_lots = mysqli_query($con, $sql);
        $rows = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);
        return $rows;
    }
    $lots_list = get_lots($con);
    
    function get_categories ($con) {
        $sql = "SELECT * FROM category";
        $result_categories = mysqli_query($con, $sql);
        $categories_ar = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);
        return $categories_ar;
    }
    $categories_list = get_categories($con);

    $content = include_template('main.php', ['categories_list' => $categories_list, 'lots_list' => $lots_list]);
    $page = include_template('layout.php', ['main' => $content, 'title' => 'Главная', 'user_name' => 'Дима', 'categories_list' => $categories_list]);
    echo $page;
?>
