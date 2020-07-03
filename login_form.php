<?php
#로그인 폼 페이지입니다. 사용자가 이미 로그인 한 경우 isset ($ _ SESSION [ "uid"])를 실행하여 이페이지에 액세스 할 수 없습니다.
#statment가 true를 반환하면 사용자를 profile.php 페이지로 보냅니다.
// 사용자가 "로그아웃"버튼을 클릭하면 action.php 페이지에서 action.php 페이지의 데이터 형식으로 데이터를 전달합니다
if (isset($_POST["login_user_with_product"])) {
	//제품 목록 배열
	$product_list = $_POST["product_id"];
	//여기서 배열을 cookie에 저장할 수 없기 때문에 배열을 json 형식으로 변환합니다.
	$json_e = json_encode($product_list);
	//쿠키를 만들고 쿠키는 product_list입니다
	setcookie("product_list",$json_e,strtotime("+1 day"),"/","","",TRUE);


}
?>

	<div class="wait overlay">
		<div class="loader"></div>
	</div>
	<div class="container-fluid">
				<!-- row -->
				

					<div class="login-marg">
						
						
								<form onsubmit="return false" id="login" class="login100-form ">
									<div class="billing-details jumbotron">
                                    <div class="section-title">
                                        <h2 class="login100-form-title p-b-49" >로그인</h2>
                                    </div>
                                   
                                    
                                    <div class="form-group">
                                       <label for="email">ID</label>
                                        <input class="input input-borders" type="text" name="u_id" placeholder="아이디" id="u_id" required>
                                    </div>
                                    
                                    <div class="form-group">
                                       <label for="email">Password</label>
                                        <input class="input input-borders" type="password" name="password" placeholder="패스워드" id="password" required>
                                    </div>
                                    
                                    <div class="text-pad" >
                                       <a href="#">
                                       ID / 비밀번호 찾기
                                       </a>
                                        
                                    </div>
                                    
                                        <input class="primary-btn btn-block"   type="submit"  Value="로그인">
                                        
                                        <div class="panel-footer"><div class="alert alert-danger"><h4 id="e_msg"></h4></div></div>
                                    
                                    	
                                        
                                    

                                </div>
                                
								</form>
                           
					</div>

			</div>