<?php
    /** @var string $route */
?>
<div class="ui container">
    <div class="ui inverted menu">
        <a href="{{ route('index') }}" class="item"><i class="icon leaf"></i>Leaf</a>
        @yield('navigation')
        <a href="{{ route('about') }}" class="<?= Route::currentRouteName() == "about" ? 'active' : null ?> item">About</a>
    </div>
</div>