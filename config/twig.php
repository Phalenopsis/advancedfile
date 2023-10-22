<?php

require_once __DIR__ . '/../vendor/autoload.php';

$loader = new Twig\Loader\FilesystemLoader(__DIR__ . '/../src/View');
$twig = new Twig\Environment($loader, ['debug' => true, 'cache' => false]);
$twig->addExtension(new Twig\Extension\DebugExtension());

$contact = "contact@wcs.com";
$twig->addGlobal('contactEmail', $contact);
