<?php
/** @var $seasons array */
?>

@extends('master')

@section('content')
    <div class="ui inverted menu">
        <a href="{{ action('HomeController@getIndex') }}" class="item"><i class="icon leaf"></i>Leafapp</a>
        <a href="{{ action('HomeController@getAbout') }}" class="item">About</a>
    </div>
    <h2 class="ui header">Select a Season</h2>
    <div class="ui cards">
        <? foreach ($seasons as $season): ?>
        <? if (count($season['playlists']) > 0): ?>
            <div class="card">
                <? if ($season['isActive']): ?>
                    <a class="ui blue right corner label"><i class="crosshairs icon"></i></a>
                <? endif; ?>
                <div class="content">
                    <div class="header"><?= $season['name']; ?></div>
                    <div class="description">

                    </div>
                </div>
                <a href="{{ action('HomeController@getPlaylist', [$season['contentId']]) }}" class="ui bottom attached button">
                    Go to Leaderboards
                </a>
            </div>
        <? endif; ?>
    <? endforeach; ?>
    </div>
@stop