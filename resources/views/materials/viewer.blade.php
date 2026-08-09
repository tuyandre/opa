<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} | OPA</title>
    <style>
        * { box-sizing: border-box; }
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f4f4;
        }
        .viewer-topbar {
            display: flex;
            align-items: center;
            gap: 14px;
            height: 56px;
            padding: 0 18px;
            background: #146c77;
            color: #fff;
        }
        .viewer-topbar a {
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }
        .viewer-topbar a:hover {
            opacity: 0.85;
        }
        .viewer-title {
            font-size: 15px;
            font-weight: bold;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .viewer-body {
            height: calc(100% - 56px);
            width: 100%;
        }
        .viewer-body iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
        .viewer-body video {
            width: 100%;
            height: 100%;
            background: #000;
            display: block;
        }
        .viewer-image-wrap {
            height: 100%;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: auto;
        }
        .viewer-image-wrap img {
            max-width: 100%;
            max-height: 100%;
        }
        .viewer-unsupported {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: #4c4e56;
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="viewer-topbar">
    <a href="{{ $backUrl }}">&larr; Back</a>
    <span class="viewer-title">{{ $title }}</span>
</div>
<div class="viewer-body">
    @if($category === 'pdf')
        <iframe src="{{ $rawUrl }}#toolbar=0&navpanes=0&statusbar=0"></iframe>
    @elseif($category === 'video')
        <video controls controlsList="nodownload noremoteplayback" disablePictureInPicture oncontextmenu="return false;">
            <source src="{{ $rawUrl }}">
            Your browser does not support video playback.
        </video>
    @elseif($category === 'image')
        <div class="viewer-image-wrap" oncontextmenu="return false;">
            <img src="{{ $rawUrl }}" alt="{{ $title }}">
        </div>
    @else
        <div class="viewer-unsupported">
            <p>This file type can't be previewed in-browser.</p>
            <p>Please contact the training office if you need to view this file.</p>
        </div>
    @endif
</div>
</body>
</html>
