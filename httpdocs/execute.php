<?php
/**
 * Asegura que la URL lleve esquema (http/https).
 */
function ensureSchema(string $url): string {
    if (!preg_match('#^https?://#i', $url)) {
        $url = 'https://' . $url;
    }
    return $url;
}

/**
 * Descarga el HTML de cualquier dominio con cURL.
 */
function fetchHtml(string $url): ?string {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT        => 15,
    ]);
    $html = curl_exec($ch);
    $err  = curl_error($ch);
    curl_close($ch);

    if ($html === false || $err) {
        error_log("cURL error: $err");
        return null;
    }
    return $html;
}

/**
 * Extrae título y precio de una página de Amazon de cualquier país.
 */
function scrapeAmazonInternational(string $url): ?array {
    $url  = ensureSchema($url);
    $html = fetchHtml($url);
    if (!$html) return null;

    // Parse HTML
    libxml_use_internal_errors(true);
    $doc   = new DOMDocument();
    $doc->loadHTML($html);
    libxml_clear_errors();
    $xpath = new DOMXPath($doc);

    // 1) Intento JSON-LD (más fiable y uniforme)
    $json = null;
    foreach ($xpath->query("//script[@type='application/ld+json']") as $node) {
        $text = trim($node->textContent);
        if (strpos($text, '"@type":"Product"') !== false) {
            $json = json_decode($text, true);
            break;
        }
    }
    if ($json && isset($json['name'], $json['offers']['price'], $json['offers']['priceCurrency'])) {
        $title = trim($json['name']);
        $price = trim($json['offers']['priceCurrency'] . $json['offers']['price']);
        return ['title' => $title, 'price' => $price];
    }

    // 2) Fallback con selectores clásicos
    // Título
    $titleNode = $xpath->query("//span[@id='productTitle']");
    $title = $titleNode->length
        ? trim($titleNode->item(0)->textContent)
        : null;

    // Varias rutas de precio
    $priceXPaths = [
        "//span[@id='priceblock_dealprice']",
        "//span[@id='priceblock_ourprice']",
        "//span[contains(@class,'priceToPay')]//span[contains(@class,'a-offscreen')]",
        "//span[contains(@class,'a-price')]//span[contains(@class,'a-offscreen')]"
    ];
    $priceRaw = null;
    foreach ($priceXPaths as $xp) {
        $nodes = $xpath->query($xp);
        if ($nodes->length) {
            $priceRaw = trim($nodes->item(0)->textContent);
            break;
        }
    }

    // Limpieza final de salto de línea, comas y puntos repetidos
    if ($priceRaw !== null) {
        $p = preg_replace("/[\n,]+/", "", $priceRaw);
        $p = preg_replace("/\.+/", ".", $p);
        $price = trim($p);
    } else {
        $price = null;
    }

    return ['title' => $title, 'price' => $price];
}

// ————————————————
// EJEMPLO DE USO
// ————————————————
$url = 'https://www.amazon.fr/Ext%C3%A9rieur-Piquet-3000K-3300k-%C3%89clairage-%C3%A9tanche/dp/B0B17MHX4Q?pd_rd_w=aooTP&content-id=amzn1.sym.fce6efc7-fe76-4a3f-9da8-ff482a213bd9&pf_rd_p=fce6efc7-fe76-4a3f-9da8-ff482a213bd9&pf_rd_r=6GAVE2QVBNZ3Z99YJVQ2&pd_rd_wg=Xwp7Y&pd_rd_r=8920b90f-90fc-479e-b13c-3b04d9004bf4&pd_rd_i=B0B17MHX4Q&ref_=oct_dx_dotd_B0B17MHX4Q&th=1';
$data = scrapeAmazonInternational($url);

if ($data) {
    echo "Título: {$data['title']}\n";
    echo "Precio: {$data['price']}\n";
} else {
    echo "No se pudo extraer la información.\n";
}
