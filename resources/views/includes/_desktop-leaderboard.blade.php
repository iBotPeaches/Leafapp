<?php
/** @var $season \App\Halo5\Definitions\Season */
/** @var $record \App\Halo5\Definitions\Record */
/** @var $paginator \Illuminate\Pagination\LengthAwarePaginator */
?>
<table class="ui black selectable celled table">
    <thead>
    <tr>
        <th>Rank</th>
        <th>Gamertag</th>
        <th>CSR</th>
    </tr>
    </thead>
    <tbody>
    <? foreach ($paginator as $record): ?>
    <tr>
        <td><?= $record->rank; ?></td>
        <td>
            <h4 class="ui image header">
                <img src="<?= $record->csr->image; ?>" class="ui mini rounded image" />
                <span class="content">
                    <?= $record->gamertag; ?>
                </span>
            </h4>
        </td>
        <td><?= number_format($record->csr->csr); ?></td>
    </tr>
    <? endforeach; ?>
    </tbody>
</table>
<?= (new App\Pagination($paginator))->render(); ?>