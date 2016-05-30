<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlogPostTagTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('blog_post_tag_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_tag_id')->unsigned()->index('tag_translations_tag_id_idx');
            $table->string('locale', 4);
            $table->string('title', 45);
            $table->string('slug', 45)->unique('slug_UNIQUE');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('blog_post_tag_translations');
    }
}
