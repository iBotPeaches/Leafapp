<?php
/** @var $season \App\Halo5\Definitions\Season */
/** @var $record \App\Halo5\Models\Ranking */
/** @var $playlist \App\Halo5\Models\Playlist */
/** @var $rankings \Illuminate\Pagination\LengthAwarePaginator */
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
    <? foreach ($rankings as $record): ?>
    <tr class="<?= $record->color(); ?>">
        <td><?= $record->rank; ?></td>
        <td>
            <h4 class="ui image header">
                <img class="ui avatar image <?= $record->hasChanged() ? 'changed-popup' : null; ?>"
                     data-html="<?= $record->buildMessage(); ?>"
                     data-variation="inverted" src="<?= $record->image(); ?>"
                >
                <span class="content">
                    <a href="<?= route('profile', [$record->account]) ?>"><?= $record->account->gamertag; ?></a>
                </span>
            </h4>
        </td>
        <td><i class="icon <?= $record->arrow(); ?>"></i><?= number_format($record->csr); ?></td>
    </tr>
    <? endforeach; ?>
    </tbody>
</table>
<div class="ui centered grid">
    <div class="center aligned column">
        <?= (new App\Pagination($rankings))->render(); ?>
    </div>
</div>

@section('inline-js')
    <script type="text/javascript">
        $(function() {
            $(".changed-popup").popup({
            });
        });
    </script>
@append