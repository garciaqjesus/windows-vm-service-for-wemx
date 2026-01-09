<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('windowsvm_access', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->unique();

            // Provisioning status shown to customer.
            $table->string('status')->default('pending');

            $table->string('public_ip')->nullable();
            $table->unsignedInteger('rdp_port')->default(3389);
            $table->string('username')->nullable();
            $table->text('password_encrypted')->nullable();

            $table->text('notes')->nullable();
            $table->timestamp('ready_at')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('windowsvm_access');
    }
};
