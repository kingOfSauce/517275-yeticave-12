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
    $lots_sql = "SELECT l.id, title, img, c.name, expiration_date, description, bet_step, price FROM lot l JOIN category c ON l.category_id = c.id JOIN bet b ON l.id = b.lot_id WHERE l.id = ".$id;
    $stmt_1 =  db_get_prepare_stmt($con, $lots_sql);
    mysqli_stmt_execute($stmt_1);
    $res = mysqli_stmt_get_result($stmt_1);
    $lots_list = mysqli_fetch_assoc($res);
    return $lots_list;
}
$lot = get_lot($con, $id);
if (count($lot) == 0) {
  http_response_code(404);
    echo "Лот не найден";
    exit();
}

$lot_main = include_template('lot-main.php', ['lot' => $lot]);
$lot_layout = include_template('lot-layout.php', ['lot_main' => $lot_main]);
echo $lot_layout;
?>