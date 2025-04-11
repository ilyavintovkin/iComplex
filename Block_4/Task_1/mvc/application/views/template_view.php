<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<title>Clining service</title>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
		<link href="http://fonts.googleapis.com/css?family=Kreon" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="../css/style.css" />

		<script type="text/javascript">
		// return a random integer between 0 and number
		function random(number) {
			
			return Math.floor( Math.random()*(number+1) );
		};
		
		// show random quote
		$(document).ready(function() { 

			var quotes = $('.quote');
			quotes.hide();
			
			var qlen = quotes.length; //document.write( random(qlen-1) );
			$( '.quote:eq(' + random(qlen-1) + ')' ).show(); //tag:eq(1)
		});
		</script>
	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<div id="logo">
					<a href="/">Мойдодыр</span></a>
				</div>
				<div id="menu">
					<ul>
						<li class="first active"><a href="/">Услуги</a></li>
                        <li><a href="/comment">Посмотреть отзывы</a></li>
                        <li><a href="/comment/sendComment">Отправить отзыв</a></li>
					</ul>
					<br class="clearfix" />
				</div>
			</div>
			<div id="page">
				<div id="sidebar">
					<div class="side-box">
						<h3>Наши ценности</h3>
						<p align="justify" class="quote">
                            <strong>Чистота и качество.</strong> Мы гарантируем высококачественные услуги по уборке, используя только эффективные и безопасные средства, чтобы обеспечить идеальную чистоту и здоровье наших клиентов.
						</p>
						<p align="justify" class="quote"><!-- &copy; Vitaly Swipe -->
                            <strong>Надежность и пунктуальность.</strong> Мы понимаем, насколько важно доверие, поэтому наша команда всегда прибывает вовремя и выполняет работу в оговоренные сроки.
						</p>
						<p align="justify" class="quote">
                            <strong>Ответственность и забота.</strong> Мы заботимся о вашем доме или бизнесе, принимая все меры для того, чтобы не повредить имущество и оставлять пространство в идеальном состоянии.
						</p>
						<p align="justify" class="quote"><!-- &copy; Vitaly Swipe -->
                            <strong>Экологическая безопасность.</strong> Мы используем экологически чистые и безопасные моющие средства, чтобы минимизировать воздействие на окружающую среду и здоровье клиентов.
						</p>
						<p align="justify" class="quote">
                            <strong>Профессионализм и обучаемость.</strong> Все наши сотрудники проходят регулярное обучение и повышения квалификации, чтобы предоставлять услуги на самом высоком уровне и следить за новыми тенденциями в клининговой отрасли.
						</p>
					</div>

				</div>
				<div id="content">
					<div class="box">
						<?php include __DIR__ . '/../views/'.$content_view; ?>
					</div>
					<br class="clearfix" />
				</div>
				<br class="clearfix" />
			</div>
			<div id="page-bottom">
				<div id="page-bottom-sidebar">
					<h3>Наши контакты</h3>
					<ul class="list">
						<li class="first">tg: @moydodir</li>
						<li class="last">email: moydodir@gmail.com</li>
					</ul>
				</div>
				<div id="page-bottom-content">
					<h2>О Компании</h2>
					<p>
                        Наша клининговая компания предоставляет высококачественные услуги уборки для домов и офисов. Мы гарантируем чистоту и порядок, используя экологически безопасные средства и современные технологии. Наша команда профессионалов всегда готова выполнить работу быстро и качественно, с вниманием к деталям. Мы ценим ваше время и гарантируем надежность, высокие стандарты обслуживания и индивидуальный подход к каждому клиенту.
					</p>
				</div>
				<br class="clearfix" />
			</div>
		</div>
		<div id="footer">
			<a href="/">МОЙДОДЫР</a> &copy; 2025</a>
		</div>
	</body>
</html>