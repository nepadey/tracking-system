<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('locations', function (Blueprint $table) {
      $table->id();
      $table->ipAddress('ipaddress');
      $table->double('lat')->nullable();
      $table->double('lng')->nullable();
      $table->foreignId('device_id')->constrained('devices');
      $table->timestamps();
      $table->index('created_at');
      $table->index('device_id');
      $table->index(['device_id', "created_at"]);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('locations');
  }
}
