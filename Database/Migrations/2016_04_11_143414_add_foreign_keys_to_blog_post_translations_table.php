<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToBlogPostTranslationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('blog_post_translations', function(Blueprint $table)
		{
			$table->foreign('post_id', 'post_translations_post_id')->references('id')->on('blog_posts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('blog_post_translations', function(Blueprint $table)
		{
			$table->dropForeign('post_translations_post_id');
		});
	}

}
