<?php

namespace App\Http\Controllers;

use App\Models\Voter;
use App\Models\Resource;
use Illuminate\Http\Request;

class VoteController extends Controller
{

    public function __invoke(Request $request, Resource $resource)
    {
        $voter = Voter::where('code', $request->code)->FirstOrFail();

        $voter = votes(syncWithoutDetaching($resource));

        return redirect()->back();

    }

}

