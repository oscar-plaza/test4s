<?php

/**

 *

 * PHP 5

 *

 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)

 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)

 *

 * Licensed under The MIT License

 * Redistributions of files must retain the above copyright notice.

 *

 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)

 * @link          http://cakephp.org CakePHP(tm) Project

 * @package       Cake.View.Layouts

 * @since         CakePHP(tm) v 0.10.0.1076

 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)

 */



$cakeDescription = __d('cake_dev', 'Forsquare searcher by Oscar Plaza');

?>

<?php echo $this->Html->docType('html5'); ?> 

<html>

	<head>

		<?php echo $this->Html->charset(); ?>

		<title>

			<?php echo $cakeDescription ?>:

			<?php echo $title_for_layout; ?>

		</title>

		<?php

			echo $this->Html->meta('icon');

			?>

    		<meta http-equiv="X-UA-Compatible" content="IE=edge">

    		<meta name="viewport" content="width=device-width, initial-scale=1">

			<?php



			echo $this->fetch('meta');



			echo $this->Html->css('bootstrap');

			echo $this->Html->css('modal/bootstrap-modal-bs3patch');

			echo $this->Html->css('modal/bootstrap-modal');

			echo $this->Html->css('main');



			echo $this->fetch('css');

		?>

	</head>



	<body>

		<div id="main-container">

		

			<div id="header" class="container">

				<nav class="navbar navbar-default" role="navigation">

					<div class="navbar-header">

						<?php echo $this->Html->Link('4S Searcher', array('controller'=>'places', 'action'=>'index'), array('class' => 'navbar-brand')); ?>

					</div><!-- /.navbar-header -->



					<ul class="nav navbar-nav pull-right">

						<li><?php echo $this->Html->link(__('With my location'), array('action'=>'explore'), array('id'=>'myLocation')) ?></li>
						<li><?php echo $this->Html->link(__('Recomended'), array('action'=>'explore'), array('id'=>'showExplorer')) ?></li>

					</ul><!-- /.nav navbar-nav -->

				</nav><!-- /.navbar navbar-default -->

			</div><!-- /#header .container -->

			

			<div id="content" class="container">

				<?php echo $this->Session->flash(); ?>

				<?php echo $this->fetch('content'); ?>

			</div><!-- /#content .container -->

			

			<div id="footer" class="container">

				<?php //Silence is golden ?>

			</div><!-- /#footer .container -->

			

		</div><!-- /#main-container -->





		<div class="modal fade" id="venue-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

			<!--<div class="modal-dialog">

				<div class="modal-content">-->

					<div class="modal-header">

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

						<h4 class="modal-title">&nbsp;</h4>

					</div>

					<div class="modal-body">

					</div>

				<!--</div>

			</div>-->

		</div><!-- /.modal -->



		

	<?php 

		echo $this->Html->script('libs/jquery-1.10.2.min');

		echo $this->Html->script('libs/bootstrap.min');

		echo $this->Html->script('https://maps.googleapis.com/maps/api/js?key='.Configure::read('GmapsKey').'&sensor=false');

		echo $this->Html->script('handlebars-v1.3.0');

		echo $this->Html->script('geoPosition');

		echo $this->Html->script('modal/bootstrap-modalmanager');

		echo $this->Html->script('modal/bootstrap-modal');



		echo $this->fetch('script');





		echo $this->Html->script('script');

		

	 ?>



	</body>



</html>