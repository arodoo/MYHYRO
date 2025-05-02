<?php 
header('Content-Type: application/json; charset=utf-8');

/**
 * Downloads any URL using cURL, forcing IPv4 and simulating a browser.
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
        CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4,
        CURLOPT_ENCODING       => '',
        CURLOPT_HTTPHEADER     => [
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Language: fr-FR,fr;q=0.9,en-US;q=0.8,en;q=0.7'
        ],
    ]);
    $html = curl_exec($ch);
    if ($html === false) {
        error_log('cURL error: ' . curl_error($ch));
        curl_close($ch);
        return null;
    }
    curl_close($ch);
    return $html;
}

/**
 * Extracts title, "deal" price, image, size variants, color, and selected size
 * from an international Amazon page.
 */
function scrapeAmazonDealProduct(string $url): ?array {
    $html = fetchHtml($url);
    if (!$html) return null;

    libxml_use_internal_errors(true);
    $doc   = new DOMDocument();
    $doc->loadHTML($html);
    libxml_clear_errors();
    $xpath = new DOMXPath($doc);

    // 1) TITLE
    $tN = $xpath->query("//span[@id='productTitle']");
    $title = $tN->length ? trim($tN->item(0)->textContent) : null;

    // 2) PRICE
    $priceRaw = null;
    $dealNode = $xpath->query("//span[@aria-hidden='true'][.//span[contains(@class,'a-price-whole')]]");
    if ($dealNode->length) {
        $n        = $dealNode->item(0);
        $whole    = trim($xpath->query(".//span[contains(@class,'a-price-whole')]",   $n)->item(0)->textContent);
        $fraction = trim($xpath->query(".//span[contains(@class,'a-price-fraction')]", $n)->item(0)->textContent);
        $symbol   = trim($xpath->query(".//span[contains(@class,'a-price-symbol')]",   $n)->item(0)->textContent);
        $priceRaw = "{$whole}.{$fraction}{$symbol}";
    } else {
        $xps = [
            "//span[@id='priceblock_dealprice']",
            "//span[@id='priceblock_ourprice']",
            "//div[@id='priceToPay']//span[contains(@class,'a-offscreen')]",
            "//span[contains(@class,'a-price')]//span[contains(@class,'a-offscreen')]"
        ];
        foreach ($xps as $xp) {
            $n = $xpath->query($xp);
            if ($n->length) {
                $priceRaw = trim($n->item(0)->textContent);
                break;
            }
        }
    }
    if ($priceRaw !== null) {
        $p     = preg_replace("/[\n\r\t ]+/", "", $priceRaw);
        $p     = preg_replace("/,+/", "", $p);
        $price = preg_replace("/\.+/", ".", $p);
    } else {
        $price = null;
    }

    // 3) MAIN IMAGE
    $iN = $xpath->query("//img[@id='landingImage']");
    $image = $iN->length ? trim($iN->item(0)->getAttribute('src')) : null;

    // 4) SIZE VARIANTS
    $variants = [];
    $nodes = $xpath->query("//div[@id='tp-inline-twister-dim-values-container']//span[contains(@class,'swatch-title-text-display')]");
    foreach ($nodes as $node) {
        $variants[] = trim($node->textContent);
    }

    // 5) COLOR
    $cN = $xpath->query("//span[@id='inline-twister-expanded-dimension-text-color_name']");
    $color = $cN->length ? trim($cN->item(0)->textContent) : null;

    // 6) SELECTED SIZE
    $sN = $xpath->query("//span[@id='inline-twister-expanded-dimension-text-size_name']");
    $size = $sN->length ? trim($sN->item(0)->textContent) : null;

    return [
        'title'    => $title,
        'price'    => $price,
        'image'    => $image,
        'variants' => $variants,
        'color'    => $color,
        'size'     => $size
    ];
}

?>