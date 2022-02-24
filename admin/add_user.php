    <?php
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

            if(mysqli_num_rows($sql)>0)
            {
                $error_mail = 1; 
            }
            if($user_pass != $user_re_pass) {
                $error_pass = 1;
            }
            if($error_mail == 0  && $error_pass == 0 && $error_name == 0){

                $sql = "INSERT INTO user(
                    user_full,
                    user_mail,
                    user_pass,
                    user_level
                )
                VALUES(
                    '$user_full',
                    '$user_mail',
                    '$user_pass',
                    '$user_level'
                )";
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
				<li class="active">Thêm thành viên</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Thêm thành viên</h1>
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
                                    <input name="user_full" required class="form-control" placeholder="" value="<?php echo $user_full;?>">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input name="user_mail" required type="text" class="form-control"  value="<?php echo $user_mail;?>">
                                </div>                       
                                <div class="form-group">
                                    <label>Mật khẩu</label>
                                    <input name="user_pass" required type="password"  class="form-control"  value="<?php echo $user_pass;?>">
                                </div>
                                <div class="form-group">
                                    <label>Nhập lại mật khẩu</label>
                                    <input name="user_re_pass" required type="password"  class="form-control"  value="<?php echo $user_re_pass;?>">
                                </div>
                                <div class="form-group">
                                    <label>Quyền</label>
                                    <select name="user_level" class="form-control"  value="<?php echo $user_level;?>">
                                        <option value=1>Admin</option>
                                        <option value=2>Member</option>
                                    </select>
                                </div>
                                <button name="sbm" type="submit" class="btn btn-success">Thêm mới</button>
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
