<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToBlogPostTagTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('blog_post_tag', function(Blueprint $table)
		{
			$table->foreign('post_id', 'post_tag_post_id')->references('id')->on('blog_posts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('tag_id', 'post_tag_tag_id')->references('id')->on('blog_post_tags')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('blog_post_tag', function(Blueprint $table)
		{
			$table->dropForeign('post_tag_post_id');
			$table->dropForeign('post_tag_tag_id');
		});
	}

}
