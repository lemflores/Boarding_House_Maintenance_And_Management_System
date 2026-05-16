<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('tenant_id')->constrained()->nullOnDelete();
        });

        Schema::table('maintenance_reports', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
        });

        $firstUserId = DB::table('users')->value('id');
        if ($firstUserId) {
            DB::table('tenants')->whereNull('user_id')->update(['user_id' => $firstUserId]);
            DB::table('payments')->whereNull('user_id')->update(['user_id' => $firstUserId]);
            DB::table('maintenance_reports')->whereNull('user_id')->update(['user_id' => $firstUserId]);
        }
    }

    public function down(): void
    {
        Schema::table('maintenance_reports', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });

        Schema::table('tenants', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
