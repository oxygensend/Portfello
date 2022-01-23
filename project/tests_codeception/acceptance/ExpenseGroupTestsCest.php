<?php


class ExpenseGroupTestsCest {

    public function _before(\AcceptanceTester $I)
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
        $I->amOnPage('/groups/1');

        $I->amOnPage('/groups/1/edit');
        $I->click('Add user');
        $I->fillField('username', 'test2');
        $I->click('#add');

        $I->amOnPage('/logout');
        $I->amOnPage('/login');
        $I->fillField('email', 'test2@test.com');
        $I->fillField('password', 'test123');
        $I->click('Log in');
        $I->amOnPage('/edit-user');
        $I->see('Do you want to join the test group group?');
        $I->click('#accept');

        $I->amOnPage('/logout');
        $I->seeCurrentUrlEquals('/');
        $I->click('Log in');
        $I->fillField('email', 'test@test.com');
        $I->fillField('password', 'test123');
        $I->click('Log in');

        $this->user = $I->grabFromDatabase('users','name', ['id'=>1]);
        $this->created_at = $I->grabFromDatabase('expenses','created_at',['id'=>1]);
        $I->amOnPage("/groups/1/expenses/create");
        $I->see("How");
        $I->see("How much");
        $I->seeInDatabase('users', ['name' => 'test2']);
        $I->click('Select users');
        $I->checkOption('all');
        $I->click('#user_confirm');
        $I->fillField('description', 'Test expense');
        $I->selectOption('form select[name=how]', 'money');
        $I->fillField('how_much', 10);
        $I->click('#button_select_confirm');

    }


    public  function ShowViewExpenseTest(AcceptanceTester $I){

        $I->wantTo("Test if show view is displayed properly");
        $I->amOnPage('/groups/1');
        $I->see("Test Expense");
        $I->click('#expense1');
        $I->amOnPage('/groups/1/expenses/1');
        $I->see('10');
        $I->see('Created by ' . $this->user );
        $I->see('Added on '. $this->created_at);
        $I->see('In group test group');
        $I->see($this->user . ' owes 5');
        $I->see('test2  owes 5');
        $I->seeLink('Edit');
        $I->see('Delete','button');
    }

    public function DeleteExpenseTest(AcceptanceTester $I){

        $I->wantTo('Test if expense is deleted properly');
        $I->amOnPage('/groups/1/expenses/1');
        $I->click('Delete');
        $I->seeCurrentUrlEquals('/groups/1');
        $I->see('You deleted expense');
        $I->see('Test expense');
        $I->seeInDatabase('expenses_histories',[
            'expense_id'=>1,
            'item'=>null,
            'amount'=>10,
            'isLatest'=>1,
            'action'=>3,
            'title'=>'Test expense'
        ]);



    }

    public function EditViewTest(AcceptanceTester $I){

        $I->wantTo('Test if edit view is displayed properly');

        $I->amOnPage('/groups/1/expenses/1');
        $I->click('Edit');
        $I->see('Description');
        $I->see('How');
        $I->see('How much');
        $I->see("Select users");
        $I->see('Confirm', 'button');


    }

    public function EditExpenseTest(AcceptanceTester $I){

        $I->wantTo('Test if editing expense works');

        $I->amOnPage('/groups/1/expenses/1/edit');
        $I->fillField('Description', 'New test expense');
        $I->fillField('how_much', 20);
        $I->click('Confirm');
        $I->seeCurrentUrlEquals('/groups/1');

        $I->see(''.$this->created_at);
        $I->see('You edited expense');
//        $I->see('New test expense You paid 20 You get back 10');
        $I->seeInDatabase('expenses_histories',[
            'expense_id'=>1,
            'item'=>null,
            'amount'=>20,
            'isLatest'=>1,
            'action'=>2,
            'title'=>'New test expense'
        ]);


    }


}
