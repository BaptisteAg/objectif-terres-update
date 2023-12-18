@php
    $numberOfUnreadNotifications = auth()->user() ? auth()->user()->unreadNotifications->count() : 0;
    $routes = [
        'home' => route('home'),
        'login' => route('login'),
        'about_us' => route('qui-sommes-nous'),
        'create_ads' => route('ads.create'),
        'support_requests' => config('app.sf_support_requests_url'),
        'all_ads' => route('researches.index', ['ad_category' => 'all']),
    ];
    if (auth()->user()) {
        $routes = array_merge($routes, [
            'logout' => route('logout'),
            'account' => route('user.index'),
            'messages' => route('threads.index'),
            'notifications' => route('notification.index'),
            'administration' => [
                'role_4' => auth()->user()->role >= 4 ? \Laravel\Nova\Nova::path() : null,
                'role_3' => auth()->user()->role >= 3 ? route('supervisor.index') : null,
//                'role_2' => auth()->user()->role >= 2 ? route('advisor.index') : null,
                'role_2' => auth()->user()->role >= 2 ? config('app.sf_support_requests_url_adm') : null,
                'role_1' => auth()->user()->role >= 1 ? route('moderator.index') : null,
            ]
        ]);
    }
@endphp

<mobile-header
        :unread_messages="{{$numberOfUnreadMessages}}"
        :unread_notifications="{{$numberOfUnreadNotifications}}"
        :routes="{{ json_encode($routes) }}"
></mobile-header>

<top-header
        :unread_messages="{{$numberOfUnreadMessages}}"
        :unread_notifications="{{$numberOfUnreadNotifications}}"
        :routes="{{ json_encode($routes) }}"
></top-header>

@if( (isset($errors) && $errors->count() ) || Session::has('success') || Session::has('warning') || Session::has('info') || Session::has('status'))
    @foreach($errors->all() as $message)
        <b-notification
                type="is-danger"
                aria-close-label="Close notification"
                role="alert">
            {!! $message !!}
        </b-notification>
    @endforeach
    @if ($message = Session::get('success'))
        <b-notification
                type="is-success"
                aria-close-label="Close notification"
                role="alert">
            {!! $message !!}
        </b-notification>
            <?php session()->forget('success') ?>
    @endif
    @if ($message =  Session::has('status'))
        <b-notification
                type="is-info"
                aria-close-label="Close notification"
                role="alert">
            {{ session('status') }}
        </b-notification>
    @endif
    @if($message = Session::get('warning'))
        <b-notification
                type="is-warning"
                aria-close-label="Close notification"
                role="alert">
            {{ $message }}
        </b-notification>
            <?php session()->forget('warning') ?>
    @endif
    @if($message = Session::get('info'))
        <b-notification
                type="is-info"
                aria-close-label="Close notification"
                role="alert">
            {{ $message }}
        </b-notification>
            <?php session()->forget('info') ?>
    @endif
@endif

@if($infoBanner && $infoBanner !== '')
    <b-notification
            id="info-banner"
            type="is-info"
            role="alert">
        {!! $infoBanner !!}
    </b-notification>
@endif
<bottom-header
        :routes="{{ json_encode($routes) }}"
></bottom-header>
