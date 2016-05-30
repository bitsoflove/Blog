<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlogPostTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('blog_post_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id')->unsigned()->index('post_translations_post_id_idx');
            $table->string('locale', 4);
            $table->string('title', 65);
            $table->string('slug', 65);
            $table->text('content', 65535);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('blog_post_translations');
    }
}
