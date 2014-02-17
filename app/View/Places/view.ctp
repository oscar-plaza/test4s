<?php $venue = $result['venue'] ?>
<div class="row">
	<div class="col-sm-12">
		<?php $address = !empty($venue['location']['address'])?$venue['location']['address']:'' ?>
		<h3><?php echo $venue['name'] ?> <small><br><?php echo $address ?></small></h3>

		<?php if (isset($venue['photos']['groups'][1]['items']) && !empty($venue['photos']['groups'][1]['items']) ): ?>
			<div class='photo-list'>
				<ul>
					<?php foreach ($venue['photos']['groups'][1]['items'] as $photo): ?>
						<li class="thumbnail">
							<?php echo $this->Html->image( $photo['prefix'] . "100x100". $photo['suffix'], array('width'=>'100px','height'=>'100px',) ) ?>
						</li>
					<?php endforeach ?>
				</ul>
			</div>
		<?php endif ?>

		<div class='cat-list clearfix'>
			<h4>Categories: </h4>
			<ul>
				<?php foreach ($venue['categories'] as $cat): ?>
					<li> 
						<?php echo $this->Html->image( $cat['icon']['prefix'] . "bg_32". $cat['icon']['suffix'], array('title' => $cat['name']," data-toggle" => "tooltip",  "data-placement"=>"top"  ) ) ?>
					</li>
				<?php endforeach ?>
			</ul>	
		</div>

		<?php if (isset($venue['rating'])): ?>
		<div class='cat-list'>
			<h4>Rating: <?php echo $venue['rating'] ?> <small>/ 10</small></h4>
		</div>
			
		<?php endif ?>

		<div class='cat-list'>
			<h4><?php echo $venue['likes']['count'] ?> <small>likes</small></h4>
		</div>

		<br class="clearfix">
		<br>
		<div class='tip-list'>
			<h4>Tips:</h4>
			<div id="carousel-tips-generic" class="carousel slide" data-ride="carousel">

			  <!-- Controls -->
			  <a class="pull-left" href="#carousel-tips-generic" data-slide="prev">
			    Prev
			  </a>
			  <a class="pull-right" href="#carousel-tips-generic" data-slide="next">
			    Next
			  </a>
			  <!-- Wrapper for slides -->
			  <div class="carousel-inner">
				    <?php 
				    $first = true;
					foreach ($venue['tips']['groups'][0]['items'] as $tip) {
						echo '<div class="item'.($first?' active':'').'"><blockquote> ';
						echo '<p>'.$tip['text'].'</p>';
						echo '<footer>'.$tip['user']['firstName'].'</footer>';
						echo '</blockquote></div>';
						$first = false;
					} ?>
			  </div>

			</div>
				
		</div>
	</div>
</div>

<?php  $this->Html->scriptBlock("
	jQuery(document).ready(function ($) {
		$('.cat-list img').tooltip();
	})
", array('block' => 'script'))?>
	

