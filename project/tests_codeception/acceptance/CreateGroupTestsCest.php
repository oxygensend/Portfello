<?php

use Symfony\Component\DomCrawler\Field\ChoiceFormField;
use Symfony\Component\DomCrawler\Field\FileFormField;

class CreateGroupTestsCest
{

    public function _before(AcceptanceTester $I)
    {
        // log in
        $I->amOnPage('/groups');
        $I->seeCurrentUrlEquals('/login');
        $I->fillField('email', 'test@test.com');
        $I->fillField('password', 'test123');
        $I->click('Log in');
    }
/*
    // tests
    public function noGroupsTest(AcceptanceTester $I)
    {
        $I->wantTo('Test if message when there is no groups displays properly');
        $I->amOnPage('/groups');
        $I->seeCurrentUrlEquals('/groups');
        $I->see('Nie należysz jeszcze do żadnej grupy.');
        $I->seeLink('Create');
    }

    public function redirectiontest(AcceptanceTester $I)
    {
        $I->wantTo("Test if redirection to create view works");
        $I->amOnPage('/groups');
        $I->click('Create');
        $I->seeCurrentUrlEquals('/groups/create');
    }
    public function validationForCreatingGroupsTest(AcceptanceTester $I)
    {
        $I->wantTo('Test validation errors while creating new group');
        $I->amOnPage('/groups/create');
        $I->fillField('name', '');
        $I->click('Create');
        $I->seeCurrentUrlEquals('/groups/create');
        $I->see('The name field is required');
        $I->dontSee('The avatar field is required');
        $I->dontSee('The smart_billing field is required');
    }

    public function AddGroupTest(AcceptanceTester $I)
    {
        $I->wantTo('Test creating new group');
        $I->amOnPage('/groups/create');
        $I->fillField('name', 'test group');
        $I->checkOption('smart_billing');
        $I->click('Create');
        $I->see('Group h1as been created');


        $I->seeCurrentUrlEquals('/groups');
        $I->dontSee('Nie należysz jeszcze do żadnej grupy.');
        $I->see('test group');
        $I->seeInDatabase('groups', ['name' => 'test group',
                                     'avatar' => "/images/default_group.png",
                                     'smart_billing' => 1]);
        $I->amOnPage('/groups/create');
        $I->fillField('name', 'test group2');
        $I->click('Create');
        $I->see('Group has been created');

        $I->seeCurrentUrlEquals('/groups');
        $I->dontSee('Nie należysz jeszcze do żadnej grupy.');
        $I->see('test group');
        $I->seeInDatabase('groups', ['name' => 'test group2',
                                     'avatar' => '/images/default_group.png',
                                     'smart_billing' => 0]);
    }*/
}
