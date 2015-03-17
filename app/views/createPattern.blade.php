@extends('layout.main')
@section('content')
<div class="col-xs-12">
	<h1 class="text-center">Create Your Pattern</h1>
</div>
<div class="row">
	<div class="col-xs-6">
		<button id="playPattern" type="submit" class="btn btn-lg btn-primary pull-right"><span class="glyphicon glyphicon-play"></span> <span>Play</span></button>
	</div>
	<div class="col-xs-6">
		<button id="stopPattern" type="submit" class="btn btn-lg btn-primary"><span class="glyphicon glyphicon-stop"></span> <span>Stop</span></button>
	</div>
</div>
<!-- HINT: if there is a column arround you get problems with mouse x and y-->
<canvas class="center-block" id="myCanvas" width="700" height="120" style="border:1px solid #000000; margin:auto"></canvas>

<div class="row row-centered">
	<div class="col-xs-4 col-centered col-min" style="padding-left: 75px; margin-bottom: 20px;">
		<h5><strong>Hint: </strong>Search for patterns via direct input of notes or use the buttons below</h5>
	</div>
</div>


{{ Form::open(array('route' => 'patternSearch')) }}
{{ Form::hidden('pattern', '', array('id' => 'patternValue')) }}

<div class="container">

	<div class="row row-centered" style="margin-bottom: 30px;">
		<div class="col-xs-8 col-centered col-min">
			<h5>Choose Mode: </h5>
			<div class="btn-group" data-toggle="buttons">
				<label id="melody-mode-2" class="btn btn-mode btn-material-blue-grey active" data-toggle="tooltip" data-placement="top">
					<input type="radio" value=":melody">melody
				</label>
				<label id="sound-sequence-mode-0" class="btn btn-mode btn-material-blue-grey " data-toggle="tooltip" data-placement="top">
					<input type="radio" value=":sound sequence">sound sequence
				</label>
				<label id="rhythm-mode-1" class="btn btn-mode btn-material-blue-grey " data-toggle="tooltip" data-placement="top">
					<input type="radio" value=":rhythm">rhythm
				</label>
			</div>
		</div>
		<div class="col-xs-4 col-centered col-min">
			<h5>Special Ryth: </h5>
			<div class="btn-group" data-toggle="buttons">
				<label id="none" class="btn btn-special-ryth btn-material-blue-grey active" data-toggle="tooltip" data-placement="top">
                    <input type="radio" value=":none">None
                </label>
                <label id="triplet" class="btn btn-special-ryth btn-material-blue-grey" data-toggle="tooltip" data-placement="top">
					<input type="radio" value=":triplet">Triplet
				</label>
				<label id="dotted" class="btn btn-special-ryth btn-material-blue-grey" data-toggle="tooltip" data-placement="top">
					<input type="radio" value=":dotted">Dotted
				</label>
			</div>
		</div>
	</div>
	
	<div class="row row-centered" style="margin-bottom: 30px;">
		<div class="col-xs-8 col-centered col-min">
			<h5>Notes: </h5>
			<div class="btn-group" data-toggle="buttons">
				<label id="c" class="btn btn-note btn-material-blue-grey active" data-toggle="tooltip" data-placement="top">
					<input type="radio" value=":c">C
				</label>
				<label id="d" class="btn btn-note btn-material-blue-grey" data-toggle="tooltip" data-placement="top">
					<input type="radio" value=":d">D
				</label>
				<label id="e" class="btn btn-note btn-material-blue-grey" data-toggle="tooltip" data-placement="top">
					<input type="radio" value=":e">E
				</label>
				<label id="f" class="btn btn-note btn-material-blue-grey" data-toggle="tooltip" data-placement="top">
					<input type="radio" value=":f">F
				</label>
				<label id="g" class="btn btn-note btn-material-blue-grey" data-toggle="tooltip" data-placement="top">
					<input type="radio" value=":g">G
				</label>
				<label id="a" class="btn btn-note btn-material-blue-grey" data-toggle="tooltip" data-placement="top">
					<input type="radio" value=":a">A
				</label>
				<label id="b" class="btn btn-note btn-material-blue-grey" data-toggle="tooltip" data-placement="top">
					<input type="radio" value=":b">B
				</label>
                <label id="break" class="btn btn-note btn-material-blue-grey" data-toggle="tooltip" data-placement="top">
                    <input type="radio" value=":break">Pause
                </label>
			</div>
		</div>
		<div class="col-xs-4 col-centered col-min">
			<h5>Accidential: </h5>
			<div class="btn-group" data-toggle="buttons">
				<label id="none" class="btn btn-accidential btn-material-blue-grey active" data-toggle="tooltip" data-placement="top">
					<input type="radio" value=":none">none
				</label>
				<label id="#" class="btn btn-accidential btn-material-blue-grey" data-toggle="tooltip" data-placement="top">
					<input type="radio" value=":#">#
				</label>
				<label id="b" class="btn btn-accidential btn-material-blue-grey" data-toggle="tooltip" data-placement="top">
					<input type="radio" value=":b">b
				</label>
			</div>
		</div>
	</div>

	<div class="row row-centered" style="margin-bottom: 30px;">
		<div class="col-xs-8 col-centered col-min">
			<h5>Duration: </h5>
			<div class="btn-group" data-toggle="buttons">
				<label id="whole" class="btn btn-duration btn-material-blue-grey" data-toggle="tooltip" data-placement="top">
					<input type="radio" value=":whole">1/1
				</label>
				<label id="half" class="btn btn-duration btn-material-blue-grey" data-toggle="tooltip" data-placement="top">
					<input type="radio" value=":half">1/2
				</label>
				<label id="quarter" class="btn btn-duration btn-material-blue-grey active" data-toggle="tooltip" data-placement="top">
					<input type="radio" value=":quarter">1/4
				</label>
				<label id="eighth" class="btn btn-duration btn-material-blue-grey" data-toggle="tooltip" data-placement="top">
					<input type="radio" value=":eighth">1/8
				</label>
				<label id="16th" class="btn btn-duration btn-material-blue-grey" data-toggle="tooltip" data-placement="top">
					<input type="radio" value=":16th">1/16
				</label>
				<label id="32nd" class="btn btn-duration btn-material-blue-grey" data-toggle="tooltip" data-placement="top">
					<input type="radio" value=":32nd">1/32
				</label>
				<label id="64th" class="btn btn-duration btn-material-blue-grey" data-toggle="tooltip" data-placement="top">
					<input type="radio" value=":64th">1/64
				</label>
			</div>
		</div>
		<div class="col-xs-4 col-centered col-min">
			<h5>Clef: </h5>
			<div class="btn-group" data-toggle="buttons">
				<label id="F" class="btn btn-clef btn-material-blue-grey" data-toggle="tooltip" data-placement="top">
					<input type="radio" value=":F">F
				</label>
				<label id="G" class="btn btn-clef btn-material-blue-grey active" data-toggle="tooltip" data-placement="top">
					<input type="radio" value=":G">G
				</label>
			</div>
		</div>
	</div>

	<div class="row row-centered">
		<div class="col-xs-8 col-centered col-min">
            <h5>Octave: </h5>
            <div class="btn-group" data-toggle="buttons">
                <label id="2" class="btn btn-octave btn-material-blue-grey" data-toggle="tooltip" data-placement="top">
                    <input type="radio" value=":2">2
                </label>
                <label id="3" class="btn btn-octave btn-material-blue-grey" data-toggle="tooltip" data-placement="top">
                    <input type="radio" value=":3">3
                </label>
                <label id="4" class="btn btn-octave btn-material-blue-grey active" data-toggle="tooltip" data-placement="top">
                    <input type="radio" value=":4">4
                </label>
                <label id="5" class="btn btn-octave btn-material-blue-grey" data-toggle="tooltip" data-placement="top">
                    <input type="radio" value=":5">5
                </label>
                <label id="6" class="btn btn-octave btn-material-blue-grey" data-toggle="tooltip" data-placement="top">
                    <input type="radio" value=":6">6
                </label>
            </div>
		</div>
        <div class="col-xs-4 col-centered col-min">
            <button id="btn-add-note" type="button" class="btn btn-material-green-400">Add</button>
            <button id="btn-remove-note" type="button" class="btn btn-material-red-400">Delete</button>
        </div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			{{ Form::submit('Search', array('class' => 'btn btn-success btn-xxl pull-right')) }}
			{{ Form::close() }}
		</div>
	</div>
</div>
@stop