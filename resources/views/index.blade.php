<?php
/** @var $seasons \App\Halo5\Models\Season[] */
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
                                <?= $season->startDate->format('M j o'); ?> to <?= $season->endDate->format('M j o'); ?>
                            <? endif; ?>
                        </div>
                    </div>
                    <a href="{{ route('leaderboard.index', [$season->slug]) }}" class="ui bottom attached button">
                        Leaderboards
                    </a>
                </div>
                <? endforeach; ?>
            </div>
        </div>
    </div>
@stop