<?php

namespace App\Services;

use App\Http\Requests\GroupRequest;
use App\Models\ExpensesHistory;
use App\Models\Payment;

class GroupService {

    function getImage(GroupRequest $request): string
    {
        $fileExtension = $request->file('avatar')->getClientOriginalExtension();
        $fileNameToStore = time() . '.' . $fileExtension;
        $request->avatar->move(storage_path('app/public/group_avatars/'), $fileNameToStore);

        return 'storage/group_avatars/' . $fileNameToStore;

    }

    function mergeArrays( $expenses_history, $payments): array
    {
        $merged = array_merge($expenses_history->all(), $payments->all());

        usort($merged, function ($a, $b) {
            $tmp1 = strtotime($a['created_at']);
            $tmp2 = strtotime($b['created_at']);
            return $tmp2 - $tmp1;
        });

        return $merged;

    }
}
