<?php
use Symfony\Component\DomCrawler\Field\ChoiceFormField;
use Symfony\Component\DomCrawler\Field\FileFormField;

class AddingUserToGroupCest
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

    // tests
    public function BasicCheckTest(AcceptanceTester $I)
    {
        $I->wantTo('Test validation errors while adding new user to group');
        $I->amOnPage('/groups');
        $I->click('Create');
        $I->fillField('name', 'Fajna grupa');
        $I->click('Create');
        $I->see('Fajna grupa');
        $I->click('Fajna grupa');
        $I->seeCurrentUrlEquals('/groups/fajna-grupa');
        $I->see('Add user');
        //TODO
        /*$I->dontSee('Insert username ');
        $I->click('Add user');
        $I->fillField('username', '');
        $I->click('Add');
        $I->seeCurrentUrlEquals('/groups/fajna-grupa');
        $I->see('The username field is required');*/
    }
}
