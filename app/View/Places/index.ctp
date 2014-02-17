<div class="row">
	<div class="col-xs-12">
		<?php echo $this->Form->create('Places', array('class'=>'form-inline')) ?>
			<?php echo $this->Form->input('latitude', array('name'=>'latitude', 'type'=>'hidden')) ?>
			<?php echo $this->Form->input('longitude', array('name'=>'longitude', 'type'=>'hidden')) ?>
			<?php echo $this->Form->input('sort', array('name'=>'sort', 'type'=>'hidden')) ?>
			<?php echo $this->Form->input('q', array('name'=>'q', 'type'=>'text', 'class'=>'form-control', 'label' => false, 'div' => array('class'=>'form-group', 'style'=>'display: inline-block'), 'placeholder' => 'Type...')) ?>
			<?php echo $this->Form->submit('Search', array('class'=>'btn btn-default', 'div' => false)); ?>
      	<?php echo $this->Form->end(); ?>
	</div>
</div>
<br>
<div class="row">
	<div class="col-sm-4">
		<h2 id="venue-list-title">Loading...</h2>
		<div class="list-group" id="venue-list">
		  
		</div>
	</div>
	<div class="col-sm-8">
		<div id="gmap" class="mapdiv"></div>
	</div>
</div>

<script type="text/javascript">
	var nearUrl = "<?php echo $this->Html->url(array('action'=>'near', 'ext'=>'json')) ?>";
	var viewUrl = "<?php echo $this->Html->url(array('action'=>'view')) ?>";
	var exploreUrl = "<?php echo $this->Html->url(array('action'=>'explore', 'ext'=>'json')) ?>";
</script>

<script id="venue-list-template" type="text/x-handlebars-template">
	<a href="#" class="list-group-item" id="venue_{{id}}" data-venue="{{id}}">
		<h4 class="list-group-item-heading">{{name}}</h4>
		<p class="list-group-item-text">{{location.address}}</p>
  	</a>
</script>