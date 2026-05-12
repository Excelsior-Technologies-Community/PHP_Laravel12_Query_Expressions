<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

use Tpetry\QueryExpressions\Language\Alias;
use Tpetry\QueryExpressions\Function\Conditional\Coalesce;
use Tpetry\QueryExpressions\Function\Aggregate\CountFilter;
use Tpetry\QueryExpressions\Operator\Comparison\Equal;
use Tpetry\QueryExpressions\Value\Value;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $members = Member::select(
            'id',
            'email',
            'role',
            new Alias(
                new Coalesce([
                    'name',
                    new Value('Guest')
                ]),
                'display_name'
            )
        )
        ->when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        })
        ->paginate(4);

        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:members',
            'role' => 'required'
        ]);

        Member::create($request->all());

        return redirect('/members')
            ->with('success', 'Member created successfully.');
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:members,email,' . $member->id,
            'role' => 'required'
        ]);

        $member->update($request->all());

        return redirect('/members')
            ->with('success', 'Member updated successfully.');
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return redirect('/members')
            ->with('success', 'Member deleted successfully.');
    }

    public function countRoles()
    {
        $counts = Member::select([
            new Alias(
                new CountFilter(new Equal('role', new Value('admin'))),
                'admins'
            ),
            new Alias(
                new CountFilter(new Equal('role', new Value('user'))),
                'users'
            ),
        ])->first();

        return view('members.counts', compact('counts'));
    }
}