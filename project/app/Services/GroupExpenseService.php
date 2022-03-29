<?php

namespace App\Services;

use App\Http\Requests\StoreExpenseRequest;
use App\Models\ExpensesHistory;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupExpenseService {

    function insertExpenseRelation(ExpensesHistory $expense_history, array $users)
    {
        foreach ($users as $user) {

            DB::table('expenses_user')->insert([
                'user_id' => $user,
                'expenses_history_id' => $expense_history->id,
                'user_contribution' => round($expense_history->amount / count($users), 2),
            ]);
        }
    }

    function checkUserChange($previous_users, $selected_users): bool
    {
        $previous_users_ids = [];

        foreach ($previous_users as $user) {
            $previous_users_ids[] = $user->id;
        }

        $new_users_ids = array_map('intval', $selected_users);

        return !(sizeof($previous_users_ids) == sizeof($new_users_ids)) ||
               !((sizeof(array_diff($previous_users_ids, $new_users_ids)) == 0));

    }


}
