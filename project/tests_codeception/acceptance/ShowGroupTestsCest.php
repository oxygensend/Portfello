<?php

class ShowGroupTestsCest {

    public function _before(AcceptanceTester $I)
    {
        // log in
        $I->amOnPage('/groups');
        $I->seeCurrentUrlEquals('/login');
        $I->fillField('email', 'test@test.com');
        $I->fillField('password', 'test123');
        $I->click('Log in');


        // create group
        $I->amOnPage('/groups');
        $I->click('Create');
        $I->fillField('name', 'test group');
        $I->click('Create');
        $I->see('test group');
        $I->click('test group');
        $I->amOnPage('/groups/test-group');


        $this->group_id = $I->grabFromDatabase('groups', 'id', [
            'name' => 'test group'
        ]);

        $this->test2_id = $I->grabFromDatabase('users', 'id', [
            'name' => 'test2'
        ]);
    }

    // tests
    public function AddingNonExistingUserTest(AcceptanceTester $I)
    {

        $I->wantTo('Test validation errors while adding new user to group when user doesnt exists');
        $I->see('Add user');
        $I->click('Add user');
        $I->fillField('username', '');
        $I->click('#add');
        $I->seeCurrentUrlEquals('/groups/test-group');
        $I->see('The username field is required.');
    }

    public function AddingExistingUserTest(AcceptanceTester $I)
    {

        $I->wantTo('Test if user is  added properly to group');

        $I->amOnPage('/groups/test-group');
        $I->click('Add user');
        $I->fillField('username', 'test2');
        $I->click('#add');
        $I->seeCurrentUrlEquals('/groups/test-group');
        $I->see('Request has been sent to test2');
        $I->seeInDatabase('group_user', ['user_id' => $this->test2_id, 'group_id' => $this->group_id]);
    }
    public function AddingUserWhoseAlreadyInGroupTest(AcceptanceTester $I)
    {

        $I->wantTo('Test if user can add user whose is already in group');

        $I->amOnPage('/groups/test-group');
        $I->click('Add user');
        $I->fillField('username', 'test2');
        $I->click('#add');
        $I->seeInDatabase('group_user', ['user_id' => $this->test2_id, 'group_id' => $this->group_id]);

        $I->click('Add user');
        $I->fillField('username', 'test2');
        $I->click('#add');
        $I->see('User test2 is already in group');
    }
    //TODO only admin can see add user Delete and edit buttons
    //TODO dalsze testy dla widoku groups

}
