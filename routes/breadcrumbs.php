<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

// Home > register
Breadcrumbs::for('register', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Register', route('register'));
});

// Home > login
Breadcrumbs::for('login', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Login', route('login'));
});

// Home > submit ad
Breadcrumbs::for('submit-ad', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Submit your ad', route('ads.create'));
});

// Home > category
Breadcrumbs::for('category', function ($trail, $category) {
    $trail->parent('home');
    $trail->push($category->name, '/');
});

// Home > category > ad
Breadcrumbs::for('ad', function ($trail, $ad) {
    $trail->parent('category', $ad->category);
    $trail->push($ad->title, route('ads.show.single', ['slug' => $ad->slug]));
});
