<?php

namespace App\Http\Controllers;

use App\Halo5\Models\Account;
use App\Halo5\Models\Season;
use Watson\Sitemap\Sitemap;

class SitemapController extends Controller
{
    /**
     * @var Sitemap
     */
    protected $sitemap;

    public function __construct(Sitemap $sitemap)
    {
        $this->sitemap = $sitemap;
    }

    public function getIndex()
    {
        $this->sitemap->addSitemap(route('sitemap.profiles'));
        $this->sitemap->addSitemap(route('sitemap.playlists'));
        $this->sitemap->addSitemap(route('sitemap.extras'));

        return $this->sitemap->index();
    }

    public function getProfiles()
    {
        /** @var Account[] $accounts */
        $accounts = Account::orderBy('gamertag', 'ASC')->get();

        foreach ($accounts as $account) {
            $this->sitemap->addTag(route('profile', $account->slug));
        }

        return $this->sitemap->render();
    }

    public function getPlaylists()
    {
        /** @var Season[] $seasons */
        $seasons = Season::with('playlists')->orderBy('startDate', 'DESC')->get();

        foreach ($seasons as $season) {
            foreach ($season->playlists as $playlist) {
                $this->sitemap->addTag(route('leaderboard', [$season->slug, $playlist->slug]), $season->updated_at, ($season->isActive ? 'hourly' : 'never'));
            }
        }

        return $this->sitemap->render();
    }

    public function getExtras()
    {
        $this->sitemap->addTag(route('about'));

        return $this->sitemap->render();
    }
}
