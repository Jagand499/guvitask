<?php
use Predis;

require "../assets/vendor/autoload.php";

$redis_host = 'localhost';
$redis_port = 6379;

$servername = 'localhost';
$username = 'root';
$password = '';

try {
  $uname = $_POST['uname'];
  $redis = new Redis();
  $redis->connect($redis_host, $redis_port);
  if ($redis->exists($uname)) {
    $user_data = json_decode($redis->get($uname), true);
  } else {

    $conn = new PDO("mysql:host=$servername;dbname=guvi",$username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM Guvi WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':username', $uname);
    $stmt->execute();
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    $redis->set($uname, json_encode($user_data));
  }

  header("Location: profile.html?uname={$user_data['username']}&pass={$user_data['pass']}&email={$user_data['email']}&mobile={$user_data['mobile']}&dob={$user_data['dob']}");
} catch (Exception $e) {
  echo 'Error: ' . $e->getMessage();
}
