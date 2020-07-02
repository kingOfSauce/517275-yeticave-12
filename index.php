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
            'URL' => '	img/lot-3.jpg',
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
        if ($hours < 10) {
            $hours = str_pad($hours, 2, "0", STR_PAD_LEFT);
        }
        if ($mins < 10) {
            $mins = str_pad($mins, 2, "0", STR_PAD_LEFT);
        }
        $rest_of_time = [
            'hours' => $hours,
            'minutes' => $mins
        ];
        // return $rest_of_time [0] . ":" .$rest_of_time[1];
        return $rest_of_time;
    }

    $content = include_template('main.php', ['categories' => $categories, 'lots' => $lots]);
    $page = include_template('layout.php', ['main' => $content, 'title' => 'Главная', 'user_name' => 'Дима', 'categories' => $categories]);
    echo $page;
?>
