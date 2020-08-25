<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CmsFaq extends Model
{
	protected $fillable = [
		'id',
		'page_name',
		'content_question',
		'content_answer',
		'created_at',
		'updated_at',
	];
}
