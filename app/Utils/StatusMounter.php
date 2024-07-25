<?php

namespace App\Utils;

use App\Models\Setting\Status;

class StatusMounter
{
    public static function ORDER_PROCESS()
    {
        return Status::whereBetween('code_status', [ '01', '05' ])->get();
    }
    public static function EQUIPMENT()
    {
        return Status::whereBetween('code_status', [ '06', '10' ])->get();
    }
    public static function OTHER()
    {
        return Status::whereBetween('code_status', [ '11', '20' ])->get();
    }
}
