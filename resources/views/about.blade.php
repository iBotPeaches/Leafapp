<?php
?>

@extends('master')

@section('content')
    <div class="ui inverted menu">
        <a href="{{ action('HomeController@getIndex') }}" class="item"><i class="icon leaf"></i>Leafapp</a>
        <a href="{{ action('HomeController@getAbout') }}" class="active item">About</a>
    </div>
    <div class="ui two columns stackable grid">
        <div class="column">
            <div class="ui black segment">
                <ul>
                    <li>v1.0.0 - initial release</li>
                    <ul>
                        <li>Leaderboards of top 250 of all past/present season</li>
                        <li>Infinite cache for seasons in past</li>
                        <li>10 minute cache for seasons in progress</li>
                    </ul>
                </ul>
            </div>
        </div>
        <div class="column">
            <div class="ui blue segment">
                <div class="ui header">The Team</div>
                <ul>
                    <li><a href="https://twitter.com/iBotPeaches">@iBotPeaches</a></li>
                    <li><a href="https://github.com/brandon-lile">@brandon-lile</a></li>
                </ul>
            </div>
        </div>
    </div>
@stop