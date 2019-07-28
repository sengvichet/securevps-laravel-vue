<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoggedSessions extends Model
{
    public $incrementing = false;

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
        if ($this->find(\Session::getId())) {
            return $this->find(\Session::getId());
        } else {
            return false;
        }
    }
}
