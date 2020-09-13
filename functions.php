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
        mysqli_set_charset($con, "utf8mb4_unicode_ci");
        return $con;
    }
}

function get_categories ($con) {
    $categories_sql = "SELECT * FROM category";
    $stmt_2 = db_get_prepare_stmt($con, $categories_sql);
    mysqli_stmt_execute($stmt_2);
    $res = mysqli_stmt_get_result($stmt_2);
    $categories_list = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $categories_list;
}

  function readPOST($key) {
      if (isset($_POST[$key]) && $_POST[$key]) {
        trim ($_POST[$key]);
        if (empty($_POST[$key])) {
            return NULL;
        } else {
            return $_POST[$key];
        }
      }
      else {
          return NULL;
      };
  }
