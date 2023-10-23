<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @yield('title')
        | Objectif Terres
    </title>

    <script>
        window.csrf_token = "{{ csrf_token() }}"
    </script>

    @yield('head-script')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Bebas+Neue|Kalam:700|Source+Sans+Pro&display=swap"
          rel="stylesheet">
    <link rel="icon" type="image/png" href="/images/favicon/favicon-32x32.png"/>
    <link rel="icon" href="/images/favicon/favicon.ico"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.2.96/css/materialdesignicons.min.css">
    <script src="https://kit.fontawesome.com/c97506cdaa.js" crossorigin="anonymous"></script>
    <!-- Hotjar Tracking Code for https://www.objectif-terres.org/ -->
    <!--    <script>
            (function(h,o,t,j,a,r){
                h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
                h._hjSettings={hjid:3414514,hjsv:6};
                a=o.getElementsByTagName('head')[0];
                r=o.createElement('script');r.async=1;
                r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
                a.appendChild(r);
            })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
        </script>-->


    <!--    if(app()->environment() === "production")
            <script id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-cbid="9e743d8b-bfc8-4eed-8632-b3fc81f18778" data-blockingmode="auto" type="text/javascript"></script>
        endif-->
</head>
<body lang="fr-FR">
<div id="app">


    <header>
        @include('layouts.header')
        @yield('header')
    </header>

    @yield('main-content')

    @include('layouts.footer')
</div>
<script>
    var $buoop = {
        required: {e: -4, f: -3, o: -3, s: -1, c: -5},
        reminder: 0,
        reminderClosed: 1,
        insecure: true,
        unsupported: true,
        api: 2020.12
    };

    function $buo_f() {
        var e = document.createElement("script");
        e.src = "//browser-update.org/update.min.js";
        document.body.appendChild(e);
    };
    try {
        document.addEventListener("DOMContentLoaded", $buo_f, false)
    } catch (e) {
        window.attachEvent("onload", $buo_f)
    }
</script>

<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
<script>
    window.$user = {!!  json_encode(auth()->user()?->only(['first_name', 'name', 'role'])) !!};
    window.$env = "{{ config('app.env') }}";

    // Notifications close button
    let closeNotification = document.querySelector('button[data-type=close-main-message]');
    closeNotification && closeNotification.addEventListener('click', function (e) {
        let message = document.querySelector('article[data-type=main-message ]');
        message.style.display = 'none';
    });
</script>
<script src="{{ mix('js/app.js') }}"></script>
<script>
</script>
<style>
    #jsd-widget {
        bottom: 60px !important;
    }
</style>


@if(app()->environment() === "production")
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-CZC04WPSVH"></script>
    <script>

        enableGoogleAnalytics();
        enableMatomoAnalytics();

        //window.addEventListener('CookiebotOnAccept', function (e) {
        //    if (Cookiebot.consent.statistics)
        //    {
        //        enableGoogleAnalytics();
        //        enableMatomoAnalytics();
        //    }
        //}, false);

        function enableGoogleAnalytics() {
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', 'G-CZC04WPSVH');
        }

        function enableMatomoAnalytics() {
            var _paq = window._paq = window._paq || [];
            /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
            _paq.push(['trackPageView']);
            _paq.push(['enableLinkTracking']);
            (function () {
                var u = "https://terredeliens.matomo.cloud/";
                _paq.push(['setTrackerUrl', u + 'matomo.php']);
                _paq.push(['setSiteId', '3']);
                var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
                g.async = true;
                g.src = '//cdn.matomo.cloud/terredeliens.matomo.cloud/matomo.js';
                s.parentNode.insertBefore(g, s);
            })();
        }
    </script>
@endif

@yield('script')

</body>
</html>
