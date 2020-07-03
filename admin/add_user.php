<?php

include("../db.php");

if(isset($_POST['btn_save']))
{
$first_name=$_POST['first_name'];
$last_name=$_POST['last_name'];
$email=$_POST['email'];
$user_password=$_POST['user_password'];
$mobile=$_POST['mobile'];
$address1=$_POST['address1'];
$address2=$_POST['address2'];

mysqli_query($con,"insert into user_info(first_name, last_name,email,password,mobile,address1,address2) values ('$first_name','$last_name','$email','$user_password','$mobile','$address1','$address2')") 
			or die ("쿼리 1 잘못되었습니다.");
header("location: manage_users.php"); 
mysqli_close($con);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Admin Panel</title>
 <meta name="viewport" content="width=device-width, initial-scale=1">
<link href="style/css/bootstrap.min.css" rel="stylesheet">
<link href="style/css/k.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
</head>
<body>
<?php include("include/header.php"); ?>

<div class="container-fluid">
<?php include("include/side_bar.php"); ?>

  <div class="col-sm-9 " align="center">	
  <div class="panel-heading" style="background-color:#c4e17f;">
	<h1>Add User  </h1></div><br>
	
<form action="add_user.php" name="form" method="post">
<div class="col-sm-6">
    <input name="first_name" class="input-lg" type="text"  id="first_name" style="font-size:18px; width:330px" placeholder="성" autofocus required><br><br>
</div>
<div class="col-sm-6">
<input name="last_name" class="input-lg" type="text"  id="last_name" style="font-size:18px; width:330px" placeholder="이름" autofocus required><br><br>
    </div>
    <div class="col-sm-6">
    <input name="email" class="input-lg" type="text"  id="email" style="font-size:18px; width:330px" placeholder="이메일" autofocus required><br><br>
    </div>
    <div class="col-sm-6">
<input name="user_password" class="input-lg" type="text"  id="user_password" style="font-size:18px; width:330px"  placeholder="비밀번호" required><br><br>
    </div>
     <div class="col-sm-6">
    <input name="mobile" class="input-lg" type="phone"  id="mobile" style="font-size:18px; width:330px" placeholder="휴대번호" autofocus required><br><br>
    </div>
     <div class="col-sm-6">
    <input name="address1" class="input-lg" type="text"  id="address1" style="font-size:18px; width:330px" placeholder="주소" autofocus required><br><br>
    </div>
     <div class="col-sm-6">
    <input name="address2" class="input-lg" type="text"  id="address2" style="font-size:18px; width:330px" placeholder="상세주소" autofocus required><br><br>
    </div>
<div class="col-sm-7" style="margin:20px;margin-left:90px;">
    <button type="submit" class="btn btn-success btn-block center" name="btn_save" id="btn_save" style="font-size:18px">확인</button></div>
</form>
</div></div>
<?php include("include/js.php"); ?>
</body>
</html>