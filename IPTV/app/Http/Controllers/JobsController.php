<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\CatchUp;

class JobsController extends Controller
{
    // start record stream job
    public function RecordStream ($id) {
        $job = (new Catchup($id));
        dispatch($job);
        return 200;
    }
}
