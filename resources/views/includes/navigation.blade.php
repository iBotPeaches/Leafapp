<?php
    /** @var string $route */
?>
<div class="ui container">
    <div class="ui inverted menu">
        <a href="{{ action('HomeController@getIndex') }}" class="item"><i class="icon leaf"></i>Leaf</a>
        @yield('navigation')
        <a href="{{ action('HomeController@getAbout') }}" class="<?= Route::is('/about') ? 'active' : null ?> item">About</a>
    </div>
</div>