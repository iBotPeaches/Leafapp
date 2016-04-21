<?php
/** @var $seasons array */
?>

@extends('master')

@section('content')
    <div class="ui inverted menu">
        <a class="item">Leafapp</a>
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
                <div class="ui bottom attached button">
                    Go to Leaderboards
                </div>
            </div>
        <? endif; ?>
    <? endforeach; ?>
    </div>
@stop