<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex">
    <title>@yield('title', 'Assessment') | Office of Professional Auditors</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/sivicon.png') }}">
    <style>
        :root {
            --teal: #146c77; --teal-dark: #0c444b; --tint: #e7f5fb; --dark: #101820;
            --grey: #4c4e56; --red: #e50031; --line: #dfe5e8; --bg: #f2f7f8;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0; background: var(--bg); color: var(--dark);
            font-family: 'Century Gothic', Futura, 'Avant Garde', Verdana, sans-serif; line-height: 1.5;
        }
        a { color: var(--teal); text-decoration: none; }
        header.top {
            background: #fff; border-bottom: 1px solid var(--line); padding: 6px 32px;
            display: flex; align-items: center; justify-content: space-between; gap: 16px;
        }
        header.top img { height: 64px; display: block; }
        header.top .right { display: flex; align-items: center; gap: 28px; font-size: 13px; }
        header.top .ld { letter-spacing: .14em; text-transform: uppercase; color: var(--grey); }
        .wrap { max-width: 1100px; margin: 0 auto; padding: 48px 24px 64px; }
        .eyebrow { color: var(--teal); font-weight: bold; letter-spacing: .12em; font-size: 12px; text-transform: uppercase; }
        h1 { font-size: 44px; line-height: 1.1; margin: 12px 0 16px; font-weight: bold; }
        h2 { font-size: 22px; margin: 0 0 8px; }
        .lead { color: var(--grey); font-size: 18px; max-width: 460px; }
        .card { background: #fff; border: 1px solid var(--line); border-radius: 14px; border-top: 4px solid var(--teal); padding: 32px; }
        label { display: block; font-weight: bold; font-size: 14px; margin: 18px 0 6px; }
        input[type=text], input[type=email] {
            width: 100%; padding: 13px 14px; font: inherit; border: 1px solid #cdd5d9; border-radius: 8px; background: #fff; color: var(--dark);
        }
        input:focus { outline: 2px solid var(--teal); outline-offset: 1px; border-color: var(--teal); }
        .btn {
            display: block; width: 100%; margin-top: 22px; padding: 14px; border: 0; border-radius: 8px; cursor: pointer;
            background: var(--teal); color: #fff; font: inherit; font-weight: bold; font-size: 16px;
        }
        .btn:hover { background: var(--teal-dark); }
        .btn.ghost { background: #fff; color: var(--teal); border: 1px solid var(--teal); }
        .note { background: var(--tint); border-radius: 8px; padding: 14px 16px; font-size: 14px; color: var(--grey); margin-top: 18px; }
        .small { font-size: 13px; color: var(--grey); }
        .error { color: var(--red); font-size: 14px; margin-top: 6px; }
        .alert { background: #fdecef; color: var(--red); border-radius: 8px; padding: 12px 14px; font-size: 14px; margin-bottom: 8px; }
        @media (max-width: 760px) {
            header.top { padding: 12px 16px; } header.top .ld { display: none; }
            h1 { font-size: 32px; } .wrap { padding: 28px 16px 48px; } .card { padding: 22px; }
        }
        @yield('styles')
    </style>
</head>
<body>
<header class="top">
    <a href="{{ url('/') }}"><img src="{{ asset('assets/img/logo33.png') }}" alt="Office of Professional Auditors"></a>
    <div class="right">
        <span class="ld">Learning &amp; Development</span>
        <a href="{{ route('login') }}"><strong>Trainer access</strong></a>
    </div>
</header>
@yield('content')
@yield('scripts')
</body>
</html>
