<?php

namespace Airviro\SMA254Log;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMA254Log extends Model
{
    protected $table = 'SMA254LOG';
    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }
    public $incrementing = false;
    protected $casts = [
        'data' => 'json'
    ];
}
