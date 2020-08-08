<?php 
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
?>