<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('test', function () {
    dd(\Carbon\Carbon::now()->format('Y-m-d H:i:s'));
});
