<?php 
  require ('helpers.php');
  require ('functions.php');
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
  }
  else {
    http_response_code(404);
    echo "Лот не найден";
    exit();
  }

  $con = connection();

  function get_lot ($con, $id) {
    $lots_sql = "SELECT l.id, title, img, c.name, expiration_date, description, bet_step, price FROM lot l JOIN category c ON l.category_id = c.id JOIN bet b ON l.id = b.lot_id WHERE l.id = (?)";
    $stmt_1 =  db_get_prepare_stmt($con, $lots_sql, $data = [$id]);
    mysqli_stmt_execute($stmt_1);
    $res = mysqli_stmt_get_result($stmt_1);
    $lots_list = mysqli_fetch_assoc($res);
    return $lots_list;
}
$lot = get_lot($con, $id);
if (NULL === $lot) {
  http_response_code(404);
    echo "Лот не найден";
    exit();
}

$categories = get_categories($con);

$lot_main = include_template('lot.php', ['lot' => $lot, 'categories_list' => $categories]);
$lot_layout = include_template('layout.php', ['main' => $lot_main, 'categories_list' => $categories, 'title' => $lot['title']]);
echo $lot_layout;
?>