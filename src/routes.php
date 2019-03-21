<?php

// ==================================== Admin Routes ====================================
// Admin Section Route. ej: /admin/videos
Flight::route('GET /(admin(/@page:[0-9]+))', function ($page) {
    $admin = new Expomark\Controllers\AdminController();
    $admin->videosAction($page);
});
Flight::route('GET /section/@slug:[a-z0-9-]+(/@page:[0-9]+)', function ($slug, $page) {
    $admin = new Expomark\Controllers\SectionController();
    $admin->videosAction($slug, $page);
});

// ==================================== Search Routes ====================================
// Admin Search Route. ej: /admin/search/videos
Flight::route('GET /search', function () {
    $admin = new Expomark\Controllers\SearchController();
    $admin->videosAction();
});

// ==================================== Dump Mysql ====================================
// Admin Search Route. ej: /admin/search/videos
Flight::route('GET /dump', function () {
    $admin = new Expomark\Controllers\DumpController();
    $admin->indexAction();
});
// Admin Search Route. ej: /admin/search/videos
Flight::route('GET /dump/info', function () {
    $admin = new Expomark\Controllers\DumpController();
    $admin->infoAction();
});

// ==================================== Uploads Routes ====================================
// Uploads Route
Flight::route('POST /files/upload', function () {
    $file = new Expomark\Controllers\FileController();
    $file->uploadAction();
});

// ==================================== Edit Routes ====================================
// Edit Routes. ej: /edit/videos/34
Flight::route('GET /edit(/@id:[0-9]+)', function ($videoId) {
    $edit = new Expomark\Controllers\EditController();
    $edit->videosAction($videoId);
});
Flight::route('GET /edit/active/@id:[0-9]+', function ($videoId) {
    $edit = new Expomark\Controllers\EditController();
    $edit->activeAction($videoId);
});
Flight::route('GET /edit/deactive/@id:[0-9]+', function ($videoId) {
    $edit = new Expomark\Controllers\EditController();
    $edit->deactiveAction($videoId);
});
Flight::route('GET /edit/important/@id:[0-9]+', function ($videoId) {
    $edit = new Expomark\Controllers\EditController();
    $edit->importantAction($videoId);
});

// ==================================== Save Routes ====================================
// Save Routes. ej: /create/videos
Flight::route('POST /save(/@id:[0-9]+)', function ($videoId) {
    $save = new Expomark\Controllers\SaveController();
    $save->videosAction($videoId);
});

// ==================================== Delete Routes ====================================
// Delete Routes. ej: /edit/videos/34
Flight::route('GET /delete/@id:[0-9]+', function ($videoId) {
    $delete = new Expomark\Controllers\DeleteController();
    $delete->videosAction($videoId);
});

// ==================================== Users Routes ====================================
// Users Edit Route. ej: /users/edit/1
Flight::route('GET /users/edit/@id:[0-9]+', function ($userId) {
    $users = new Expomark\Controllers\UserController();
    $users->editAction($userId);
});
// Users Create Route. ej: /users/create
Flight::route('GET /users/create', function () {
    $users = new Expomark\Controllers\UserController();
    $users->editAction();
});
// Users Delete Route. ej: /users/edit/1
Flight::route('GET /users/delete/@id:[0-9]+', function ($userId) {
    $users = new Expomark\Controllers\UserController();
    $users->deleteAction($userId);
});
// Admin Search Route. ej: /users/search
Flight::route('GET /users/search', function () {
    $users = new Expomark\Controllers\UserController();
    $users->searchAction();
});
// Users TimeOut Route. ej: /users/timeout/lala@lala.com/[base64 referer url]
Flight::route('GET /users/timeout/@email/@url', function ($email, $url) {
    $users = new Expomark\Controllers\UserController();
    $users->timeoutAction($email, $url);
});
// Users Logout GET Route. ej: /users/logout
Flight::route('GET /users/logout', function () {
    $users = new Expomark\Controllers\UserController();
    $users->logoutAction();
});
// Users Login GET Route. ej: /users/login/[base64 referer url]
Flight::route('GET /users/login/@url', function ($url) {
    $users = new Expomark\Controllers\UserController();
    $users->loginPageAction($url);
});
// Users Login POST Route. ej: /users/login/[base64 referer url]
Flight::route('POST /users/login/@url', function ($url) {
    $users = new Expomark\Controllers\UserController();
    $users->loginAction($url);
});
// Users Save Route. ej: /users/save
Flight::route('POST /users/save(/@id:[0-9]+)', function ($userId) {
    $users = new Expomark\Controllers\UserController();
    $users->saveAction($userId);
});
// Users General Route. ej: /users/recover
Flight::route('GET /users(/@page:[0-9]+)', function ($page) {
    $users = new Expomark\Controllers\UserController();
    $users->indexAction($page);
});

// ==================================== Authors Routes ====================================
// author Edit Route. ej: /author/edit/1
Flight::route('GET /author/edit/@id:[0-9]+', function ($userId) {
    $author = new Expomark\Controllers\AuthorController();
    $author->editAction($userId);
});
// author Create Route. ej: /author/create
Flight::route('GET /author/create', function () {
    $author = new Expomark\Controllers\AuthorController();
    $author->editAction();
});
// author Save Route. ej: /author/save
Flight::route('POST /author/save(/@id:[0-9]+)', function ($userId) {
    $author = new Expomark\Controllers\AuthorController();
    $author->saveAction($userId);
});
// author General Route. ej: /author/recover
Flight::route('GET /author(/@page:[0-9]+)', function ($page) {
    $author = new Expomark\Controllers\AuthorController();
    $author->indexAction($page);
});
// Admin Search Route. ej: /admin/search/videos
Flight::route('GET /author/search', function () {
    $admin = new Expomark\Controllers\AuthorController();
    $admin->searchAction();
});
