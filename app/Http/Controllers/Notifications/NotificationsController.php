<?php

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationsController extends Controller
{
	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request)
	{
		$user = $request->user();
		return view('pages.notifications.index', compact('user'));
	}

	public function update(Request $request, DatabaseNotification $notification)
	{
		if ($request->user()->unreadNotifications->isEmpty()) {
			return back()->with('warning', 'La notification n\'existe plus');
		}
		if ($request->input('route') === 'ads.show') {
			$notification->markAsRead();
			$notification->delete();
			return redirect()->route($request->input('route'), $notification->data['ad_id']);
		} else {
			$notification->markAsRead();
			return redirect()->route($request->input('route'), ['citySelect=&radius_research=&ad_statuses[]=4&ad_title=']);
		}
	}
}
