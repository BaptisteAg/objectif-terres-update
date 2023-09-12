<vue-header
        :unread_messages="{{$numberOfUnreadMessages}}"
        @if(auth()->user())
            :unread_notifications="{{auth()->user()->unreadNotifications->count()}}"
        @endif
        :routes="{
  home: '{{ route('home') }}',
  login: '{{ route('login') }}',
  @if(auth()->user())
      logout: '{{ route('logout') }}',
      account: '{{route('user.index')}}',
      messages: '{{route('threads.index')}}',
      notifications: '{{route('notification.index')}}',
      @if(auth()->user()->role >= 4 )
      role_4: '{{ \Laravel\Nova\Nova::path() }}',
      @endif
      @if(auth()->user()->role >= 3 )
      role_3: '{{ route('supervisor.index') }}',
      @endif
      @if(auth()->user()->role >= 2 )
      role_2: '{{ route('advisor.index') }}',
      @endif
      @if(auth()->user()->role >= 1 )
      role_1: '{{ route('moderator.index') }}',
      @endif
  @endif
  about_us: '{{ route('qui-sommes-nous') }}',
  create_ads: '{{ route('ads.create') }}',
  all_ads: '{{route('researches.index', ['ad_category' => 'all'])}}',
}"></vue-header>
