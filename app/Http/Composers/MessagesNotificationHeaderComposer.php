<?php

namespace App\Http\Composers;

use App\Services\Threads\ThreadService;
use Illuminate\View\View;

class MessagesNotificationHeaderComposer
{
    /**
     * @var ThreadService
     */
    protected $service;

    /**
     * ThreadsController constructor.
     */
    public function __construct(ThreadService $service)
    {
        $this->service = $service;

    }

    public function compose(View $view)
    {
        $numberOfUnreadMessages = 0;

        if (Auth()->user()) {
            $numberOfUnreadMessages = $this->service->countAllUnreadMessagesInThreadsByLoggedUser();
        }

        $view->with(compact('numberOfUnreadMessages'));
    }
}
