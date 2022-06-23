<?php

namespace App\Http\Controllers;


use App\Http\Requests\SocialNetworkAuthRequest;
use App\Models\SocialNetworkType;
use App\Models\User;
use App\Services\SocialNetworkAuthService;
use http\Env\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SocialAuthController extends Controller
{
    protected User $user;

    protected int $socialNetworkTypeId = -1;

    protected array $socialNetworkLinks = [];

    private \Illuminate\Contracts\Routing\ResponseFactory $responseFactory;

    private \Illuminate\Contracts\View\Factory $viewFactory;

    private \Illuminate\Contracts\Auth\Guard $guard;

    private \Illuminate\Routing\Redirector $redirector;

    public function __construct(\Illuminate\Contracts\Routing\ResponseFactory $responseFactory, \Illuminate\Contracts\View\Factory $viewFactory, \Illuminate\Contracts\Auth\Guard $guard, \Illuminate\Routing\Redirector $redirector)
    {
        $this->socialNetworkLinks[env('VKONTAKTE_REDIRECT_URI')] = 'vkontakte';
        $this->socialNetworkLinks[env('GOOGLE_REDIRECT_URI')] = 'google';
        $this->responseFactory = $responseFactory;
        $this->viewFactory = $viewFactory;
        $this->guard = $guard;
        $this->redirector = $redirector;
    }

    /**
     * Redirect to social network auth page
     *
     * @return \Illuminate\Http\RedirectResponse|RedirectResponse
     */
    public function index(SocialNetworkAuthRequest $request): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $socialNetworkName = $request->input('socialNetwork');
        return Socialite::driver($socialNetworkName)->redirect();
    }

    /**
     * Receive user from service and send it to login function. If application
     * does not allowed received service, function will return 403 status
     *
     * @return View|\Illuminate\Http\RedirectResponse|Response
     */
    public function callback(\Illuminate\Http\Request $request)
    {
        $url = $request->url();

        if (!array_key_exists($url, $this->socialNetworkLinks)) {
            return $this->responseFactory->make('', 403);
        }

        $socialNetworkName = $this->socialNetworkLinks[$request->url()];

        $user = Socialite::driver($socialNetworkName)->user();
        return $this->login($user, $socialNetworkName);
    }

    /**
     * Receive user model from service and login it with SocialNetworkAuthService
     */
    public function login(\Laravel\Socialite\Contracts\User $user, string $socialNetworkName)
    {
        $this->socialNetworkTypeId = SocialNetworkType::query()
            ->where('name', '=', $socialNetworkName)
            ->first()
            ->getAttribute('id');

        $service = new SocialNetworkAuthService();

        $this->user = $service->login($user, $this->socialNetworkTypeId);
        $this->user->update(['name' => $user->getNickname()]);

        if (empty($this->user->getEmail())) {
            return $this->viewFactory->make('auth.emailNotProvided');
        }

        $this->guard->login($this->user);

        return $this->redirector->to('/');

    }
}
