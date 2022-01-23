<?php

class ExpensesInGroupTestsCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/groups');
        $I->seeCurrentUrlEquals('/login');
        $I->fillField('email', 'test@test.com');
        $I->fillField('password', 'test123');
        $I->click('Log in');

        $I->amOnPage('/groups');
        $I->click('Create');
        $I->fillField('name', 'test group');
        $I->click('Create');
        $I->see('test group');
        $I->click('test group');
        $I->amOnPage('/groups/test-group');




        $this->group_id = $I->grabFromDatabase('groups', 'id', [
            'id' => '1'
        ]);
        $this->slug = $I->grabFromDatabase('groups', 'slug', [
            'id' => '1'
        ]);
        $I->amOnPage("/groups/$this->slug");
        $I->seeCurrentUrlEquals("/groups/$this->slug");
        $I->see("add a new expense");
        $I->click("Add a new expense");
    }

    // tests
    public function TryingToAddNewExpenses(AcceptanceTester $I)
    {
        $I->seeCurrentUrlEquals("/groups/$this->group_id/expenses/create");
        $I->see("Who");
        $I->see("How");
        $I->see("How much");
        $I->seeInDatabase('users', ['name'=>'test2']);
        $option = $I->grabTextFrom('select option:nth-child(2)');
        $I->selectOption("select", "test2");
        //$I->dontsee("What kind of item ");

    }
}
