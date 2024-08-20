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
    Schema::create('roles', function (Blueprint $table) {
      $table->id(); // Creates an auto-incrementing primary key column named 'id'
      $table->string('name')->unique(); // Creates a 'name' column with a unique constraint
      $table->timestamps(); // Creates 'created_at' and 'updated_at' timestamp columns
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('roles'); // Drops the 'roles' table if it exists
  }
};
