<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToBlogPostTagTranslationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('blog_post_tag_translations', function(Blueprint $table)
		{
			$table->foreign('post_tag_id', 'tag_translations_tag_id')->references('id')->on('blog_post_tags')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('blog_post_tag_translations', function(Blueprint $table)
		{
			$table->dropForeign('tag_translations_tag_id');
		});
	}

}
