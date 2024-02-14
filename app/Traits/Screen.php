<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait Screen
{
    public array $nameArr = [
        'admin' => 'admin',
    ];

    public function getArrIdScreens(): array
    {
        $result = [];
        $screens = DB::table('screens')->get()->toArray();
        foreach ($screens as $screen) {
            switch ($screen->name) {
                case $this->nameArr['admin']:
                    $result[$this->nameArr['admin']] = $screen->id;
                    break;
            }
        }
        return $result;
    }
}
