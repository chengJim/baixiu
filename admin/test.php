
<?php
require_once '../functions.php';

xiu_get_current_user();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Navigation menus &laquo; Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
</head>

<body>

	<div class="main">
		<?php include 'inc/navbar.php' ?>
		<div class="container-fluid">
		  <div class="page-title">
		    <h1>测试</h1>
		  </div>
		  <ul id="movies">...</ul>
		</div>

		<table class="table table-striped table-bordered table-hover">
			<tr>
				<th>变量属性名</th>
				<th>变量属性值</th>
			</tr>
		    <tr>
		    	<td> $_SERVER['PHP_SELF'] </td>
		    	<td><?php echo $_SERVER['PHP_SELF'] ?></td>
		    </tr>
		    <tr>
		    	<td> __FILE__ </td>
		    	<td><?php echo __FILE__ ?></td>
		    </tr>
		    <tr>
		    	<td> dirname(__FILE__) </td>
		    	<td><?php echo dirname(__FILE__) ?></td>
		    </tr>
		</table>

		<div>
			<?php
			$post_count = xiu_fetch_all ('select * from posts;');
			var_dump($post_count[0]);
			?>
			
		</div>

		<div>
			<li<?php echo 2 === 'test' ? 'class="active"' : 'budengyu' ?>>li标签的内容</li>
		</div>









		

	</div>


  	<?php $current_page = 'test'; ?>
  	<?php include 'inc/sidebar.php'; ?>

</body>
</html>

