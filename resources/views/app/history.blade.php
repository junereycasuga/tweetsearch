@extends('app')

<div class="container-fluid">
    <ul>
    @foreach ($history as $data)
        <li><a href="/?q={{$data->search_term}}">{{ $data->search_term }}</a></li>
    @endforeach
    </ul>
</div>