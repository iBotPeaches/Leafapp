<?php
/** @var $season \App\Halo5\Models\Season */
/** @var $record \App\Halo5\Definitions\Record */
/** @var $playlist \App\Halo5\Models\Playlist */
?>

@extends('master')

@section('navigation')
    <a class="active item"><?= $season->name; ?></a>
@stop

@section('content')
    <!-- SeasonId - <?= $season->contentId; ?> | playlistId - <?= $playlist->contentId; ?> -->
    <div class="ui container">
        <div class="ui stackable grid">
            <div class="three wide column">
                <div class="ui vertical stackable container black menu sticky">
                    <? foreach ($season->playlists as $_playlist): ?>
                        <a href="<?= route('leaderboard', [$season->slug, $_playlist->slug]); ?>" class="<?= ($playlist->contentId == $_playlist->contentId) ? 'active' : null ?> item">
                            <?= $_playlist->name; ?>
                        </a>
                    <? endforeach; ?>
                </div>
            </div>
            <div class="twelve wide column computer tablet only">
                <? if ($season->isActive): ?>
                    <div class="ui info message">
                        This season is still in process so leaderboards refresh every hour.
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