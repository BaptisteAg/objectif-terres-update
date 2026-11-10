<?php

namespace App\Http\Controllers\Threads;

use App\Exceptions\SpamContentException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ThreadRequest;
use App\Models\ResponseTemplate;
use App\Services\RecaptchaService;
use App\Services\Threads\ThreadService;
use App\Services\Users\UserService;
use Illuminate\Support\Collection;

/**
 * Class ThreadsController
 */
class ThreadsController extends Controller
{
    /**
     * @var ThreadService
     */
    protected $service;

    protected $userService;

    protected $recaptchaService;

    /**
     * ThreadsController constructor.
     */
    public function __construct(ThreadService $service, UserService $userService, RecaptchaService $recaptchaService)
    {
        $this->service = $service;
        $this->userService = $userService;
        $this->recaptchaService = $recaptchaService;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Throwable
     */
    public function create(ThreadRequest $request)
    {
        try {
            // Get reCAPTCHA score (just for logging, no blocking)
            $recaptchaScore = null;
            if (auth()->user()->role < 1) {
                $recaptchaResult = $this->recaptchaService->verify($request->input('recaptcha_token'));
                $recaptchaScore = $recaptchaResult['score'] ?? null;
            }

            $data = $request->validated();
            $data['recaptcha_score'] = $recaptchaScore;

            $this->service->create($data);

            return redirect()->back()->with('success',
                "Votre message a bien été envoyé. Retrouvez tous vos messages dans la <a href='/mon-espace/messagerie'>messagerie</a>"
            );
        } catch (SpamContentException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        /** @var Collection $threads */
        $threads = $this->service->findAllThreadsByLoggedUser();
        $threadsWithUnreadMessages = $this->service->findThreadsWithUnreadMessages(auth()->id());
        $users = null;
        $responseTemplates = '';
        if (auth()->user()->role >= 1) {
            $users = $this->userService->findAllExceptPPAndLoggedUser();
            $users = json_encode($this->userService->findAllExceptPPAndLoggedUser());
            $responseTemplates = ResponseTemplate::all();
        }

        return view('pages.messages.index', compact('threads', 'users', 'threadsWithUnreadMessages', 'responseTemplates'));
    }

    public function refreshUnreadMessages()
    {
        /** @var Collection $threads */
        $threads = $this->service->findAllThreadsByLoggedUser();
        $threadsWithUnreadMessages = $this->service->findThreadsWithUnreadMessages(auth()->id());

        return response()->json($threadsWithUnreadMessages);
    }
}
