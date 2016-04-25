<?php
/** @var $season \App\Halo5\Definitions\Season */
/** @var $record \App\Halo5\Models\Ranking */
/** @var $playlist \App\Halo5\Models\Playlist */
/** @var $rankings \Illuminate\Pagination\LengthAwarePaginator */
?>
<div class="ui middle aligned divided list">
    <? foreach ($rankings as $record): ?>
        <div class="item">
            <div class="right floated content">
                <span class="ui label"><?= number_format($record->csr); ?></span>
                <? if ($record->hasChanged()): ?>
                    <span class="ui <?= $record->color(true); ?> label"><i class="icon <?= $record->arrow(); ?>"></i></span>
                <? endif; ?>
            </div>
            <img class="ui avatar image" src="<?= $record->image(); ?>">
            <div class="content">
                <div class="header"><?= $record->rank; ?> - <?= $record->account->gamertag; ?></div>
            </div>
        </div>
    <? endforeach; ?>
</div>
<div class="ui centered grid">
    <div class="center aligned column">
        <?= (new App\Pagination($rankings))->render(); ?>
    </div>
</div>