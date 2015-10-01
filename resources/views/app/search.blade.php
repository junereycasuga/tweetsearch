@extends('app')

<div class="container-fluid">
    <div class="row map-container">
        <div id="map" style="width: 100%; height: 95%"></div>
    </div>
    <div class="row">
        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <input type="text" id="city-input" class="form-control" placeholder="Enter a City" value={{$q}}>
        </div>
        <input type="submit" class="btn btn-primary col-xs-3 col-sm-3 col-md-3 col-lg-3" value="Search" id="searchBtn">
        <a href="/history" class="btn btn-primary col-xs-3 col-sm-3 col-md-3 col-lg-3">History</a>
    </div>
</div>