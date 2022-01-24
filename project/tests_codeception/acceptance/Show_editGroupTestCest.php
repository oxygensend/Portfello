<?php



class Show_editGroupTestCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/groups');
        $I->seeCurrentUrlEquals('/login');
        $I->fillField('email', 'test@test.com');
        $I->fillField('password', 'test123');

        //creating group
        $I->click('Log in');
        $I->amOnPage('/groups/create');
        $I->fillField('name', 'test group');
        $I->click('Create');
        $I->haveInDatabase('group_user', ['user_id' => 2, 'group_id' => 1]);


        // creating expense
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
        $I->amOnPage("/groups/1");

    }

    public function ShowGroupTest(AcceptanceTester $I){

        $I->see('test group');

        $I->see("You added expense in test group");
        $I->see('Test expense');
        $I->see('Add expense');

    }
    // tests
    public function EditGroupTest(AcceptanceTester $I)
    {
        $I->wantTo('Test if editing group data works');

        $I->amOnPage("/groups/1/edit");

        $I->see("Change name");
        $I->see("Change avatar");
        $I->see("Add user");

        $I->seeInDatabase('groups', ['id'=>1, 'name' => 'test group']);
        $name=$I->grabFromDatabase('users','name',['id'=>1]);
        $I->see('Name Avatar Action');
        $I->see('1 '. $name);
        $I->see('2 test2');

        $I->see("Update");
        $I->see("Delete");

        $I->seeInField('name','test group');

        $I->fillField('name', 'new test');
        $I->click('Update');
        $I->seeCurrentUrlEquals('/groups/1');
        $I->see('new test');
        $I->seeInDatabase('groups', ['id'=>1, 'name' => 'new test', ]);
    }

    public function EditGroupValidationTest(AcceptanceTester $I){


        $I->wantTo('Test if edit validation works');

        $I->amOnPage("/groups/1/edit");
        $I->fillField('name', ' ');
        $I->click('Update');
        $I->seeCurrentUrlEquals('/groups/1/edit');
        $I->see('The name field is required.');

        $I->amOnPage('/groups/create');
        $I->fillField('name', 'test group2');
        $I->click('Create');

        $I->amOnPage("/groups/1/edit");
        $I->fillField('name', 'test group2');
        $I->click('Update');

    }

    public function DeleteGroupTest(AcceptanceTester $I){

        $I->wantTo('Test if deleting groups works');
        $I->amOnPage('/groups/1/edit');
        $I->click('Delete');
        $I->seeCurrentUrlEquals('/groups');
        $I->see("You don't belong to any groups yet");
        $I->dontSeeInDatabase('groups', ['id'=>1,
            'name'=>'test group'
        ]);
        $I->dontSeeInDatabase('group_user',['user_id'=>1,'group_id'=>1]);

    }

    public function DeletingUserFromGroupTest(AcceptanceTester $I){

        $I->wantTo("Test if deleting user works properly");
        $I->amOnPage('/groups/1/edit');

        $name=$I->grabFromDatabase('users','name',['id'=>1]);
        $I->see('Name Avatar Action');
        $I->see('1 '. $name);
        $I->see('2 test2');
        $I->click('');
        $I->see('User has been deleted');
        $I->dontSeeInDatabase('group_user',['user_id'=>2,'group_id'=>1]);
    }

    public function OnlyAdminCanDeleteTest(AcceptanceTester $I){

        $I->wantTo('Test if only Admin see proper links');
        $I->amOnPage('/logout');
        $I->amOnPage('/login');
        $I->fillField('email','test2@test.com');
        $I->fillField('password', 'test123');
        $I->click('Log in');
        $I->amOnPage('/groups/1/edit');
        $I->dontSee('Delete');

    }
}
