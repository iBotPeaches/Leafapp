
<?php
/** @var $season \App\Halo5\Definitions\Season */
/** @var $record \App\Halo5\Definitions\Record */
/** @var $paginator \Illuminate\Pagination\LengthAwarePaginator */
?>
<div class="ui middle aligned divided list">
    <? foreach ($paginator as $record): ?>
        <div class="item">
            <div class="right floated content">
                <span class="ui label"><?= number_format($record->csr->csr); ?></span>
            </div>
            <img class="ui avatar image" src="<?= $record->csr->image; ?>">
            <div class="content">
                <div class="header"><?= $record->rank; ?> - <?= $record->gamertag; ?></div>
            </div>
        </div>
    <? endforeach; ?>
</div>
<?= (new App\Pagination($paginator))->render(); ?>