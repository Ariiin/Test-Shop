
<?php
session_start();

// 뱐수 초기화
$username = "";
$email    = "";
$errors = array(); 

// database 연결
define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'PuneethReddy');
   define('DB_PASSWORD', '');
   define('DB_DATABASE', 'ecommerece');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// 회원 양식
if (isset($_POST['reg_user'])) {
  // 양식에서 모든 입력값 받음.
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // 양식 검증 : 양식이 올바르게 채워 졌는지 확인하고
  // errors 배열에 (array_push ()) 해당 오류를 추가함
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // 먼저 데이터베이스를 확인
  // 사용자 ID 및 / 또는 EMAIL이 동일한 사용자가 없습니다.
  $user_check_query = "SELECT * FROM register WHERE Name='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['Name'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // 마지막으로, 양식에 오류가없는 경우 사용자를 등록
  if (count($errors) == 0) {
  	$password = md5($password_1);//데이터베이스에 저장하기 전에 비밀번호를 md5암호화

  	$query = "INSERT INTO register (Name, email, password) 
  			  VALUES('$username', '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['Name'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['email']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "email is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM register WHERE email='$username' AND password='$password'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['email'] = $username;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: index.php');
  	}else {
  		array_push($errors, "Wrong username/password combination");
  	}
  }
}

?>