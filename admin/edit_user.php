    <?php
    $user_id = $_GET["user_id"];
    $sql = "SELECT * FROM user
            WHERE user_id = $user_id
    ";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);

    //Update user
    $user_full = $user_mail = $user_pass = $user_re_pass = $user_level = "";
    $error_mail = $error_pass = $error_name = 0;
    if(isset($_POST["sbm"])){
        $error_mail = $error_pass = $error_name = 0;
        $user_full = $_POST["user_full"];
        $user_mail = $_POST["user_mail"];
        $user_pass = $_POST["user_pass"];
        $user_re_pass = $_POST["user_re_pass"];
        $user_level = $_POST["user_level"];
        if (!preg_match("/^([a-zA-Z0-9ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]+)$/i",$user_full)) {
                $error_name = 1;
        }
        if (!filter_var($user_mail, FILTER_VALIDATE_EMAIL)) {
            $error_mail = 2;
        }
        $sql=mysqli_query($conn,"SELECT * FROM user WHERE user_mail='$user_mail'");
        $row1 = mysqli_fetch_array($sql);
        if(mysqli_num_rows($sql)>0)
        {
            if($row1["user_id"] != $user_id){
                $error_mail = 1; 
            }
        }
        if($user_pass != $user_re_pass) {
            $error_pass = 1;
        }
        if($error_mail == 0  && $error_pass == 0 && $error_name == 0){
            echo $sql = "UPDATE user
            SET
                user_full = '$user_full',
                user_mail = '$user_mail',
                user_pass = '$user_pass',
                user_level = '$user_level'
            WHERE user_id = $user_id
            ";

            mysqli_query($conn, $sql);
            header("location:index.php?page_layout=user");
        }
    }
    ?>
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
                <li><a href="index.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                <li><a href="">Quản lý thành viên</a></li>
				<li class="active"><?php echo $row["user_full"]; ?></li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Thành viên: <?php echo $row["user_full"]; ?></h1>
			</div>
        </div><!--/.row-->
        <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-md-8">
                                <?php if( $error_name == 1) echo '<div class="alert alert-danger">Họ tên chứa ký tự không được phép !</div>'; ?>
                            	<?php if( $error_mail == 1) echo '<div class="alert alert-danger">Email đã tồn tại !</div>'; ?>
                                <?php if( $error_mail == 2) echo '<div class="alert alert-danger">Sai khuôn dạng email !</div>'; ?>
                                <?php if( $error_pass == 1) echo '<div class="alert alert-danger">Mật khẩu không khớp !</div>'; ?>
                                
                            <form role="form" method="post">
                                <div class="form-group">
                                    <label>Họ & Tên</label>
                                    <input type="text" name="user_full" required class="form-control" value="<?php echo $row["user_full"]; ?>" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="user_mail" required value="<?php echo $row["user_mail"]; ?>" class="form-control">
                                </div>                       
                                <div class="form-group">
                                    <label>Mật khẩu</label>
                                    <input type="password" name="user_pass" required  class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Nhập lại mật khẩu</label>
                                    <input type="password" name="user_re_pass" required  class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Quyền</label>
                                    <select name="user_level" class="form-control">
                                        <option value=1 <?php if($row["user_level"] == 1){echo "selected";} ?>>Admin</option>
                                        <option value=2 <?php if($row["user_level"] == 2){echo "selected";} ?>>Member</option>
                                    </select>
                                </div>
                                <button type="submit" name="sbm" class="btn btn-primary">Cập nhật</button>
                                <button type="reset" class="btn btn-default">Làm mới</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div><!-- /.col-->
            </div><!-- /.row -->
		
	</div>	<!--/.main-->	
</body>

</html>
