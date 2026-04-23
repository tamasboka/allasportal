<?php

use App\Models\Category;
use App\Models\Job;
use App\Models\Organization;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            /*$table->foreignIdFor(Organization::class)->nullable()
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            */
            $table->string('name');
            $table->string('currency')->nullable();
            $table->integer('min_salary');
            $table->integer('max_salary');
            $table->string('location')->nullable();
            $table->boolean('has_home_office');
            $table->integer('capacity');
            $table->enum('type', ['one-time', 'part-time', 'full-time']);
            $table->string('description')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });

        Schema::create('job_user', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignIdFor(Job::class)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('user_saved_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignIdFor(Job::class)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
    }
};
