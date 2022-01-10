<?php
$I = new AcceptanceTester($scenario ?? null);
$I->wantTo('see the application turning on');

$I->amOnPage('/');

// TODO, pamiętać żeby to zmienić
$I->seeInTitle("Portfello");

$I->seeLink('Sign in');
$I->seeLink('Log in');
