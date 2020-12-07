<?php

namespace App\Http\Controllers\Badges;

use App\Http\Controllers\Controller;
use App\Models\CommunityVolunteers\CommunityVolunteer;
use Inertia\Inertia;

class BadgeMaker2Controller extends Controller
{
    public function index()
    {
        // request()->session()->flash('message', 'test');

        return  Inertia::render('Test', [
            'volunteers' => CommunityVolunteer::query()
                ->workStatus('active')
                ->orderBy('first_name')
                ->get(),
        ]);
    }
}
