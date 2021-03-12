<?php declare(strict_types=1);

use Magento\Framework\App\Bootstrap;
use Magento\Framework\App\Http;

require_once discoverBootstrapFile();

$bootstrap = Bootstrap::create(BP, $_SERVER);
$app = $bootstrap->createApplication(Http::class);

function discoverBootstrapFile(string $baseDir = __DIR__): string
{
    if (is_file($baseDir . '/app/bootstrap.php')) {
        return $baseDir . '/app/bootstrap.php';
    }

    return discoverBootstrapFile(dirname($baseDir));
}
