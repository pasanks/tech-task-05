<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\School;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:members',
            'school_id' => 'required|array|exists:schools,id',
        ]);

        $member = Member::create([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        $member->schools()->attach($data['school_id']);

        return redirect()->route('index')->with('success', 'Member added successfully');
    }
}
