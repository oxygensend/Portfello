<?php

class HistoryTestCest
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
        $I->click('Accept');

        $I->amOnPage('/logout');
        $I->seeCurrentUrlEquals('/');
        $I->click('Log in');
        $I->fillField('email', 'test@test.com');
        $I->fillField('password', 'test123');
        $I->click('Log in');




    }


    public function basicCheck(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('History');
        $I->click('History');

        $I->seeCurrentUrlEquals('/history');

        $I->see('Your history');
        $I->see('No expenses have been created yet');
    }


    public function checkYourExpenseHistory(AcceptanceTester $I){
        $I->wantTo('See some expenses in my history');

        $amount = 10;
        $this->createCashExpense($amount,$I);


        $I->amOnPage('/history');
        $group_name=$I->grabFromDatabase('groups','name',
            ['id'=>1]);

        $I->see(" You added expense in $group_name");


        $expense_title=$I->grabFromDatabase('expenses_histories','title',['id'=> '1']);
        $I->see($expense_title);
        $I->see("You paid $amount");

        $amount=$amount/2;
        $I->see("You get back $amount");

        $amount_2 = 2;
        $this->createItemExpense('Pizza', $amount_2, $I);

        $I->amOnPage('/history');
        $I->see("You bought $amount_2 Pizza");
        $I->see("You get back $amount_2 Pizza");

    }

    public function checkYourPaymentHistory(AcceptanceTester $I){
        $I->wantTo('See some my payments in history');


    }

    private function createCashExpense($how_much, AcceptanceTester $I){

        $I->amOnPage("/groups/1/expenses/create");
        $I->see("How");
        $I->see("How much");
        $I->seeInDatabase('users', ['name' => 'test2']);
        $I->click('Select users');
        $I->checkOption('all');
        $I->click('#user_confirm');
        $I->fillField('description', 'Test expense');
        $I->selectOption('form select[name=how]', 'money');
        $I->fillField('how_much', $how_much);
        $I->click('#button_select_confirm');

    }
    private function createItemExpense($item, $how_much, AcceptanceTester $I){
        // sa problemy z item wiec sztucznie wrzuce do bazy
        $expense_id=1;
        $I->haveInDatabase('expenses', array('user_id' => '1', 'group_id' => '1'));
        $I->haveInDatabase('expenses_histories', array('expense_id' => $expense_id, 'action' => '1', 'amount'=>$how_much,'item'=>$item
        ,'title'=>'Expense with item', 'isLatest'=>1));
        $I->haveInDatabase('expenses_user', array('expenses_history_id' => 2, 'user_id' => '2', 'user_contribution'=>$how_much));
    }
}
