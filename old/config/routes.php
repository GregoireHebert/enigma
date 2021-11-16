<?php

declare(strict_types=1);

use App\Controller\Chat;
use App\Controller\Fibonacci;
use App\Controller\Forum;
use App\Controller\ForumNew;
use App\Controller\ForumPost;
use App\Controller\Home;
use App\Controller\Login;
use App\Controller\LoginCheck;
use App\Controller\Logout;
use App\Controller\Register;
use App\Routing\Routing;

$routing = new Routing();

$routing->addRoute('logout', '/logout', Logout::class);
$routing->addRoute('fibonnaci', '/fibonnaci', Fibonacci::class);
$routing->addRoute('chat', '/chat', Chat::class);
$routing->addRoute('forum', '/forum', Forum::class);
$routing->addRoute('newPost', '/forum/new', ForumNew::class);
$routing->addRoute('post', '/forum/post', ForumPost::class);
$routing->addRoute('login', '/login', Login::class);
$routing->addRoute('loginCheck', '/loginCheck', LoginCheck::class);
$routing->addRoute('newAccount', '/newaccount', Register::class);
$routing->addRoute('home', '/', Home::class);
$routing->addRoute('default', '', Home::class);

