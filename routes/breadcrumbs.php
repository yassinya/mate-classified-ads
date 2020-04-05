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

// Home > my add
Breadcrumbs::for('my-ads', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('My ads', route('account.ads'));
});

// Home > ad confirmation
Breadcrumbs::for('ad-confirmation', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Ad confirmation');
});

// Home > category
Breadcrumbs::for('single-category', function ($trail, $category) {
    $trail->parent('home');
    $trail->push($category->name, route('categories.show.single', ['slug' => $category->slug]));
});

// Home > category > ad
Breadcrumbs::for('ad', function ($trail, $ad) {
    $title = mb_substr($ad->title, 0, 250);
    if(strlen($ad->title) > 250){
        $title.'...';
    }

    $trail->parent('single-category', $ad->category);
    $trail->push($title, route('ads.show.single', ['slug' => $ad->slug]));
});
