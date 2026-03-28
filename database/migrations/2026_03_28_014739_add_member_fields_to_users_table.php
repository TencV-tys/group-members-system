<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Check if member_id column doesn't exist, then add it
        if (!Schema::hasColumn('users', 'member_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('member_id')->nullable()->constrained()->onDelete('cascade');
            });
        }

        // Check if username column exists, if not, add it
        if (!Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('username')->nullable()->after('name');
            });
        }

        // Update existing users with a default username if they don't have one
        $users = DB::table('users')->whereNull('username')->get();
        foreach ($users as $user) {
            $username = $user->email ? explode('@', $user->email)[0] : 'user' . $user->id;
            // Make sure username is unique
            $originalUsername = $username;
            $counter = 1;
            while (DB::table('users')->where('username', $username)->where('id', '!=', $user->id)->exists()) {
                $username = $originalUsername . $counter;
                $counter++;
            }
            DB::table('users')->where('id', $user->id)->update(['username' => $username]);
        }

        // Make username unique if it's not already
        $indexExists = false;
        $indexes = DB::select('SHOW INDEX FROM users WHERE Key_name = "users_username_unique"');
        if (empty($indexes)) {
            Schema::table('users', function (Blueprint $table) {
                $table->unique('username');
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'member_id')) {
                $table->dropForeign(['member_id']);
                $table->dropColumn('member_id');
            }
            if (Schema::hasColumn('users', 'username')) {
                $table->dropColumn('username');
            }
        });
    }
};