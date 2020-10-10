<?php
	include "libs/db_rb.php";
	include "includes/config.php";

	$_GET['id'];
	$_SESSION['id'] = $_GET['id'];

	$article = R::findOne('articles', 'id = :id', array(':id' => $_SESSION['id']));

	R::exec("UPDATE `articles` SET `views` = `views` + 1 WHERE `id` = :id", array(  ':id' => $_SESSION['id']  ));

	if(isset($_POST['do_post']) && isset($_POST['text']) != ''){
		R::exec("UPDATE `articles` SET `views` = `views` - 2 WHERE `id` = :id", array(  ':id' => $_SESSION['id']  ));
	header("Location: article?id=".$_SESSION['id']);
	}

	if( isset($_POST['do_post'])){
		$errors = array();
		if($_POST['text'] == '')
			$errors[] = "Введите комментарий к новости";
		
		if(empty($errors)){
			$vr = '+3 hour';
			$comm = R::dispense('comments');
			$comm->user = $_SESSION['logged_user']->login;
			$comm->text = $_POST['text'];
			$comm->pubdate = date('d.m.Y, H:i', strtotime($vr));
			$comm->idarticle = $article->id;
			R::store($comm);
		}
		else
			$message = '<span style="color: red; font-weight: bold;">' . $errors[0] . '<hr></span>';
	}
	$comments = R::find('comments', 'idarticle = :id ORDER BY id DESC', array(':id' => $_SESSION['id']));
	$count_comment = R::count('comments', 'idarticle = ?', [(int)$_SESSION['id']]);
?>
<!DOCTYPE html>
<html lang="kz">
<head>
	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width">
	<title><?php echo $article->title?> - Жастар Пікірі</title>
	<link rel="stylesheet" type="text/css" href="media/css/style.css">

</head>
<body>
	<div id="wrapper">
		<?php include "includes/header.php";
		if( $article <= 0 ){?>
			<script> document.location.href="404.html"; </script>
		<?php } else{
		?>
		<div id="content">
			<div class="main">
				<div class="container">
					<div class="block">
					<?php if($_SESSION['logged_user']->admin == 1) { ?>
						<div class="admin_buttons">
							<button class="admin_button" id="btn">Удалить новость</button>
								<div id="viewModal" style="display: none;">
									Удалить?
									<button id="yes">Да</button>
									<button id="no"> Нет </button>
									<span id="close" style="cursor:pointer;">&times;</span>
								</div>
							<button class="admin_button" id="change_btn">Изменить новость</button>
						</div>
					<?php }
						if(!$article->image == '') : ?>
						<img src="<?php echo "static/images/".$art['image']; ?>" style="max-width: 100%; height: 200px;">
					<?php endif; ?>
					<h3> <?php echo $article->title; ?> </h3>
					
						<div class="block__content">
							
							<div class="full-text">
								<?php echo $article->text; ?>
							</div>
						</div>
				<?php } ?>
					</div>
				</div>
				<div class="container">
					<div class="block_comment">
						<a href="#comment-add-form">Добавить свой</a>
						<h3>Комментарии <span style="color:#68a8cf"><?php echo $count_comment?></span></h3>
						<div class="block_comment">
							<div class="articles articles__vertical">
							<?php
								if( $count_comment <=0 ) {
									echo 'Комментариев нет';
								}
							foreach($comments as $comment)
							{ ?>
								<div class="comment">
									<h4> <?php echo $comment->user; ?> </h4> 
									<h4> <?php echo $comment->text; ?> </h4>
									<h4> <?php echo $comment->pubdate ?> </h4>
									<hr> 
								</div>
								<?php }
								if( $count_comment > 3 ) { ?>
									<input type="checkbox" id="com" name="com"><label for="com">Показать все комментарии</label>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
		
				<?php if(isset($_SESSION['logged_user']) ) : ?>
				
						<div class="block" id="comment-add-form">
							<h3>Добавить комментарий</h3>
							<div class="block_comment">
								<form class="form" method="POST" id="resetPost" action="/article?id=<?php echo $_SESSION['id']; ?>#comment-add-form">
									<?php echo $message;?>
									<div class="form__group">
										<textarea name="text"  class="form__control" placeholder="Текст комментария ..."></textarea>
									</div>
									<div class="form__group">
										<input type="submit" class="form__control" name="do_post" value="Добавить комментарий">
									</div>
								</form>
							</div>
							</div>
				<?php else : ?>
						<div class="block_comment" id="comment-add-form">
							<h3>Гости не могут добавлять комментарии к новостям, <a href="user/login">Войдите</a> или <a href="user/sign_up">Зарегистрируйтесь</a></h3>
						</div>
				<?php endif;?>
					</div>
					<?php include "includes/sidebar.php"; ?>
				</div>
			</div>
		</div>
	</div>
	<?php include "includes/footer.php"; ?>

	<script src="js/jquery-3.5.1.min.js"></script>
	<script src="js/menu_fixed.js"></script>
	<script src="js/view-comments.js"></script>
	<script>
		let btn = document.getElementById('btn');
		let viewModal = document.getElementById("viewModal");
		let change_btn = document.getElementById("change_btn");

		let close = document.querySelector("#close");
		let	yes   = document.querySelector("#yes");
		let	no    = document.querySelector("#no");

		btn.onclick = () => {
			viewModal.style.display = "block";
		}
		close.onclick = () => {
			viewModal.style.display = "none";
		}
		yes.onclick = () => {
			document.location.href="admin_form/delete_news";
		}
		no.onclick = () => {
			viewModal.style.display = "none";
		}
		change_btn.onclick = () => {
			document.location.href="admin_form/change_news";
		}
	</script>
</body>
</html>