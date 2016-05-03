<?php
?>

@extends('master')

@section('content')
    <div class="ui container">
        <div class="ui two columns stackable grid">
            <div class="column">
                <div class="ui black segment">
                    <div class="ui header">The Changelog</div>
                    <ul>
                        <li>v1.2.2 - 10am EST - 5/3/2016</li>
                        <ul>
                            <li>Leaderboards exist for some social playlists. wtf</li>
                            <li>Fix profile to show Social/Ranked playlist.</li>
                        </ul>
                        <br />
                        <li>v1.2.1 - 7am EST - 5/3/2016</li>
                        <ul>
                            <li>Fix when tie occurs on CSR</li>
                            <li>Handle seasons that have no name</li>
                            <li>Fix playlists missing leaderboards</li>
                            <li>Fix showing internal playlists</li>
                            <li>Fix n+1 problem on leaderboard</li>
                        </ul>
                        <br />
                        <li>v1.2.0 - 10pm EST - 4/24/2016</li>
                        <ul>
                            <li>Database Storage vs redis</li>
                            <li>Profile pages</li>
                            <li>Visual indicator for movement on leaderboards</li>
                            <li>One hour refresh on active season</li>
                        </ul>
                        <br />
                        <li>v1.1.1 - 8:30am EST - 4/21/2016</li>
                        <ul>
                            <li>Centered pagination</li>
                            <li>Snapped menu to sidebar on desktop</li>
                            <li>Increased per page to 50</li>
                        </ul>
                        <br />
                        <li>v1.1.0 - 10:00pm EST - 4/21/2016</li>
                        <ul>
                            <li>Source Released</li>
                            <li>Cleaned up mobile interface</li>
                            <li>Added image of Tier into leaderboard</li>
                        </ul>
                        <br />
                        <li>v1.0.0 - 12:00pm EST - 4/21/2016</li>
                        <ul>
                            <li>Leaderboards of top 250 of all past/present season</li>
                            <li>Infinite cache for seasons in past</li>
                            <li>10 minute cache for seasons in progress</li>
                        </ul>
                    </ul>
                </div>
            </div>
            <div class="column">
                <div class="ui blue segment">
                    <div class="ui header">The Team</div>
                    <ul>
                        <li><a href="https://twitter.com/iBotPeaches">@iBotPeaches</a></li>
                        <li><a href="https://github.com/brandon-lile">@brandon-lile</a></li>
                    </ul>
                </div>
                <div class="ui green segment">
                    <div class="ui header">The Source</div>
                    <ul>
                        <li><a href="https://github.com/iBotPeaches/Leafapp">Github</a></li>
                    </ul>
                </div>
                <div class="ui purple segment">
                    <div class="ui header">The FAQ</div>
                    <div class="ui list">
                        <span class="item">
                            <i class="help icon"></i>
                            <div class="content">
                                <div class="header">Can I help?</div>
                                <div class="description">The site is <a href="https://github.com/iBotPeaches/Leafapp" target="_blank">open sourced</a>. Comments, concerns or feature requests are welcome.</div>
                            </div>
                        </span>
                        <span class="item">
                            <i class="help icon"></i>
                            <div class="content">
                                <div class="header">I placed higher than this says!</div>
                                <div class="description">The stats are from the conclusion of the season, which would be the rank you had when that season ended.</div>
                            </div>
                        </span>
                        <span class="item">
                            <i class="help icon"></i>
                            <div class="content">
                                <div class="header">Why are social playlists shown?</div>
                                <div class="description">By accident I accidentally requested leaderboards for one and was surprised data was returned. This means that while never
                                visible in game, some social playlists have an associated CSR tracking and leaderboard (Preseason it seems). </div>
                            </div>
                        </span>
                    </div>
                </div>
                <div class="ui grey segment">
                    <div class="ui header">The Legal</div>
                    <p>
                        This application is offered by iBotPeaches, who is solely responsible for its content. It is not sponsored or endorsed by Microsoft.<br />
                        This application uses the Halo® Game Data API. Halo © 2015 Microsoft Corporation. <br />
                        All rights reserved. Microsoft, Halo, and the Halo Logo are trademarks of the Microsoft group of companies.
                    </p>
                </div>
            </div>
        </div>
    </div>
@stop