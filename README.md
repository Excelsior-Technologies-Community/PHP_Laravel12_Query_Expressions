# PHP_Laravel12_Query_Expressions

## Introduction

PHP_Laravel12_Query_Expressions is a Laravel 12 project demonstrating the use of Laravel Query Expressions (tpetry/laravel-query-expressions) to replace DB::raw() queries. This allows you to write database-independent, maintainable, and safer queries while leveraging modern Eloquent syntax.

The project focuses on common database operations such as conditional selection (COALESCE) and filtered aggregates (COUNT FILTER) without relying on raw SQL. This ensures queries remain compatible across different database systems and are easier to maintain.

---

## Project Overview

This project implements a simple Member Management System with the following features:

- Members Table: Stores member information (name, email, role).

- Dynamic Display Names: Uses COALESCE query expression to show a default name (Guest) if the name field is empty.

- Role Counts: Uses COUNT FILTER to count how many members are admin or user.

- Seeder Support: Pre-populates the table with sample admins, users, and a guest member for testing query expressions.

- Blade Views: Clean, responsive views built with Tailwind CSS to display member lists and role counts.

- Database-Independent Queries: All queries are written using query expressions, avoiding raw SQL.

---

## Prerequisites

- PHP >= 8.1

- Composer

- Node.js & NPM

- MySQL or any supported database

- Laravel 12

- Tailwind CSS (for frontend styling)

---

## Step 1: Create Laravel 12 Project

```bash
composer create-project laravel/laravel PHP_Laravel12_Query_Expressions "12.*"
cd PHP_Laravel12_Query_Expressions
```
---

## Step 2: Install Laravel Query Expressions Package

```bash
composer require tpetry/laravel-query-expressions
```

---

## Step 3: Configure Database

Edit .env file:

```.env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=query_expressions_db
DB_USERNAME=root
DB_PASSWORD=
```
Then Run Migration Command:

```bash
php artisan migrate
```
---

## Step 4: Define the Members Table & Model

Create model and migration:

```bash
php artisan make:model Member -m
```

## Migration Table

File: database/migrations/xxxx_create_members_table.php:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('role')->default('user'); // role column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
```

Run migrations:

```bash
php artisan migrate
```
---

## Model 

File: app/Models/Member.php

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    // Specify table (optional, Laravel infers 'members' automatically)
    protected $table = 'members';

    // Mass assignable fields
    protected $fillable = [
        'name',
        'email',
        'role',
    ];
}
```

---

## Step 5: Member Controller 

```bash
php artisan make:controller MemberController
```

This will create:

app/Http/Controllers/MemberController.php

```php
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
```
---

## Step 6: Web Routes 

File: routes/web.php

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;

Route::get('/members', [MemberController::class, 'index']);           
Route::get('/members/counts', [MemberController::class, 'countRoles']); 

Route::get('/', function () {
    return view('welcome');
});
```

---

## Step 7: Blade Views

### index.blade.php

File: resources/views/members/index.blade.php

```blade
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="max-w-4xl mx-auto p-6">
        <header class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 border-b pb-2">Members</h1>
        </header>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            @if($members->isEmpty())
                <p class="p-6 text-gray-500 text-center">No members found.</p>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($members as $member)
                        <li class="p-4 hover:bg-gray-50 flex justify-between items-center">
                            <span class="text-gray-800 font-medium">{{ $member->display_name }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</body>

</html>
```

### counts.blade.php

File: resources/views/members/counts.blade.php

```blade
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Role Counts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="max-w-2xl mx-auto p-6">
        <header class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 border-b pb-2">Member Role Counts</h1>
        </header>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <h2 class="text-xl font-semibold text-gray-600">Admins</h2>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $counts->admins ?? 0 }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <h2 class="text-xl font-semibold text-gray-600">Users</h2>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $counts->users ?? 0 }}</p>
            </div>
        </div>
    </div>
</body>

</html>
```

---

## Step 8: Create the seeder

Run this command in your project root:

```bash
php artisan make:seeder MembersTableSeeder
```
This will create a new file:

database/seeders/MembersTableSeeder.php

```php
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
```

Run the seeder

In terminal:

```bash
php artisan db:seed --class=MembersTableSeeder
```

This will insert all your test members.

---

## Step 9: Run the Application

```bash
php artisan serve
```

Visit: 

```bash
http://127.0.0.1:8000/members
```
You will see the users list with display_name handled via query expressions.

---

## Output

<img src="screenshots/Screenshot 2026-03-18 172027.png" width="1000">

<img src="screenshots/Screenshot 2026-03-18 172045.png" width="1000">

---

## Project Structure

```
PHP_Laravel12_Query_Expressions/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │       └── MemberController.php
│   ├── Models/
│       └── Member.php          
│
├── bootstrap/
│   └── app.php
│
├── config/
│   └── ...                 # Laravel default configuration files
│
├── database/
│   ├── migrations/
│   │   └── xxxx_create_members_table.php
│   └── seeders/
│       └── MembersTableSeeder.php
│
│
├── resources/
│   ├── views/
│       ├── members/
│           ├── index.blade.php
│           └── counts.blade.php
│
├── routes/
│   └── web.php
│
├── storage/
│   └── logs/
│
│
├── vendor/
│   └── ...                 # Composer dependencies
│
├── .env
├── composer.json
├── package.json
└── artisan
```

---

Your PHP_Laravel12_Query_Expressions Project is now ready!

