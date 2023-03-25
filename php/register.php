<?php 

$servername = 'localhost';
$username = 'root';
$password = '';
try {
  $name = $_POST['username'];
  $pass = $_POST['password'];
  $email = $_POST['email'];
  $dob = $_POST['dob'];
  $mobile = $_POST['mobile'];

 // echo "The tow params are $uname and $pass";
  //code...
  $conn = new PDO("mysql:host=$servername;dbname=registration",$username, $password);

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
echo "Connected successfully";
try {
  //code...
  $sql = "INSERT INTO users (username, password, email, mobile, dob) VALUES (?,?,?,?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->execute(["$name","$pass","$email","$mobile","$dob"]);
} catch (\Throwable $th) {
   echo $th;
}

echo " New record created successfully";
} catch(PDOException $e) {
echo "Connection failed: " . $e->getMessage();
}
?>