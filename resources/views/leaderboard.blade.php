<?php
/** @var $season array */
/** @var $paginator \Illuminate\Pagination\LengthAwarePaginator */
/** @var $playlistId string */
?>

@extends('master')

@section('content')
    <div class="ui inverted menu">
        <a href="{{ action('HomeController@getIndex') }}" class="item"><i class="icon leaf"></i>Leafapp</a>
        <a class="active item"><?= $season['name']; ?></a>
        <a href="{{ action('HomeController@getAbout') }}" class="item">About</a>
    </div>
    <div class="ui grid">
        <div class="three wide column">
            <div class="ui secondary vertical pointing menu">
                <? foreach($season['playlists'] as $playlist): ?>
                    <? if($playlist['isRanked']): ?>
                        <a href="<?= action('HomeController@getPlaylist', [$season['contentId'], $playlist['contentId']]); ?>" class="<?= ($playlistId == $playlist['contentId']) ? 'active' : null ?> item">
                            <?= $playlist['name']; ?>
                        </a>
                    <? endif; ?>
                <? endforeach; ?>
            </div>
        </div>
        <div class="twelve wide column">
            <? if ($season['isActive']): ?>
                <div class="ui info message">
                    This season is still in process so leaderboards refresh every 10 minutes.
                </div>
            <? endif; ?>
            <table class="ui selectable celled table">
                <thead>
                <tr>
                    <th>Rank</th>
                    <th>Gamertag</th>
                    <th>CSR</th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($paginator as $item): ?>
                <tr>
                    <td><?= $item['rank']; ?></td>
                    <td><?= $item['gamertag']; ?></td>
                    <td><?= number_format($item['csr']['csr']); ?></td>
                </tr>
                <? endforeach; ?>
                </tbody>
            </table>
            <?= (new App\Pagination($paginator))->render(); ?>
        </div>
    </div>
@stop