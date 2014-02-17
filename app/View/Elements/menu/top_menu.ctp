<nav class="navbar navbar-default" role="navigation">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button><!-- /.navbar-toggle -->
		<?php echo $this->Html->Link('4S Searcher', array('controller'=>'places', 'action'=>'index'), array('class' => 'navbar-brand')); ?>
	</div><!-- /.navbar-header -->
	<div class="collapse navbar-collapse navbar-ex1-collapse">
		<form class="navbar-form navbar-left" role="search">
        	<div class="form-group">
        		<input type="text" class="form-control" placeholder="Search">
        	</div>
        	<button type="submit" class="btn btn-default">Search</button>
      	</form>
		<ul class="nav navbar-nav pull-right">
			<li><?php echo $this->Html->link(__('Show recomended'), array('action'=>'explore')) ?></li>
		</ul><!-- /.nav navbar-nav -->
	</div><!-- /.navbar-collapse -->
</nav><!-- /.navbar navbar-default -->