<?php


class DashboardTestsCest {

    public function _before(AcceptanceTester $I)
    {

        // Login
        $I->amOnPage('/dashboard');
        $I->seeCurrentUrlEquals('/login');
        $I->fillField('email', 'test@test.com');
        $I->fillField('password', 'test123');
        $I->click('Log in');

        $I->seeCurrentUrlEquals('/dashboard');
    }


    private function createExpense($how_much, $title, $group, AcceptanceTester $I)
    {
        $I->amOnPage("/groups/$group/expenses/create");
        $I->click('Select users');
        $I->checkOption('all');
        $I->click('#user_confirm');
        $I->fillField('description', $title);
        $I->selectOption('form select[name=how]', 'money');
        $I->fillField('how_much', $how_much);
        $I->click('#button_select_confirm');
        $I->amOnPage('/dashboard');
    }

    private function createGroupWithUser($name, $group, AcceptanceTester $I)
    {
        $I->amOnPage('groups/create');
        $I->fillField('name', $name);
        $I->click('Create');
        $I->haveInDatabase('group_user', ['user_id' => 2, 'group_id' => $group]);

    }

    public function UserNotInAnyGroupTest(AcceptanceTester $I)
    {

        $I->wantTo('Test if proper message is displayed when user dont belong to any group');
        $I->see("Overall you are owed 0");
        $I->see("You don't belong to any group yet.");

    }


    public function UserInGroupButDontHaveExepnsesTest(AcceptanceTester $I)
    {

        $I->wantTo('Test if proper message is displayed when user belong to group but dont have any expenses');
        $I->amOnPage('groups/create');
        $I->fillField('name', 'test group');
        $I->click('Create');
        $I->seeInDatabase('groups', ['id' => 1, 'user_id' => 1]);
        $I->seeInDatabase('group_user', ['user_id' => 1, 'group_id' => 1]);
        $I->amOnPage('/dashboard');
        $I->see("Overall you are owed 0");
        $I->see("You don't have expenses yet in any group.");
    }


    public function UserHaveExpensesInGroupTest(AcceptanceTester $I)
    {

        $I->wantTo('Test if proper balance and overall is displayed');

        $I->amOnPage('/dashboard');
        $I->see("Overall you are owed 0");

        $this->createGroupWithUser('test group', 1, $I);

        $I->amOnPage('/dashboard');
        $I->see("You don't have expenses yet in any group.");

        $this->createExpense(100, 'test expense', 1, $I);

        $I->see('Overall you are owed 50');
        $I->see('test group Your balance: 50');

        $this->createExpense(30, 'test expense2', 1, $I);
        $I->see('Overall you are owed 65');
        $I->see('test group Your balance: 65');

    }

    public function UserHaveExpensesInManyGroupsTest(AcceptanceTester $I)
    {

        $I->wantTo('Test if proper balance and overall is displayed');

        $I->amOnPage('/dashboard');
        $I->see("Overall you are owed 0");

        $this->createGroupWithUser('test group', 1, $I);

        $I->amOnPage('/dashboard');
        $I->see("You don't have expenses yet in any group.");

        $this->createExpense(100, 'test expense', 1, $I);

        $I->see('Overall you are owed 50');
        $I->see('test group Your balance: 50');


        $this->createGroupWithUser('test group2', 2, $I);

        $this->createExpense(100, 'test expense2', 2, $I);
        $I->see('Overall you are owed 100');
        $I->see('test group Your balance: 50');
        $I->see('test group2 Your balance: 50');

    }


}
