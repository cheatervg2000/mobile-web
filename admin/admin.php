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

	<!--Icons-->
	<script src="js/lumino.glyphs.js"></script>

	<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><span>Vietpro</span>Shop</a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user">
								<use xlink:href="#stroked-male-user"></use>
							</svg>
							<?php
							$mail = $_SESSION['users']['mail'];
							$sql = "SELECT * FROM user WHERE user_mail LIKE '$mail'";
							$query = mysqli_query($conn, $sql);
							while($row = mysqli_fetch_array($query)){
								echo $row['user_full']; 
							?>  <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="index.php?page_layout=edit_user&user_id=<?php echo $row["user_id"]; }?>"><svg class="glyph stroked male-user">
										<use xlink:href="#stroked-male-user"></use>
									</svg> Hồ sơ</a></li>
							<li><a href="logout.php"><svg class="glyph stroked cancel">
										<use xlink:href="#stroked-cancel"></use>
									</svg> Đăng xuất</a></li>
						</ul>
					</li>
				</ul>
			</div>

		</div><!-- /.container-fluid -->
	</nav>

	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<form role="search">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Search">
			</div>
		</form>
		<ul class="nav menu">
			<li class="active"><a href="index.php"><svg class="glyph stroked dashboard-dial">
						<use xlink:href="#stroked-dashboard-dial"></use>
					</svg>Dashboard</a></li>
			<li><a href="?page_layout=user"><svg class="glyph stroked male user ">
						<use xlink:href="#stroked-male-user" /></svg>Quản lý thành viên</a></li>
			<li><a href="?page_layout=category"><svg class="glyph stroked open folder">
						<use xlink:href="#stroked-open-folder" /></svg>Quản lý danh mục</a></li>
			<li><a href="?page_layout=product"><svg class="glyph stroked bag">
						<use xlink:href="#stroked-bag"></use>
					</svg>Quản lý sản phẩm</a></li>
			<li><a href="?page_layout=order"><svg class="glyph stroked chain">
						<use xlink:href="#stroked-chain" /></svg> Quản lý đơn hàng</a></li>
			<li><a href="?page_layout=comment"><svg class="glyph stroked two messages">
						<use xlink:href="#stroked-two-messages" /></svg> Quản lý bình luận</a></li>
		</ul>

	</div>
	<!--/.sidebar-->

	<?php
	// Master Page
	if (isset($_GET["page_layout"])) {
		switch ($_GET["page_layout"]) {
			case "product":
				include_once("product.php");
				break;
			case "add_product":
				include_once("add_product.php");
				break;
			case "category":
				include_once("category.php");
				break;
			case "edit_product":
				include_once("edit_product.php");
				break;
			case "edit_category":
				include_once("edit_category.php");
				break;
			case "edit_user":
				include_once("edit_user.php");
				break;
			case "user":
				include_once("user.php");
				break;
			case "add_user":
				include_once("add_user.php");
				break;
			case "delete_product":
				include_once("delete_product.php");
				break;
			case "delete_user":
				include_once("delete_user.php");
				break;
			case "add_category":
				include_once("add_category.php");
				break;
			case "comment":
				include_once("comment.php");
				break;
			case "delete_comment":
				include_once("delete_comment.php");
				break;
			case "order":
				include_once("order.php");
				break;
			case "update_order":
				include_once("update_order.php");
				break;
			case "delete_order":
				include_once("delete_order.php");
				break;
		}
	} else {
		include_once("dashboard.php");
	}
	?>
</body>

</html>