<?php
/** @var $seasons \App\Halo5\Definitions\Season[] */
?>

@extends('master')

@section('content')
    <div class="ui container">
        <h2 class="ui header">Select a Season</h2>
    </div>
    <div class="ui doubling container row">
        <div class="column">
            <div class="ui cards">
                <? foreach ($seasons as $season): ?>
                <? if (count($season->playlists) > 0): ?>
                <div class="ui centered card">
                    <? if ($season->isActive): ?>
                        <a class="ui blue right corner label"><i class="crosshairs icon"></i></a>
                    <? endif; ?>
                    <div class="content">
                        <div class="header"><?= $season->name; ?></div>
                        <div class="description">
                            <? if ($season->isActive): ?>
                                Active Season
                            <? else: ?>
                                <?= $season->start_date; ?> to <?= $season->end_date; ?>
                            <? endif; ?>
                        </div>
                    </div>
                    <a href="{{ action('HomeController@getPlaylist', [$season->contentId]) }}" class="ui bottom attached button">
                        Leaderboards
                    </a>
                </div>
                <? endif; ?>
                <? endforeach; ?>
            </div>
        </div>
    </div>
@stop