<?php

// Home page
$app->get('/', "writerblog\Controller\HomeController::indexAction")
->bind('home');

// Detailed info about a billet
$app->match('/billet/{id}', "writerblog\Controller\HomeController::billetAction")
->bind('billet');

// Login form
$app->get('/login', "writerblog\Controller\HomeController::loginAction")
->bind('login');

// Register form

$app->match('/register', "writerblog\Controller\HomeController::registerAction")
->bind('register')
->method('GET|POST');

// Admin zone
$app->get('/admin', "writerblog\Controller\AdminController::indexAction")
->bind('admin');


// billet controller 

// Edit an existing billet
$app->match('/admin/billet/{id}/edit', "writerblog\Controller\AdminController::billetEditAction")
->bind('admin_billet_edit');

// Add a new billet
$app->match('/admin/billet/add', "writerblog\Controller\AdminController::billetAddAction")
->bind('admin_billet_add');

// Remove a billet
$app->get('/admin/billet/{id}/delete', "writerblog\Controller\AdminController::billetDeleteAction")
->bind('admin_billet_delete');


// // comment controller 

// Edit an existing comment
$app->match('/admin/comment/{id}/edit', "writerblog\Controller\AdminController::commentEditAction")
->bind('admin_comment_edit');

// Remove a comment
$app->get('/admin/comment/{id}/delete', "writerblog\Controller\AdminController::commentDeleteAction")
->bind('admin_comment_delete');


// user controller

// Edit an existing user
$app->match('/admin/user/{id}/edit', "writerblog\Controller\AdminController::userEditAction")
->bind('admin_user_edit');

// Add a user
$app->match('/admin/user/add', "writerblog\Controller\AdminController::userAddAction")
->bind('admin_user_add');

// Remove a user
$app->get('/admin/user/{id}/delete', "writerblog\Controller\AdminController::userDeleteAction")
->bind('admin_user_delete');

