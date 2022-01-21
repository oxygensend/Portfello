<?php

class EditUserTestCest
{
    public function _before(AcceptanceTester $I)
    {
        //log in
        $I->amOnPage('/edit-user');
        $I->seeCurrentUrlEquals('/login');
        $I->fillField('email', 'test@test.com');
        $I->fillField('password', 'test123');
        $I->click('Log in');
    }

    // tests
    public function ChangeUsernameTest(AcceptanceTester $I)
    {
        $name = $I->grabFromDatabase('users', 'name', [
            'id' => '1'
        ]);

        $I->wantTo('Test username changing');

        $I->amOnPage('/edit-user');
        $I->see($name);
        $I->click('Change Username');
        $I->see('The name has already been taken.');
        $I->fillField('name','');
        $I->click('Change Username');
        $I->see('The name field is required.');
        $I->fillField('name','test_username');
        $I->click('Change Username');
        $I->see('Username changed successfully!');

        $I->see('test_username');



    }

    public function ChangeEmailTest(AcceptanceTester $I)
    {
        $email = $I->grabFromDatabase('users', 'email', [
            'id' => '1'
        ]);

        $I->wantTo('Test email changing');

        $I->amOnPage('/edit-user');
        $I->see($email);
        $I->click('Change Email');
        $I->see('The email field is required.');
        $I->see('The repeated new email field is required.');
        $I->fillField('email','wrong_email');
        $I->click('Change Email');
        $I->see('The email must be a valid email address.');
        $I->fillField('email',$email);
        $I->fillField('repeated_new_email',$email);
        $I->click('Change Email');
        $I->see('The email has already been taken.');
        $I->fillField('email','email@email.com');
        $I->fillField('repeated_new_email','wrong_email@email.com');
        $I->click('Change Email');
        $I->see('The email and repeated new email must match.');
        $I->fillField('email','email@email.com');
        $I->fillField('repeated_new_email','email@email.com');
        $I->click('Change Email');
        $I->see('Email changed successfully!');
        $I->see('email@email');

    }

    public function ChangePasswordTest(AcceptanceTester $I)
    {

        $I->wantTo('Test password changing');

        $I->amOnPage('/edit-user');
        $I->click('Change Password');
        $I->see('The current password field is required.');
        $I->see('The new password field is required.');
        $I->see('The repeated new password field is required.');
        $I->fillField('new_password','pass1');
        $I->fillField('repeated_new_password','pass2');
        $I->click('Change Password');
        $I->see('The new password and repeated new password must match.');
        $I->fillField('new_password','pass1');
        $I->fillField('repeated_new_password','pass1');
        $I->click('Change Password');
        $I->see('The new password must be at least 7 characters.');
        $I->fillField('current_password','wrong_password');
        $I->fillField('new_password','password');
        $I->fillField('repeated_new_password','password');
        $I->click('Change Password');
        $I->see('Wrong current password.');
        $I->fillField('current_password','test123');
        $I->fillField('new_password','password');
        $I->fillField('repeated_new_password','password');
        $I->click('Change Password');
        $I->see('Password changed successfully!');
        $I->click('Log out');
        $I->click('Log in');
        $I->fillField('email','test@test.com');
        $I->fillField('password','password');
        $I->amOnPage('/dashboard');
    }



}
