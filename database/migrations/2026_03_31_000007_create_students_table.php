<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('registration_code', 20)->unique();
            $table->string('nik', 16);
            $table->string('no_kk', 16);
            $table->string('nisn', 10);
            $table->string('full_name');
            $table->string('nickname', 50)->nullable();
            $table->enum('gender', ['L', 'P']);
            $table->string('birth_place', 100);
            $table->date('birth_date');
            $table->string('religion', 50);
            $table->text('address');
            $table->string('rt', 5);
            $table->string('rw', 5);
            $table->string('mother_name');
            $table->string('father_name')->nullable();
            $table->string('parent_occupation', 100)->nullable();
            $table->string('parent_phone', 20);
            $table->string('previous_school')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('registration_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
