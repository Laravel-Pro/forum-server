<?php

namespace Tests\Pact;

use Amp\Process\ProcessException;
use GuzzleHttp\Psr7\Uri;
use PhpPact\Standalone\Installer\Exception\FileDownloadFailureException;
use PhpPact\Standalone\Installer\Exception\NoDownloaderFoundException;
use PhpPact\Standalone\ProviderVerifier\Model\VerifierConfig;
use PhpPact\Standalone\ProviderVerifier\Verifier;
use PhpPact\Standalone\Runner\ProcessRunner;
use PHPUnit\Framework\TestCase;

class PactVerifyTest extends TestCase
{
    /** @var ProcessRunner */
    private $processRunner;

    /**
     * Run laravel web server.
     */
    protected function setUp(): void
    {
        $this->processRunner = new ProcessRunner('php', ['artisan', 'serve', '--host=127.0.0.1', '--port=8000']);

        $this->processRunner->run(false);
    }

    /**
     * @throws ProcessException
     */
    protected function tearDown(): void
    {
        $this->processRunner->stop();
    }

    /**
     * @throws FileDownloadFailureException
     * @throws NoDownloaderFoundException
     */
    public function testPactVerifyConsumer()
    {
        $config = new VerifierConfig();
        $config
            ->setProviderName('forum-server') // Providers name to fetch.
            ->setProviderVersion('1.0.0') // Providers version.
            ->setProviderBaseUrl(new Uri('http://localhost:8000')) // URL of the Provider.
            // ->setBrokerUri(new Uri(''))
            // ->setBrokerUsername('')
            // ->setBrokerPassword('')
            ->setPublishResults(true);

        // Verify that the Consumer 'someConsumer' that is tagged with 'master' is valid.
        $verifier = new Verifier($config);

        $verifier->verify('forum-web');

        // This will not be reached if the PACT verifier throws an error, otherwise it was successful.
        $this->assertTrue(true, 'Pact Verification has failed.');
    }
}
