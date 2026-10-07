<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 20px; }
        body { margin: 0; padding: 0; font-family: 'Century Gothic', Futura, 'Avant Garde', Verdana, sans-serif; background: #ffffff; }
        .frame { box-sizing: border-box; border: 6px solid #146c77; padding: 10px; }
        .frame-inner { box-sizing: border-box; border: 2px solid #e50031; padding: 18px 60px; text-align: center; }
        .logo { width: 80px; height: 80px; }
        .org-name { margin-top: 6px; font-size: 14px; letter-spacing: 5px; color: #146c77; font-weight: bold; }
        .title { margin-top: 12px; font-size: 30px; font-weight: bold; color: #101820; }
        .divider { margin: 8px auto 0; width: 220px; height: 3px; background: #e50031; }
        .presented-to { margin-top: 16px; font-size: 14px; color: #4c4e56; }
        .student-name { margin-top: 8px; font-size: 30px; font-weight: bold; color: #146c77; }
        .name-underline { margin: 6px auto 0; width: 360px; height: 1px; background: #146c77; }
        .program-line { margin-top: 14px; font-size: 14px; color: #4c4e56; }
        .program-title { margin-top: 6px; font-size: 18px; font-weight: bold; color: #101820; }
        .meta-line { margin-top: 6px; font-size: 12px; color: #4c4e56; }
        .issue-date { margin-top: 14px; font-size: 12px; color: #4c4e56; }
        .signatures { margin-top: 22px; width: 100%; }
        .signatures td { width: 50%; text-align: center; }
        .sig-line { margin: 0 auto; width: 220px; border-top: 1px solid #101820; padding-top: 8px; font-size: 13px; color: #101820; }
        .number { margin-top: 14px; font-size: 10px; color: #4c4e56; letter-spacing: 1px; }
    </style>
</head>
<body>
@php $fmt = fn($n) => rtrim(rtrim(number_format((float) $n, 2), '0'), '.'); @endphp
<div class="frame">
    <div class="frame-inner">
        <img class="logo" src="{{ public_path('assets/img/logo_black.png') }}" alt="OPA">
        <div class="org-name">OFFICE OF PROFESSIONAL AUDITORS</div>

        <div class="title">{{ $assessment->certificateTitle() }}</div>
        <div class="divider"></div>

        <div class="presented-to">This certificate is proudly presented to</div>
        <div class="student-name">{{ $attendant->name }}</div>
        <div class="name-underline"></div>

        <div class="program-line">{{ $assessment->certificateText() }}</div>
        <div class="program-title">{{ $assessment->certificateSubject() }}</div>
        <div class="meta-line">
            Score: {{ $fmt($attendant->score) }} / {{ $fmt($attendant->total_marks) }} ({{ $fmt($attendant->percentage) }}%)
            @if($attendant->company) &bull; {{ $attendant->company }} @endif
        </div>

        <div class="issue-date">Issued on {{ $issue_date }}</div>

        <table class="signatures">
            <tr>
                <td><div class="sig-line">Training Director</div></td>
                <td><div class="sig-line">Managing Director</div></td>
            </tr>
        </table>
        <div class="number">Certificate no. {{ $number }}</div>
    </div>
</div>
</body>
</html>
