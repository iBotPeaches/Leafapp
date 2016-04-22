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
                    <div class="ui header">The Roadmap</div>
                    <ul>
                        <li class="strikethrough">Mobile Support</li>
                        <li>Profiles</li>
                        <li>Last Updated counter</li>
                        <li>Visual indicator on place in leaderboard</li>
                        <li>Search for gamertag</li>
                    </ul>
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