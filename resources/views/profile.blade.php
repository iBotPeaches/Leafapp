<?php
/** @var $account \App\Halo5\Models\Account */
/** @var $history \App\Halo5\HistoryCollection */
/** @var $rank \App\Halo5\Models\Ranking */
?>

@extends('master')

@section('navigation')
    <a class="active item"><?= $account->gamertag; ?></a>
@stop

@section('content')
    <div class="ui container">
        <div class="ui stackable grid">
            <div class="six wide column">
                <h3 class="ui header">Account Info</h3>
                <div class="ui black segment">
                    <h1 class="ui header"><?= $account->gamertag; ?></h1>
                </div>
            </div>
            <div class="nine wide column">
                <h3 class="ui header">Notable Placements</h3>
                <? foreach($history as $season): ?>
                    <h4 class="ui top attached header">
                        <?= $season['season']->name; ?><?= $season['season']->isActive ? '<span class="ui horizontal blue label">Ongoing Season</span>' : null; ?>
                    </h4>
                    <div class="ui attached blue segment">
                        <div class="ui middle aligned selection list">
                            <? foreach ($season['playlists'] as $rank): ?>
                                <div class="item">
                                    <img class="ui avatar image" src="<?= $rank->image(); ?>" />
                                    <div class="content">
                                        <div class="header">
                                            <?= $rank->rank; ?> <?= $rank->csrr->name; ?> in <strong><?= $rank->playlist->name; ?></strong>
                                            with a CSR of <strong><?= number_format($rank->csr); ?></strong>.
                                        </div>
                                    </div>
                                </div>
                            <? endforeach; ?>
                        </div>
                    </div>
                <? endforeach; ?>
            </div>
        </div>
    </div>
@stop