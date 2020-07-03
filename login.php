<?php
include "db.php";

session_start();

# 로그인 스크립트는 여기에서 시작됩니다
# 사용자 인증 정보가 데이터베이스에서 사용 가능한 데이터와 성공적으로 일치하면 문자열 login_success를 echo합니다.
#login_success 문자열은 Anonymous라는 이름으로 돌아갑니다.funtion $("#login").click() 

if(isset($_POST["u_id"]) && isset($_POST["password"])){
	$u_id = mysqli_real_escape_string($con,$_POST["u_id"]);
	$password = $_POST["password"];
	$sql = "SELECT * FROM user_info WHERE u_id = '$u_id' AND password = '$password'";
	$run_query = mysqli_query($con,$sql);
	$count = mysqli_num_rows($run_query);
    $row = mysqli_fetch_array($run_query);
		$_SESSION["uid"] = $row["user_id"];
		$_SESSION["name"] = $row["name"];
		$ip_add = getenv("REMOTE_ADDR");
		//login_form.php 페이지에 쿠키를 만들었으므로 쿠키를 사용할 수 있으면 사용자가 로그인하지 않은 것입니다
        
	//데이터베이스에서 사용자 레코드를 사용할 수있는 경우 $ count는 1과 같습니다.
	if($count == 1){
		   	
			if (isset($_COOKIE["product_list"])) {
				$p_list = stripcslashes($_COOKIE["product_list"]);
				//여기에 저장된 json 제품 목록 쿠키를 일반 배열로 디코딩합니다
				$product_list = json_decode($p_list,true);
				for ($i=0; $i < count($product_list); $i++) { 
					//데이터베이스에서 사용자 ID를 얻은 후 이미 제품이 있는지 여부를 사용자 카트 항목을 확인하고 있습니다.
					$verify_cart = "SELECT id FROM cart WHERE user_id = $_SESSION[uid] AND p_id = ".$product_list[$i];
					$result  = mysqli_query($con,$verify_cart);
					if(mysqli_num_rows($result) < 1){
						//사용자가 장바구니에 처음 제품을 추가하는 경우 유효한 id로 데이터베이스 테이블에 user_id를 업데이트합니다
						$update_cart = "UPDATE cart SET user_id = '$_SESSION[uid]' WHERE ip_add = '$ip_add' AND user_id = -1";
						mysqli_query($con,$update_cart);
					}else{
						//해당 제품이 이미 데이터베이스 테이블에있는 경우 해당 레코드를 삭제합니다.
						$delete_existing_product = "DELETE FROM cart WHERE user_id = -1 AND ip_add = '$ip_add' AND p_id = ".$product_list[$i];
						mysqli_query($con,$delete_existing_product);
					}
				}
				//z쿠키 편집
				setcookie("product_list","",strtotime("-1 day"),"/");
				//사용자가 장바구니 페이지 이후에 로그인하면 cart_login을 보냅니다.
				echo "cart_login";
				
				
				exit();
				
			}
			//사용자가 페이지에서 로그인하면 login_success를 보냅니다.
			echo "로그인 성공";
			$BackToMyPage = $_SERVER['HTTP_REFERER'];
				if(!isset($BackToMyPage)) {
					header('Location: '.$BackToMyPage);
					echo"<script type='text/javascript'>
					
					</script>";
				} else {
					header('Location:index.php'); // 홈으로 이동
				} 
				
			
            exit;

		}else{
				$u_id1 = mysqli_real_escape_string($con,$_POST["u_id"]);
                $password =$_POST["password"];
                $sql = "SELECT * FROM admin_info WHERE admin_name = '$u_id1' AND admin_password = '$password'";
                $run_query = mysqli_query($con,$sql);
                $count = mysqli_num_rows($run_query);

            //데이터베이스에서 사용자 레코드를 사용할 수있는 경우 $ count는 1과 같습니다.
            if($count == 1){
                $row = mysqli_fetch_array($run_query);
                $_SESSION["uid"] = $row["admin_id"];
                $_SESSION["name"] = $row["admin_name"];
                $ip_add = getenv("REMOTE_ADDR");
                //login_form.php 페이지에 쿠키를 만들었으므로 쿠키를 사용할 수 있으면 사용자가 로그인하지 않은 것입니다


                    //사용자가 페이지에서 로그인하면 login_success를 보냅니다.
                    echo "로그인 하였습니다.";

                    echo "<script> location.href='admin/index.php'; </script>";
                    exit;

                }else{
                    echo "<span style='color:red;'>회원정보가 없습니다.</span>";
                    exit();
                }
    
	
}
    
	
}

?>