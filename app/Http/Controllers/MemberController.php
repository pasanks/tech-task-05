<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberStoreRequest;
use App\Models\Member;
use App\Models\School;

class MemberController extends Controller
{
    /**
     * Add new member view.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        $schools = School::all();

        return view('pages.members.create', compact('schools'));
    }

    /**
     * Store new member.
     *
     * @param MemberStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MemberStoreRequest $request)
    {
        $member = Member::create($request->all());

        $member->schools()->attach($request->get('school_id'));

        return redirect()->route('index')->with('success', 'Member added successfully');
    }
}
