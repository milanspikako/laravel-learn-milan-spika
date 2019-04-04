<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('page_id');
            $table->string('title');
            $table->text('description');
            $table->string('image');
            $table->longtext('content');
            $table->string('layout')->default('fullwidth')->comment('fullwidth, leftaside, rightaside');
            $table->integer('contact_form')->default(0);
            $table->integer('header')->default(1);
            $table->integer('aside')->default(1);
            $table->integer('footer')->default(0);
            $table->integer('active')->default(0);
            $table->integer('deleted')->default(0);
            $table->integer('deleted_by')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
