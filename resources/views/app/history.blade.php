@extends('app')

<div class="container-fluid">
	<div class="row">
		<a href="/" class="btn btn-primary">Back</a>
	</div>
	<div class="row">
	    <ul class="list-group">
	    	@if (count($history) != 0) 
			    @foreach ($history as $data)
			        <li class="list-group-item"><a href="{{ action('AppController@index', ['q'=>$data->search_term]) }}">{{ $data->search_term }}</a></li>
			    @endforeach
			@else
				<li class="list-group-item">No search history</li>
			@endif
	    </ul>
	</div>
</div>