<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlogPostTagTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blog_post_tag', function(Blueprint $table)
		{
			$table->integer('tag_id')->unsigned();
			$table->integer('post_id')->unsigned()->index('post_tag_post_id_idx');
			$table->primary(['tag_id','post_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('blog_post_tag');
	}

}
