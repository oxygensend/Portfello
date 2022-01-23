<?php

class AddingUserTestCest {

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
        $I->amOnPage('/groups/1');


        $this->group_id = $I->grabFromDatabase('groups', 'id', [
            'name' => 'test group'
        ]);

        $this->test2_id = $I->grabFromDatabase('users', 'id', [
            'name' => 'test2'
        ]);
    }

    // tests
    public function SendInviteToNonExistingUserTest(AcceptanceTester $I)
    {

        $I->wantTo('Test validation errors while adding new user to group when user doesnt exists');
        $I->amOnPage('/groups/1/edit');
        $I->see('Add user');
        $I->click('Add user');
        $I->fillField('username', '');
        $I->click('#add');
        $I->seeCurrentUrlEquals('/groups/1/edit');
        $I->see('The username field is required.');
    }

    public function AddingExistingUserTest(AcceptanceTester $I)
    {

        $I->wantTo('Test if user is  added properly to group');

        $I->amOnPage('/groups/1/edit');
        $I->click('Add user');
        $I->fillField('username', 'test2');
        $I->click('#add');
        $I->seeCurrentUrlEquals('/groups/1/edit');
        $I->see('Request has been sent to test2');
        $I->seeInDatabase('invites', ['user_id' => $this->test2_id, 'group_id' => $this->group_id]);

        $I->amOnPage('/logout');
        $I->amOnPage('/login');
        $I->fillField('email', 'test2@test.com');
        $I->fillField('password', 'test123');
        $I->click('Log in');
        $I->see('1');
        $I->amOnPage('/edit-user');
        $I->see('Do you want to join the test group group?');
        $I->see('Accept');
        $I->see('Discard');
        $I->amOnPage('/dashboard');
        $I->dontSee('1');

    }
    public function UserConfrimInvitationTest(AcceptanceTester $I){
        $I->wantTo('Test if user can confirm invite properly');

        $I->amOnPage('/groups/1/edit');
        $I->click('Add user');
        $I->fillField('username', 'test2');
        $I->click('#add');
        $I->seeCurrentUrlEquals('/groups/1/edit');
        $I->see('Request has been sent to test2');
        $I->seeInDatabase('invites', ['user_id' => $this->test2_id, 'group_id' => $this->group_id]);

        $I->amOnPage('/logout');
        $I->amOnPage('/login');
        $I->fillField('email', 'test2@test.com');
        $I->fillField('password', 'test123');
        $I->click('Log in');
        $I->see('1');
        $I->amOnPage('/edit-user');
        $I->see('Do you want to join the test group group?');
        $I->click('Accept');
        $I->seeInDatabase('group_user', ['user_id' => $this->test2_id, 'group_id' => $this->group_id]);
    }
    public function UserDiscardInvitationTest(AcceptanceTester $I){
        $I->wantTo('Test if user can discard invite properly');

        $I->amOnPage('/groups/1/edit');
        $I->click('Add user');
        $I->fillField('username', 'test2');
        $I->click('#add');
        $I->seeCurrentUrlEquals('/groups/1/edit');
        $I->see('Request has been sent to test2');
        $I->seeInDatabase('invites', ['user_id' => $this->test2_id, 'group_id' => $this->group_id]);

        $I->amOnPage('/logout');
        $I->amOnPage('/login');
        $I->fillField('email', 'test2@test.com');
        $I->fillField('password', 'test123');
        $I->click('Log in');
        $I->see('1');
        $I->amOnPage('/edit-user');
        $I->see('Do you want to join the test group group?');
        $I->click('Discard');
        $I->dontSeeInDatabase('group_user', ['user_id' => $this->test2_id, 'group_id' => $this->group_id]);
        $I->dontSeeInDatabase('invites', ['user_id' => $this->test2_id, 'group_id' => $this->group_id]);
    }
    public function AddingUserWhoseAlreadyInGroupTest(AcceptanceTester $I)
    {

        $I->wantTo('Test if user can add user whose is already in group');

        $I->amOnPage('/groups/1/edit');
        $I->click('Add user');
        $I->fillField('username', 'test2');
        $I->click('#add');
        $I->seeInDatabase('invites', ['user_id' => $this->test2_id, 'group_id' => $this->group_id]);

        $I->amOnPage('/groups/1/edit');
        $I->click('Add user');
        $I->fillField('username', 'test2');
        $I->click('#add');
        $I->see('Request has been already sent to this user');



    }



}
