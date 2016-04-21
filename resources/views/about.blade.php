<?php
?>

@extends('master')

@section('content')
    <div class="ui inverted menu">
        <a href="{{ action('HomeController@getIndex') }}" class="item"><i class="icon leaf"></i>Leafapp</a>
        <a href="{{ action('HomeController@getAbout') }}" class="active item">About</a>
    </div>
    <div class="ui two columns stackable grid">
        <div class="column">
            <div class="ui black segment">
                <div class="ui header">The Changelog</div>
                <ul>
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
                    <li><i>Coming Soon</i></li>
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
@stop