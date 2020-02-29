<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
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
