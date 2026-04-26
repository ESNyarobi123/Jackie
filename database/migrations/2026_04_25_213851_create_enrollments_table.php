<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("enrollments", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->cascadeOnDelete();
            $table->foreignId("course_id")->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger("subscription_id")->nullable()->index();
            $table->string("status")->default("pending")->index();
            $table->timestamp("enrolled_at")->nullable();
            $table->timestamp("access_expires_at")->nullable()->index();
            $table->unsignedTinyInteger("progress_percentage")->default(0);
            $table->timestamp("completed_at")->nullable();
            $table->timestamps();

            $table->unique(["user_id", "course_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("enrollments");
    }
};
