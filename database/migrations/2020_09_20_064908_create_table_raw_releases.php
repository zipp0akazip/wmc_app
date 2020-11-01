<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRawReleases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raw_releases', function (Blueprint $table) {
            $table->id();
            $table->text('data');
            $table->enum('status', \App\Models\Enums\RawReleaseStatusEnum::asArray());
            $table->text('message')->nullable();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('raw_releases');
    }
}
