<?php
// ==============================================================================
// 1. BACKEND (PHP): İstekleri Yakalama ve Yanıtlama (Sayfa yenilenmez!)
// ==============================================================================

// [GET İSTEĞİ]: Butona tıklandığında URL'e "?saat=1" eklenerek burası tetiklenir
if (isset($_GET['saat'])) {
    echo "⏰ Sunucu Saati: " . date("H:i:s"); // Dönen veri doğrudan hx-target ile seçilen alana basılır
    exit; // Sadece bu metni dönüp PHP çalışmasını bitiriyoruz
}

// [POST İSTEĞİ]: Form gönderildiğinde $_POST['mesaj'] verisi ile burası tetiklenir
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mesaj'])) {
    $mesaj = htmlspecialchars($_POST['mesaj']);
    // Dönen HTML parçası, listenin en başına (afterbegin) anında eklenir
    echo "<li>✅ " . $mesaj . " <small style='color:#718096'>(" . date("H:i") . ")</small></li>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTMX + PHP Basit GET ve POST Rehberi</title>

    <!-- HTMX CDN: Tek satırda projeye dahil ediyoruz -->
    <script src="https://unpkg.com/htmx.org@2.0.4"></script>

    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            max-width: 650px;
            margin: 40px auto;
            padding: 0 20px;
            line-height: 1.6;
            color: #2d3748;
        }

        .kutu {
            border: 2px solid #e2e8f0;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .aciklama {
            font-size: 13px;
            color: #4a5568;
            background: #edf2f7;
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 15px;
            border-left: 4px solid #3182ce;
        }

        input,
        button {
            padding: 9px 14px;
            margin: 4px 0;
            border: 1px solid #cbd5e0;
            border-radius: 6px;
            font-size: 14px;
        }

        button {
            cursor: pointer;
            background: #3182ce;
            color: white;
            border: none;
            font-weight: 600;
        }

        button:hover {
            background: #2b6cb0;
        }

        ul {
            margin-top: 12px;
            padding-left: 20px;
        }

        li {
            padding: 4px 0;
        }

        code {
            background: #e2e8f0;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 12px;
            color: #b83280;
            font-family: monospace;
        }
    </style>
</head>

<body>

    <h2>⚡ Basit HTMX + PHP (GET & POST)</h2>
    <p style="color: #718096; margin-bottom: 20px;">Sayfa hiç yenilenmeden saf HTML nitelikleri (attributes) ile backend
        ile haberleşme.</p>

    <!-- =================================================================== -->
    <!-- 1. BÖLÜM: HTTP GET ÖRNEĞİ -->
    <!-- =================================================================== -->
    <div class="kutu">
        <h3>🟢 1. GET İsteği Örneği</h3>

        <!-- YAN PANEL / AÇIKLAMA -->
        <div class="aciklama">
            <strong>💡 Nasıl Çalışır?</strong><br>
            • <code>hx-get="?saat=1"</code> ➔ PHP'ye arka planda GET isteği atar.<br>
            • <code>hx-target="#saat-alani"</code> ➔ PHP'den dönen yazıyı bu div'in içine yerleştirir.
        </div>

        <!-- Buton: Tıklandığında GET isteği atar -->
        <button hx-get="?saat=1" hx-target="#saat-alani">
            Saati Getir (GET)
        </button>

        <!-- PHP'den dönen saat bilgisi buraya yazılır -->
        <div id="saat-alani" style="margin-top: 10px; font-weight: bold; color: #3182ce;">
            Henüz saat çekilmedi.
        </div>
    </div>

    <!-- =================================================================== -->
    <!-- 2. BÖLÜM: HTTP POST ÖRNEĞİ -->
    <!-- =================================================================== -->
    <div class="kutu">
        <h3>🟡 2. POST İsteği Örneği</h3>

        <!-- YAN PANEL / AÇIKLAMA -->
        <div class="aciklama">
            <strong>💡 Nasıl Çalışır?</strong><br>
            • <code>hx-post="?"</code> ➔ Formu sayfa yenilenmeden POST ile PHP'ye yollar.<br>
            • <code>hx-target="#mesaj-listesi"</code> ➔ Dönen yeni öğeyi bu listenin içine koyar.<br>
            • <code>hx-swap="afterbegin"</code> ➔ Yeni gelen öğeyi listenin en başına ekler.<br>
            • <code>hx-on::after-request="this.reset()"</code> ➔ Gönderim bitince inputu temizler.
        </div>

        <!-- Form: Gönderildiğinde POST isteği atar -->
        <form hx-post="?" hx-target="#mesaj-listesi" hx-swap="afterbegin" hx-on::after-request="this.reset()">

            <input type="text" name="mesaj" placeholder="Bir mesaj yazın..." required style="width: 70%;">
            <button type="submit">Ekle (POST)</button>
        </form>

        <!-- PHP'den üretilen <li> elemanları buraya eklenecek -->
        <ul id="mesaj-listesi">
            <li>Örnek başlangıç notu</li>
        </ul>
    </div>

</body>

</html>