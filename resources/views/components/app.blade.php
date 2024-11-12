<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>appdate cms</title>
    @stack('scripts')
    @stack('styles')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <?php
    use App\Models\Site;
    $site = Auth::check() ? Site::find(Auth::user()->site_id) : Site::all()->first();
    $ga4TrackingCode = $site->ga4_tracking_code;
    ?>
    @if($site->ga4_tracking_code)
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga4TrackingCode }}"></script>
        <script>
            function trackPhoneCall(buttonPosition = '', phoneNumber) {
                fetch('{{ route('phone_calls.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        page_title: document.title,
                        page_location: window.location.href,
                        page_path: window.location.pathname,
                        button_position: buttonPosition,
                        phone_number: phoneNumber,
                        user_agent: navigator.userAgent
                    })
                });
            }

            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '{{ $ga4TrackingCode }}', {
                'debug_mode': true,
                'send_page_view': true,
                'cookie_domain': 'auto',
                'cookie_flags': 'SameSite=None;Secure',
                'page_location': window.location.href,
                'page_title': document.title,
            });

            // testing event form_submit saving by GA4
            gtag('event', 'form_submit', {
                'page_title': document.title,
                'page_location': window.location.href,
                'page_path': window.location.pathname,
                'button_position': 1,
                'date_time': new Date().toISOString(),
                'phone_number': '0123456789',
                'access_ip': '{{ getClientIp() }}',
                'user_agent': navigator.userAgent
            });

            // saving phone calls by Calling API
            document.querySelector('a[href^="tel:"]').addEventListener('click', function() {
                trackPhoneCall('btn-tel', this.href.replace('tel:', ''));
            });

            // Log for debugging
            console.log('GA4 Tracking Code:', '{{ $ga4TrackingCode }}');
        </script>
    @else
        <script>
            console.warn('GA4 Tracking Code not found');
        </script>
    @endif

    @if($site->search_console_meta)
        {!! $site->search_console_meta !!}
    @endif

    @if($site->microsoft_clarity_tag)
        {!! $site->microsoft_clarity_tag !!}
    @endif

    @if($site->juicer_tag)
        {!! $site->juicer_tag !!}
    @endif
</head>

<body>
    <div id="app" class="w-screen h-screen overflow-hidden" v-cloak>
        {{ $slot }}
    </div>

    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
</body>

</html>
