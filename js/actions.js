$(document).ready(function(){
	cat();
    cathome();
	brand();
	product();
    
    producthome();
    
    
	//cat ()은 페이지가 로드 될 때마다 데이터베이스에서 범주 레코드를 가져 오는 funtion입니다.
	function cat(){
		$.ajax({
			url	:	"action.php",
			method:	"POST",
			data	:	{category:1},
			success	:	function(data){
				$("#get_category").html(data);
				
			}
		})
	}
    function cathome(){
		$.ajax({
			url	:	"homeaction.php",
			method:	"POST",
			data	:	{categoryhome:1},
			success	:	function(data){
				$("#get_category_home").html(data);
				
			}
		})
	}
	//brand ()는 페이지가로드 될 때마다 데이터베이스에서 브랜드 레코드를 가져 오는 기능입니다.
	function brand(){
		$.ajax({
			url	:	"action.php",
			method:	"POST",
			data	:	{brand:1},
			success	:	function(data){
				$("#get_brand").html(data);
			}
		})
	}
	//product ()는 페이지가로드 될 때마다 데이터베이스에서 제품 레코드를 가져 오는 함수입니다.
		function product(){
		$.ajax({
			url	:	"action.php",
			method:	"POST",
			data	:	{getProduct:1},
			success	:	function(data){
				$("#get_product").html(data);
			}
		})
	}
    gethomeproduts();
    function gethomeproduts(){
		$.ajax({
			url	:	"homeaction.php",
			method:	"POST",
			data	:	{gethomeProduct:1},
			success	:	function(data){
				$("#get_home_product").html(data);
			}
		})
	}
    function producthome(){
		$.ajax({
			url	:	"homeaction.php",
			method:	"POST",
			data	:	{getProducthome:1},
			success	:	function(data){
				$("#get_product_home").html(data);
			}
		})
	}
   
    
	/*	페이지가 성공적으로로드되면 사용자가 카테고리를 클릭하면 카테고리 목록이 있습니다.
		id에 따라 제품을 보여줄 것입니다.
	*/
	$("body").delegate(".category","click",function(event){
		$("#get_product").html("<h3>Loading...</h3>");
		event.preventDefault();
		var cid = $(this).attr('cid');
		
			$.ajax({
			url		:	"action.php",
			method	:	"POST",
			data	:	{get_seleted_Category:1,cat_id:cid},
			success	:	function(data){
				$("#get_product").html(data);
				if($("body").width() < 480){
					$("body").scrollTop(683);
				}
			}
		})
	
	})
    $("body").delegate(".categoryhome","click",function(event){
		$("#get_product").html("<h3>Loading...</h3>");
		event.preventDefault();
		var cid = $(this).attr('cid');
		
			$.ajax({
			url		:	"homeaction.php",
			method	:	"POST",
			data	:	{get_seleted_Category:1,cat_id:cid},
			success	:	function(data){
				$("#get_product").html(data);
				if($("body").width() < 480){
					$("body").scrollTop(683);
				}
			}
		})
	
	})

	/*	
		페이지가 성공적으로 로드되면 사용자가 브랜드를 클릭 할 때 브랜드 목록이 표시됩니다.
		브랜드 ID에 따라 제품을 표시합니다
	*/
	$("body").delegate(".selectBrand","click",function(event){
		event.preventDefault();
		$("#get_product").html("<h3>Loading...</h3>");
		var bid = $(this).attr('bid');
		
			$.ajax({
			url		:	"action.php",
			method	:	"POST",
			data	:	{selectBrand:1,brand_id:bid},
			success	:	function(data){
				$("#get_product").html(data);
				if($("body").width() < 480){
					$("body").scrollTop(683);
				}
			}
		})
	
	})
	/* 
		페이지 상단에는 사용자가 제품 이름을 입력하면 검색 버튼이있는 검색 상자가 있으며 사용자를 가져옵니다.
		주어진 문자열과 SQL 쿼리의 도움으로 사용자가 지정한 문자열을 데이터베이스 키워드 열과 일치시킨 다음 일치하는 제품을 찾습니다.
	*/
	$("#search_btn").click(function(){
		$("#get_product").html("<h3>Loading...</h3>");
		var keyword = $("#search").val();
		if(keyword != ""){
			$.ajax({
			url		:	"action.php",
			method	:	"POST",
			data	:	{search:1,keyword:keyword},
			success	:	function(data){ 
				$("#get_product").html(data);
				if($("body").width() < 480){
					$("body").scrollTop(683);
				}
			}
		})
		}
	})
	//end


	/*
		여기서 #login은 로그인 양식 ID이며 index.php 페이지에서 사용할 수 있습니다.
		여기에서 입력 데이터가 login.php 페이지로 전송됩니다
		login.php 페이지에서 login_success 문자열을 얻는 경우 사용자가 성공적으로 로그인했으며 window.location이
		사용자를 홈페이지에서 profile.php 페이지로 리디렉션하는 데 사용
	*/
	$("#login").on("submit",function(event){
		event.preventDefault();
		$(".overlay").show();
		$.ajax({
			url	:	"login.php",
			method:	"POST",
			data	:$("#login").serialize(),
			success	:function(data){
				if(data == "login_success"){
					window.location.href = "index.php";
				}else if(data == "cart_login"){
					window.location.href = "cart.php";
				}else{
					$("#e_msg").html(data);
					$(".overlay").hide();
				}
			}
		})
	})
	//end

	//체크 아웃 전에 사용자 정보 얻기
	$("#signup_form").on("submit",function(event){
		event.preventDefault();
		$(".overlay").show();
		$.ajax({
			url : "register.php",
			method : "POST",
			data : $("#signup_form").serialize(),
			success : function(data){
				$(".overlay").hide();
				if (data == "register_success") {
					window.location.href = "cart.php";
				}else{
					$("#signup_msg").html(data);
				}
				
			}
		})
	})
	
    
    $("#offer_form").on("submit",function(event){
		event.preventDefault();
		$(".overlay").show();
		$.ajax({
			url : "offersmail.php",
			method : "POST",
			data : $("#offer_form").serialize(),
			success : function(data){
				$(".overlay").hide();
				$("#offer_msg").html(data);
				
			}
		})
	})
    
    
    
	//결제가 끝나기 전에 사용자 정보를 얻기

	//장바구니에 제품 추가
	$("body").delegate("#product","click",function(event){
		var pid = $(this).attr("pid");
		
		event.preventDefault();
		$(".overlay").show();
		$.ajax({
			url : "action.php",
			method : "POST",
			data : {addToCart:1,proId:pid,},
			success : function(data){
				count_item();
				getCartItem();
				$('#product_msg').html(data);
				$('.overlay').hide();
			}
		})
	})
	//장바구니에 제품 추가하기
	//사용자 장바구니 항목 수 계산
	count_item();
	function count_item(){
		$.ajax({
			url : "action.php",
			method : "POST",
			data : {count_item:1},
			success : function(data){
				$(".badge").html(data);
			}
		})
	}
	//사용자 장바구니 항목 수 계산

	//데이터베이스에서 dropdown menu로 장바구니 항목 가져 오기
	getCartItem();
	function getCartItem(){
		$.ajax({
			url : "action.php",
			method : "POST",
			data : {Common:1,getCartItem:1},
			success : function(data){
				$("#cart_product").html(data);
                net_total();
                
			}
		})
	}

	//데이터베이스에서 dropdown menu로 장바구니 항목 가져 오기

	/*
		사용자가 수량을 변경할 때마다 keyup 기능을 사용하여 총량을 즉시 업데이트합니다.
		그러나 사용자가 숫자 이외의 무언가 (? '' "",. () ''등)를 넣을 때마다 qty = 1이됩니다.
		사용자가 qty 0을 넣거나 0보다 작 으면 다시 1 qty = 1로 만듭니다.
		( '.total'). each () 이것은 클래스 .total에 대해 루프 함수 반복이며 모든 반복에서 클래스 .total 값의 합계 연산을 수행합니다.
		그런 다음 결과를 클래스 .net_total에 표시.
		
	*/
	$("body").delegate(".qty","keyup",function(event){
		event.preventDefault();
		var row = $(this).parent().parent();
		var price = row.find('.price').val();
		var qty = row.find('.qty').val();
		if (isNaN(qty)) {
			qty = 1;
		};
		if (qty < 1) {
			qty = 1;
		};
		var total = price * qty;
		row.find('.total').val(total);
		var net_total=0;
		$('.total').each(function(){
			net_total += ($(this).val()-0);
		})
		$('.net_total').html(net_total + "원");

	})

	// function numberWithCommas(x) {
	// 	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	// } 숫자 comma 넣기

	//수량 변경 여기에서 종료

	/*
		
		사용자가 .remove 클래스를 클릭 할 때마다 해당 행의 제품 ID를 가져옵니다.
		제품 제거 작업을 수행하기 위해 action.php로 보냅니다.
	*/
    
	   
    $("body").delegate(".remove","click",function(event){
        var remove = $(this).parent().parent().parent();
        var remove_id = remove.find(".remove").attr("remove_id");
        $.ajax({
            url	:	"action.php",
            method	:	"POST",
            data	:	{removeItemFromCart:1,rid:remove_id},
            success	:	function(data){
                $("#cart_msg").html(data);
                checkOutDetails();
                }
            })
    })
    
    
	/*		
		사용자가 .update 클래스를 클릭 할 때마다 해당 행의 제품 ID를 가져옵니다.
		제품 수량 업데이트 작업을 수행하기 위해 action.php로 보냅니다.
	*/
	$("body").delegate(".update","click",function(event){
		var update = $(this).parent().parent().parent();
		var update_id = update.find(".update").attr("update_id");
		var qty = update.find(".qty").val();
		$.ajax({
			url	:	"action.php",
			method	:	"POST",
			data	:	{updateCartItem:1,update_id:update_id,qty:qty},
			success	:	function(data){
				$("#cart_msg").html(data);
				checkOutDetails();
			}
		})


	})
	checkOutDetails();
	net_total();
	/*
		checkOutDetails () 함수는 두 가지 목적으로 작동합니다
		먼저 action.php 페이지에서 PHP isset ($ _ POST [ "Common"])을 활성화합니다.
		isset ($ _ POST [ "getCartItem"]) 인 두 개의 isset funtion이 있으며 다른 하나는 isset ($ _ POST [ "checkOutDetials"])입니다.
		getCartItem은 카트 항목을 드롭 다운 메뉴에 표시하는 데 사용됩니다.
		checkOutDetails는 장바구니 항목을 Cart.php 페이지에 표시하는 데 사용됩니다
	*/
	function checkOutDetails(){
	 $('.overlay').show();
		$.ajax({
			url : "action.php",
			method : "POST",
			data : {Common:1,checkOutDetails:1},
			success : function(data){
				$('.overlay').hide();
				$("#cart_checkout").html(data);
					net_total();
			}
		})
	}
	/*
		net_total 함수는 장바구니 항목의 총량을 계산하는 데 사용됩니다.
	*/
	function net_total(){
		var net_total = 0;
		$('.qty').each(function(){
			var row = $(this).parent().parent();
			var price  = row.find('.price').val();
			var total = price * $(this).val()-0;
			row.find('.total').val(total);
		})
		$('.total').each(function(){
			net_total += ($(this).val()-0);
		})
		$('.net_total').html(net_total+ "원");
	}

	//장바구니에서 제품을 제거

	page();
	function page(){
		$.ajax({
			url	:	"action.php",
			method	:	"POST",
			data	:	{page:1},
			success	:	function(data){
				$("#pageno").html(data);
			}
		})
	}
	$("body").delegate("#page","click",function(){
		var pn = $(this).attr("page");
		$.ajax({
			url	:	"action.php",
			method	:	"POST",
			data	:	{getProduct:1,setPage:1,pageNumber:pn},
			success	:	function(data){
				$("#get_product").html(data);
			}
		})
	})
})






















