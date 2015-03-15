@extends('layout.main')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-xs-12">
			{{ Form::hidden('pattern', json_encode(Cache::get('pattern')[0]), array('id' => 'patternValue')) }}
			<canvas id="patternCanvas" width="950" height="186"></canvas>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-6">
		{{-- <input id="playResult" type="button" value="Play"/> --}}
		<button id="playResult" type="submit" class="btn btn-lg btn-primary pull-right"><span class="glyphicon glyphicon-play"></span> <span>Play</span></button>
	</div>
		{{-- <input id="pauseResult" type="button" value="Pause" style="display: none;"/> --}}
		{{-- <input id="stopResult" type="button" value="Stop"/> --}}
	<div class="col-xs-6">
		<button id="stopResult" type="submit" class="btn btn-lg btn-primary"><span class="glyphicon glyphicon-stop"></span> <span>Stop</span></button>
	</div>
</div>

<div id="extract-carousel" class="carousel slide" data-ride="carousel" data-interval="false">

	<!-- Indicators -->
	<ol class="carousel-indicators">
		<?php for ($i = 0; $i < count($resultNotes); $i++): ?>
			<li data-target="#extract-carousel" data-slide-to="<?php echo $i; ?>"<?php if ($i==0) echo ' class="active"'; ?>></li>
		<?php endfor; ?>
	</ol>

	<!-- Wrapper for slides -->
	<div class="carousel-inner" role="listbox">
		<?php for ($i = 0; $i < count($resultNotes); $i++): ?>
			<div class="item<?php if ($i==0) echo ' active'; ?>">
				<center><canvas id="canvas<?php echo $i; ?>" class="canvas" height="<?php echo round(count($resultNotes[$i]->measures) / 2) * 130; ?>" width="970"></canvas></center>
				{{ Form::hidden('resultNotes' . $i, json_encode($resultNotes[$i]), array('id' => 'notes' . $i, 'class' => 'notes')) }}
			</div>
		<?php endfor; ?>
	</div>

	<!-- Controls -->
	<a class="left carousel-control" href="#extract-carousel" role="button" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="right carousel-control" href="#extract-carousel" role="button" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>
</div>

<div class="row">
	<div class="col-xs-12">
		<a href="{{ URL::route('searchResults') }}">&laquo; Back to results</a>
	</div>
</div>

@stop