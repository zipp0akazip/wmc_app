<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaseTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alias');
            $table->timestampsTz();
        });

        Schema::create('styles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alias');
            $table->timestampsTz();
        });

        Schema::create('labels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alias');
            $table->timestampsTz();
        });

        Schema::create('releases', function (Blueprint $table) {
            $table->id();
            $table->enum('type', \App\Models\Enums\ReleaseTypeEnum::asArray());
            $table->string('name');
            $table->string('alias');
            $table->timestamp('release_date');
            $table->timestampsTz();
        });

        Schema::create('tracks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('alias');
            $table->unsignedSmallInteger('duration');
            $table->timestamp('release_date');
            $table->timestampsTz();
        });

        Schema::create('track_has_artists', function (Blueprint $table) {
            $table->unsignedBigInteger('track_id');
            $table->unsignedInteger('artist_id');

            $table->foreign('track_id')
                ->references('id')
                ->on('tracks')
                ->onDelete('restrict');

            $table->foreign('artist_id')
                ->references('id')
                ->on('artists')
                ->onDelete('restrict');

            $table->primary(['track_id', 'artist_id'], 'track_has_artists_track_id_artist_id_primary');
        });

        Schema::create('track_has_styles', function (Blueprint $table) {
            $table->unsignedBigInteger('track_id');
            $table->unsignedInteger('style_id');

            $table->foreign('track_id')
                ->references('id')
                ->on('tracks')
                ->onDelete('restrict');

            $table->foreign('style_id')
                ->references('id')
                ->on('styles')
                ->onDelete('restrict');

            $table->primary(['track_id', 'style_id'], 'track_has_styles_track_id_style_id_primary');
        });

        Schema::create('track_has_labels', function (Blueprint $table) {
            $table->unsignedBigInteger('track_id');
            $table->unsignedInteger('label_id');

            $table->foreign('track_id')
                ->references('id')
                ->on('tracks')
                ->onDelete('restrict');

            $table->foreign('label_id')
                ->references('id')
                ->on('labels')
                ->onDelete('restrict');

            $table->primary(['track_id', 'label_id'], 'track_has_labels_track_id_label_id_primary');
        });

        Schema::create('track_has_releases', function (Blueprint $table) {
            $table->unsignedBigInteger('track_id');
            $table->unsignedInteger('release_id');

            $table->foreign('track_id')
                ->references('id')
                ->on('tracks')
                ->onDelete('restrict');

            $table->foreign('release_id')
                ->references('id')
                ->on('releases')
                ->onDelete('restrict');

            $table->primary(['track_id', 'release_id'], 'track_has_releases_track_id_release_id_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('track_has_releases');

        Schema::dropIfExists('track_has_labels');

        Schema::dropIfExists('track_has_styles');

        Schema::dropIfExists('track_has_artists');

        Schema::dropIfExists('tracks');

        Schema::dropIfExists('artists');

        Schema::dropIfExists('styles');

        Schema::dropIfExists('labels');

        Schema::dropIfExists('releases');
    }
}
