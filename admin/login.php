<?php
include_once("check.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Vietpro Mobile Shop - Administrator</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/bootstrap-table.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>
	<?php
		$thoi_gian_khoa = 60; //đặt thời gian tài khoản bị khóa
		//tạo biến lưu số lần đăng nhập lỗi
		if(isset($_COOKIE['error'])){
			$dem = $_COOKIE['error'];
		}else{
			$dem = 0;
		}
		if(isset($_POST["sbm"])){
			$mail = $_POST["mail"];
			$pass = $_POST["pass"];
			$sql = "SELECT * FROM user
					WHERE user_mail = '$mail'
					AND	  user_pass = '$pass'
			";
			$query = mysqli_query($conn, $sql);
			if(mysqli_num_rows($query) > 0){
				//cấp quyền session
				$_SESSION["users"]["mail"] = $mail;
				$_SESSION["users"]["pass"] = $pass;
				//hủy hàm cookie nếu đăng nhập đúng
				setcookie('error',$dem, time() - 3600);
				unset($_COOKIE["error"]);
				header("location: index.php");
			} else{
				$dem++;
				setcookie('error',$dem, time() + 86400);//thời gian lưu số lần đăng nhập lỗi là 1 ngày, có thể lưu lâu hơn hoặc ngắn hơn
				$error = '<div class="alert alert-danger">Tài khoản không hợp lệ! Bạn đã nhập sai '.$dem.' lần</div>';
			}
		}
	?>
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">Vietpro Mobile Shop - Administrator</div>
				<div class="panel-body">
					<?php
						if(isset($error)){
							echo $error;
						}
						if($dem <= 3){
					?>
					<form role="form" method="post">
						<fieldset>
							<div class="form-group">
								<input required class="form-control" placeholder="E-mail" name="mail" type="email" autofocus>
							</div>
							<div class="form-group">
								<input required class="form-control" placeholder="Mật khẩu" name="pass" type="password" value="">
							</div>
							<div class="checkbox">
								<label>
									<input name="remember" type="checkbox" value="Remember Me">Nhớ tài khoản
								</label>
							</div>
							<button type="submit" name="sbm" class="btn btn-primary">Đăng nhập</button>
						</fieldset>
					</form>
					<?php
					}
					else 
					{
						setcookie('error', $dem, time() + $thoi_gian_khoa);//thời gian khóa đăng nhập là 60s
					?>
					<div class="alert alert-danger">Bạn đã bị khoá do nhập sai nhiều lần(trở lại sau 1 phút)</div>
					<?php
					}
					?>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->	
</body>

</html>
