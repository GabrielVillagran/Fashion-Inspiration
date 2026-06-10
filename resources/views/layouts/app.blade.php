<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fashion Inspiration Library')</title>

    <style>
        :root {
            --background: #f7f3ef;
            --surface: #ffffff;
            --surface-soft: #fbf7f2;
            --text: #2b2522;
            --muted: #7a6f68;
            --border: #e4d8ce;
            --accent: #9b5c3e;
            --accent-dark: #75442d;
            --tag: #efe2d7;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: var(--background);
            color: var(--text);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .app-shell {
            min-height: 100vh;
        }

        .navbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 18px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .brand span {
            color: var(--accent);
        }

        .nav-links {
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .nav-link {
            color: var(--muted);
            font-size: 14px;
        }

        .button {
            background: var(--accent);
            color: white;
            padding: 10px 14px;
            border-radius: 10px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            display: inline-block;
        }

        .button:hover {
            background: var(--accent-dark);
        }

        .button-secondary {
            background: var(--surface);
            color: var(--accent);
            border: 1px solid var(--accent);
        }

        .button-secondary:hover {
            background: var(--surface-soft);
        }

        .container {
            width: min(1180px, calc(100% - 48px));
            margin: 0 auto;
            padding: 32px 0;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            gap: 24px;
            align-items: flex-start;
            margin-bottom: 28px;
        }

        .eyebrow {
            color: var(--accent);
            font-size: 13px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.08em;
            margin-bottom: 8px;
        }

        h1 {
            margin: 0;
            font-size: 36px;
            letter-spacing: -0.04em;
        }

        .subtitle {
            color: var(--muted);
            margin-top: 10px;
            max-width: 680px;
            line-height: 1.6;
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 20px;
            box-shadow: 0 12px 30px rgba(64, 44, 34, 0.05);
        }

        .library-layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 24px;
            align-items: start;
        }

        .filter-section {
            margin-bottom: 22px;
        }

        .filter-section h3 {
            margin: 0 0 10px;
            font-size: 14px;
        }

        .filter-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .filter-chip,
        .tag {
            background: var(--tag);
            color: var(--accent-dark);
            padding: 7px 10px;
            border-radius: 999px;
            font-size: 13px;
            display: inline-block;
        }

        .search-box {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid var(--border);
            border-radius: 12px;
            font-size: 15px;
            margin-bottom: 20px;
            background: var(--surface);
        }

        .image-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .garment-card {
            overflow: hidden;
            padding: 0;
        }

        .image-placeholder {
            height: 220px;
            background:
                linear-gradient(135deg, rgba(155, 92, 62, 0.22), rgba(43, 37, 34, 0.08)),
                repeating-linear-gradient(45deg, #f7f3ef 0, #f7f3ef 10px, #efe2d7 10px, #efe2d7 20px);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-dark);
            font-weight: 700;
        }

        .garment-content {
            padding: 16px;
        }

        .garment-title {
            font-weight: 700;
            margin-bottom: 8px;
        }

        .garment-description {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 12px;
        }

        .metadata-row {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .form-grid {
            display: grid;
            gap: 18px;
        }

        .form-group {
            display: grid;
            gap: 8px;
        }

        label {
            font-weight: 700;
            font-size: 14px;
        }

        input,
        textarea,
        select {
            padding: 12px 14px;
            border: 1px solid var(--border);
            border-radius: 12px;
            font-size: 15px;
            background: var(--surface);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .detail-layout {
            display: grid;
            grid-template-columns: 420px 1fr;
            gap: 24px;
            align-items: start;
        }

        .detail-image {
            height: 520px;
            border-radius: 18px;
        }

        .metadata-table {
            width: 100%;
            border-collapse: collapse;
        }

        .metadata-table th,
        .metadata-table td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid var(--border);
            vertical-align: top;
        }

        .metadata-table th {
            color: var(--muted);
            width: 180px;
            font-size: 14px;
        }

        .section-title {
            margin-top: 0;
            margin-bottom: 14px;
            font-size: 20px;
        }

        .empty-state {
            text-align: center;
            padding: 48px;
            color: var(--muted);
        }

        @media (max-width: 900px) {
            .library-layout,
            .detail-layout {
                grid-template-columns: 1fr;
            }

            .image-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .page-header {
                flex-direction: column;
            }
        }

        @media (max-width: 620px) {
            .navbar {
                flex-direction: column;
                gap: 14px;
                align-items: flex-start;
            }

            .image-grid {
                grid-template-columns: 1fr;
            }

            .container {
                width: min(100% - 28px, 1180px);
            }
        }
    </style>
</head>
<body>
    <div class="app-shell">
        <header class="navbar">
            <a href="{{ route('garments.index') }}" class="brand">
                Fashion <span>Inspiration</span>
            </a>

            <nav class="nav-links">
                <a class="nav-link" href="{{ route('garments.index') }}">Library</a>
                <a class="button" href="{{ route('garments.create') }}">Upload Image</a>
            </nav>
        </header>

        <main class="container">
            @yield('content')
        </main>
    </div>
</body>
</html>