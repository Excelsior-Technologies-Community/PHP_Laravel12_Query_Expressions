<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;

class MembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing records (optional)
        Member::truncate();

        // Add admins
        Member::create([
            'name' => 'Alice Admin',
            'email' => 'alice.admin@example.com',
            'role' => 'admin',
        ]);

        Member::create([
            'name' => 'John Admin',
            'email' => 'john.admin@example.com',
            'role' => 'admin',
        ]);

        // Add normal users
        Member::create([
            'name' => 'Bob User',
            'email' => 'bob.user@example.com',
            'role' => 'user',
        ]);

        Member::create([
            'name' => 'Mary User',
            'email' => 'mary.user@example.com',
            'role' => 'user',
        ]);

        // Add a member with no name to test COALESCE
        Member::create([
            'name' => null,
            'email' => 'guest@example.com',
            'role' => 'user',
        ]);
    }
}