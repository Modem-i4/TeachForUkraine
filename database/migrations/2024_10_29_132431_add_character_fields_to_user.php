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
        Schema::table('users', function (Blueprint $table) {
            $table->json('tasks')->nullable();
            $table->string('charName', 100)->nullable();
            $table->json('character')->nullable();
            $table->json('rewards')->nullable();
            $table->json('skills')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('tasks');
            $table->dropColumn('charName');
            $table->dropColumn('character');
            $table->dropColumn('rewards');
            $table->dropColumn('skills');
        });
    }
};
