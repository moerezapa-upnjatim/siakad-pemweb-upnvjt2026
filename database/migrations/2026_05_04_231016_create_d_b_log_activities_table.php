<?php

use App\Models\DBLogActivities;
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
        Schema::create(DBLogActivities::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(DBLogActivities::ACTION_COLUMN);
            $table->text(DBLogActivities::DESC_COLUMN);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(DBLogActivities::TABLE_NAME);
    }
};
