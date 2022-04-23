<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('devices', function (Blueprint $table) {
      $table->id();
      $table->uuid('device_token');
      $table->foreignId('user_id')->constrained('users');
      $table->char('name', 100);
      $table->boolean('enabled')->default(false);
      $table->timestamps();
      $table->index('user_id');
      $table->index('enabled');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('devices');
  }
}
