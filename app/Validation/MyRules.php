<?php

namespace App\Validation;

use App\Models\UserModel;

class MyRules
{

    public function userExists(string $str, string $fields, array $data)
    {
        $m = new UserModel();
        $d = $m->userExists($data['username']);
        if (!$d) {
            return true;
        }
        return false;
    }

    function username_check_blank($str)
    {

        $pattern = '/ /';
        $result = preg_match($pattern, $str);

        if ($result) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
}
