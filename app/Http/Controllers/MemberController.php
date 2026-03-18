<?php

namespace App\Http\Controllers;

use App\Models\Member;

// Correct namespaces for Query Expressions
use Tpetry\QueryExpressions\Language\Alias;
use Tpetry\QueryExpressions\Function\Conditional\Coalesce;
use Tpetry\QueryExpressions\Function\Aggregate\CountFilter;
use Tpetry\QueryExpressions\Operator\Comparison\Equal;
use Tpetry\QueryExpressions\Value\Value;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::select(
            new Alias(
                new Coalesce([
                    'name',
                    new Value('Guest')
                ]),
                'display_name'
            )
        )->get();

        // If table is empty, manually add a default row
        if ($members->isEmpty()) {
            $members->push((object)['display_name' => 'Guest']);
        }

        return view('members.index', compact('members'));
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
