<?php namespace App\Http\Controllers;

use App\Halo5\HistoryCollection;
use App\Halo5\Models\Account;

use App\Http\Requests;

class ProfileController extends Controller
{
    /**
     * @param $account Account
     * @return mixed
     */
    public function getProfile(Account $account)
    {
        $account->load('rankings.season', 'rankings.csrr', 'rankings.playlist');

        return view('profile', [
            'account' => $account,
            'history' => new HistoryCollection($account->rankings),
            'title' => 'Leaf - ' . $account->gamertag,
            'description' => 'Leaf - Halo 5 Guardians Profile: ' . $account->gamertag
        ]);
    }
}
