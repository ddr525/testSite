<header id="header">
	<div class="header__user">
		<div class="container">
			<p>
			<?php
			if(isset($_SESSION['logged_user'])) {
				if($_SESSION['logged_user']->admin == 1){?>
				<span class="login"> Вы вошли в аккаунт администратора <span class="name"> <?php echo $_SESSION['logged_user']->login; ?></span></span>
				<a href="/user/logout">Выйти</a>
			</p>
			<p><a href="/admin_form/add_news">Добавить новость!</a>
				<?php } else { ?>
				<span class="login"> Добавление комментариев к новостям вам доступны, <span class="name"> <?php echo $_SESSION['logged_user']->login; ?></span></span>
				<a href="user/logout">Выйти</a>
				<?php }
			}
			else { ?>
					<a href="../user/sign_up">Регистрация</a>
					<a href="../user/login">Войти</a>
			<?php } ?>
			</p>
		</div>
	</div>
	<div class="header__top">
		<div class="container">
			<div class="header__top__logo">
			</div>
		</div>
		<div class="header__burger">
			<span></span>
		</div>
		<nav class="header__top__menu">
			<ul>
				<li><a href="/">Главная</a></li>
				<li><a href="/pages/about_me">Обо мне</a></li>
				<li><a href="#" target="blank">Я Вконтакте</a></li>
			</ul>
		</nav>
	</div>
</header>
