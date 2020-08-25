<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CmsFaq extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'cms_faq';

	protected $fillable = [
		'id',
		'page_name',
		'content_question',
		'content_answer',
		'created_at',
		'updated_at',
	];

	static $page_name = [
		'home',
		'ceder-ma-ferme',
		'confier-mes-terres',
		'louer-ou-vendre-mes-terres',
		'trouver-un-emploi',
	];
}
