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
        $I->haveInDatabase('group_user', ['user_id' => 2, 'group_id' => 1]);

        $I->amOnPage("/groups/1");
        $I->see("Add  expense");
        $I->click("Add expense");
    }

    // tests
    public function TryingToAddNewExpenses(AcceptanceTester $I)
    {
        $I->wantTo('Test adding new expense with money');
        $I->seeCurrentUrlEquals("/groups/1/expenses/create");
        $I->see("How");
        $I->see("How much");
        $I->seeInDatabase('users', ['name'=>'test2']);
        $I->click('Select users');
        $I->checkOption('all');
        $I->click('#user_confirm');
        $I->fillField('description', 'Test expense');
        $I->selectOption('form select[name=how]','money');
        $I->fillField('how_much', 10);
        $I->click('#button_select_confirm');
        $I->seeCurrentUrlEquals('/groups/1');
        $I->see('You added expense in test group');
        $I->see('You paid 10 $ You get back 5 $');
        $I->see('Your balance: 5 $');
        $I->seeInDatabase('expenses',['user_id'=> '1', 'group_id' => '1']);
        $I->seeInDatabase('expenses_histories',[
            'expense_id'=>1,
            'item'=>null,
            'amount'=>10,
            'isLatest'=>1,
            'action'=>1,
            'title'=>'Test expense'
        ]);

        $I->seeInDatabase('expenses_user',[
            'user_id' => 1,
            'user_contribution'=>5
        ]);

        $I->seeInDatabase('expenses_user',[
            'user_id' => 2,
            'user_contribution'=>5
        ]);

    }

    public function TryingToAddNewExpensesItem(AcceptanceTester $I)
    {
        $I->wantTo('Test adding new expense with item');
        $I->seeCurrentUrlEquals("/groups/1/expenses/create");
        $I->see("How");
        $I->see("How much");
        $I->click('Select users');
        $I->checkOption('all');
        $I->click('#user_confirm');
        $I->fillField('description', 'Test expense');
        $I->selectOption('form select[name=how]','item');
        $I->fillField('#item', 'piwo');
        $I->fillField('how_much', 4);
        $I->click('#button_select_confirm');
        $I->seeCurrentUrlEquals('/groups/1');
        $I->see('You added expense in test group');
        $I->see('You bought 4 piwo You get back 2 piwo ');
        $I->seeInDatabase('expenses',['user_id'=> '1', 'group_id' => '1']);
        $I->seeInDatabase('expenses_histories',[
            'expense_id'=>1,
            'item'=>'piwo',
            'amount'=>4,
            'isLatest'=>1,
            'action'=>1,
            'title'=>'Test expense'
        ]);

        $I->seeInDatabase('expenses_user',[
            'user_id' => 1,
            'user_contribution'=>2
        ]);

        $I->seeInDatabase('expenses_user',[
            'user_id' => 2,
            'user_contribution'=>2
        ]);

    }
public function ExpenseValidationTest(AcceptanceTester $I)
    {
        $I->wantTo('Test validation');
        $I->seeCurrentUrlEquals("/groups/1/expenses/create");
        $I->see("How");
        $I->see("How much");
        $I->click('Select users');
        $I->uncheckOption('all');
        $I->click('#user_confirm');
        $I->fillField('description', 'Test expense');
        $I->selectOption('form select[name=how]','item');
        $I->fillField('#item', 'piwo');
        $I->fillField('how_much','' );
        $I->click('#button_select_confirm');
        $I->seeCurrentUrlEquals("/groups/1/expenses/create");
        $I->see('How much field is required');
        $I->selectOption('form select[name=how]','money');
        $I->fillField('how_much','' );
        $I->click('#button_select_confirm');
        $I->seeCurrentUrlEquals("/groups/1/expenses/create");
        $I->see('How much field is required');
        $I->fillField('how_much','test' );
        $I->click('#button_select_confirm');
        $I->see('The How much must be a number');
        $I->fillField('how_much', -1 );
        $I->click('#button_select_confirm');
        $I->see('How much must be at least 0.');
    }

}
