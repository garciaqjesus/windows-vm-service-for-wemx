<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('windowsvm_access')) {
            return;
        }

        if (!Schema::hasColumn('windowsvm_access', 'status')) {
            Schema::table('windowsvm_access', function (Blueprint $table) {
                $table->string('status')->default('pending')->after('order_id');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('windowsvm_access')) {
            return;
        }

        if (Schema::hasColumn('windowsvm_access', 'status')) {
            Schema::table('windowsvm_access', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
