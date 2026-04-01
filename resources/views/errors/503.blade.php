<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 — Sedang Dalam Pemeliharaan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #f5f3ff 0%, #ddd6fe 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; color: #5b21b6; }
        .container { text-align: center; padding: 2rem; }
        .code { font-size: 8rem; font-weight: 800; line-height: 1; background: linear-gradient(135deg, #7c3aed, #6d28d9); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .title { font-size: 1.5rem; font-weight: 600; margin: 1rem 0 0.5rem; color: #5b21b6; }
        .desc { color: #78716c; max-width: 420px; margin: 0 auto 2rem; line-height: 1.6; }
        .btn { display: inline-flex; align-items: center; gap: 0.5rem; background: #7c3aed; color: #fff; padding: 0.75rem 1.5rem; border-radius: 0.75rem; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: all 0.2s; box-shadow: 0 4px 14px rgba(124, 58, 237, 0.3); }
        .btn:hover { background: #6d28d9; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(124, 58, 237, 0.4); }
        .illustration { font-size: 4rem; margin-bottom: 1rem; }
        .pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="illustration pulse">🔧</div>
        <div class="code">503</div>
        <h1 class="title">Sedang Dalam Pemeliharaan</h1>
        <p class="desc">Website sedang dalam proses pemeliharaan untuk peningkatan layanan. Kami akan segera kembali. Terima kasih atas kesabaran Anda.</p>
        <a href="/" class="btn">
            Coba Lagi
        </a>
    </div>
</body>
</html>
