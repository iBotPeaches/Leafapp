<?php
/** @var $season \App\Halo5\Definitions\Season */
/** @var $record \App\Halo5\Definitions\Record */
/** @var $paginator \Illuminate\Pagination\LengthAwarePaginator */
/** @var $playlistId string */
?>

@extends('master')

@section('navigation')
    <a class="active item"><?= $season->name; ?></a>
@stop

@section('content')
    <div class="ui container">
        <div class="ui stackable grid">
            <div class="three wide column">
                <div class="ui vertical stackable container black menu sticky">
                    <? foreach($season->playlists as $playlist): ?>
                        <? if($playlist->isRanked): ?>
                            <a href="<?= action('HomeController@getPlaylist', [$season->contentId, $playlist->contentId]); ?>" class="<?= ($playlistId == $playlist->contentId) ? 'active' : null ?> item">
                                <?= $playlist->name; ?>
                            </a>
                        <? endif; ?>
                    <? endforeach; ?>
                </div>
            </div>
            <div class="twelve wide column computer tablet only">
                <? if ($season->isActive): ?>
                    <div class="ui info message">
                        This season is still in process so leaderboards refresh every 10 minutes.
                    </div>
                <? endif; ?>
                @include('includes._desktop-leaderboard')
            </div>
            <div class="twelve wide column mobile only">
                @include('includes._mobile-leaderboard')
            </div>
        </div>
    </div>
@stop

@section('inline-js')
    <script type="text/javascript">
        $(function() {

            if ($(window).width() > 480) {
                $(".ui.sticky").sticky({
                    context: ".twelve.wide.column",
                    offset: 5
                });
            }
        });
    </script>
@append