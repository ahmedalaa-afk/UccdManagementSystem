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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('username');
            $table->string('image')->nullable();
            // Instructor Section
            $table->integer('course_id')->nullable();
            $table->foreignId('manager_id')->nullable()->constrained('users');
            $table->text('description')->nullable();
            // Student Section
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->enum('disability', ['yes', 'no'])->nullable();
            $table->string('national_id')->nullable();
            $table->string('university_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('university')->nullable();
            $table->string('faculty')->nullable();
            $table->string('department')->nullable();
            $table->string('specialization')->nullable();
            $table->enum('current_year', [1, 2, 3, 4])->default(1);
            $table->timestamp('expected_graduation_year')->nullable();
            $table->string('address')->nullable();
            $table->timestamp('birth_date')->nullable();
            $table->enum('is_enrolled', ['yes', 'no'])->default('no')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
