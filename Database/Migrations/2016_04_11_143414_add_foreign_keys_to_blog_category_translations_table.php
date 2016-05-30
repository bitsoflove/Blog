<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToBlogCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('blog_category_translations', function (Blueprint $table) {
            $table->foreign('category_id', 'bct_category_id')->references('id')->on('blog_categories')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('blog_category_translations', function (Blueprint $table) {
            $table->dropForeign('bct_category_id');
        });
    }
}
