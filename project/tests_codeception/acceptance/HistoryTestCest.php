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

        //creating group
        $I->amOnPage('/groups/create');
        $I->fillField('name', 'test group');
        $I->click('Create');
        $I->haveInDatabase('group_user', ['user_id' => 2, 'group_id' => 1]);




    }


    public function basicCheck(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('History');
        $I->click('History');

        $I->seeCurrentUrlEquals('/history');

        $I->see('Your history');
        $I->see('No expenses or payments been created yet');
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
