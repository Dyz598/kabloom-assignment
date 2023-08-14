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
        Schema::create('profile_followers', function (Blueprint $table) {
            $table->uuid('profile_id')
                ->index();
            $table->uuid('user_id')
                ->index();
            $table->boolean('followed')
                ->default(true);
            $table->boolean('subscription_paid')
                ->default(false);
            $table->string('payment_id', 50)
                ->unique()
                ->nullable()
                ->index();
            $table->timestamps();

            $table->primary(['profile_id', 'user_id']);

            $table->foreign('profile_id')
                ->references('id')
                ->on('profiles')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_followers');
    }
};
