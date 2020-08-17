<?php 
    require ('helpers.php');
    require ('functions.php');
    $con = connection();
    $categories_list = get_categories($con);
    $content = include_template('add.php', ['categories_list' => $categories_list]);
    $page = include_template('layout.php', ['main' => $content, 'title' => 'Добавление лота', 'categories_list' => $categories_list]);
    echo $page;
?>