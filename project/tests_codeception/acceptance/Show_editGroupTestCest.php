<?php



class Show_editGroupTestCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/groups');
        $I->seeCurrentUrlEquals('/login');
        $I->fillField('email', 'test@test.com');
        $I->fillField('password', 'test123');
        $I->click('Log in');
        $group_slug=$I->grabFromDatabase('groups','slug',['id'=>1]);
        $I->amOnPage("/groups/$group_slug");

    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        $group_name=$I->grabFromDatabase('groups','name',['id'=>1]);
        $name = $I->grabFromDatabase('users','name',['id'=>1]);
        $I->see($group_name);
        $expense_id=$I->grabFromDatabase('expenses','id',['user_id'=>1]);
        $title=$I->grabFromDatabase('expenses_histories','title',['expense_id'=>$expense_id]);
        $I->see($title);

        $I->see("$name added expense");

        $group_slug=$I->grabFromDatabase('groups','slug',['id'=>1]);
        $I->amOnPage("/groups/$group_slug/edit");

        $I->see("Change name");
        $I->see("Change avatar");
        $I->see("Start using smart billing");
        $I->see("Add user");

        $I->see("Update");
        $I->see("Delete");

        $I->see($group_name);
        $I->seeInField('name',$group_name);

        $I->seeInDatabase('groups',['name'=>$group_name]);
        /*
                $new_group_name = "Mieszkanie";
                $I->fillField('name',$new_group_name);
                $I->click("Update");


                $I->dontSeeCurrentUrlEquals("/groups/$group_slug/edit");


                $I->dontSeeInDatabase('groups', ['name' => $group_name,
                    ]);

                $new_group_slug=$I->grabFromDatabase('groups','slug',['name' => $new_group_name,]);

                $I->SeeCurrentUrlEquals("/groups/$new_group_slug");*/
        // idk, wykonuje sie metoda delete zamiast update bo codeception nie wie ze gdzie sie form konczy...

        $I->click('Delete');
        $I->dontSeeInDatabase('groups', ['name' => $group_name,
        ]);

        $I->seeCurrentUrlEquals("/groups");

        $I->dontSee($group_name);
    }
}
