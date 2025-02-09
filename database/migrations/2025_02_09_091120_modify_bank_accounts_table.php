<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->dropColumn(['agency', 'account_number']);
            $table->string('wallet_code', 64)->unique()->after('balance');
        });

        DB::table('bank_accounts')->update([
            'wallet_code' => DB::raw('MD5(UUID())')
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->string('agency', 10)->after('user_id');
            $table->string('account_number', 20)->unique()->after('agency');
            $table->dropColumn('wallet_code');
        });
    }
};
