    <?php
        $cat_name = "";
        $error_name = 0;
        if(isset($_POST["sbm"])){
            $error_name = 0;
            $cat_name = $_POST["cat_name"];
            $sql=mysqli_query($conn,"SELECT * FROM category WHERE cat_name='$cat_name'");

            if(mysqli_num_rows($sql)>0)
            {
                $error_name = 1; 
            }
           
            if($error_name == 0){
                $sql = "INSERT INTO category(
                    cat_name
                )
                VALUES(
                
                    '$cat_name'
                )";
                mysqli_query($conn, $sql);
                header("location:index.php?page_layout=category");
            }
        }
    ?>
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="index.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li><a href="">Quản lý danh mục</a></li>
				<li class="active">Thêm danh mục</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Thêm danh mục</h1>
			</div>
		</div><!--/.row-->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="col-md-8">
                            <?php if( $error_name == 1) echo '<div class="alert alert-danger">Danh mục đã tồn tại !</div>'; ?>
                        	
                            <form role="form" method="post">
                            <div class="form-group">
                                <label>Tên danh mục:</label>
                                <input required type="text" name="cat_name" class="form-control" placeholder="Tên danh mục...">
                            </div>
                            <button type="submit" name="sbm" class="btn btn-success">Thêm mới</button>
                            <button type="reset" class="btn btn-default">Làm mới</button>
                        </div>
                    	</form>
                    </div>
                </div>
            </div><!-- /.col-->
	</div>	<!--/.main-->	
</body>

</html>
