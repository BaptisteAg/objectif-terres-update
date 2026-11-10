<?php

namespace Tests\Unit;

use App\Models\Document;
use Tests\TestCase;

class DocumentUrlEncodingTest extends TestCase
{
    public function test_url_encodes_spaces_in_path()
    {
        $document = new Document;
        $document->path = 'documents/ads/123/file with spaces.png';

        $url = $document->url;

        $this->assertStringContainsString('file%20with%20spaces.png', $url);
        $this->assertStringNotContainsString('file with spaces.png', $url);
    }

    public function test_url_encodes_accented_characters_in_path()
    {
        $document = new Document;
        $document->path = 'documents/ads/123/Capture écran.png';

        $url = $document->url;

        $this->assertStringContainsString('%C3%A9', $url); // é encoded
        $this->assertStringNotContainsString('écran', $url);
    }

    public function test_url_encodes_apostrophes_in_path()
    {
        $document = new Document;
        $document->path = "documents/ads/123/Capture d'écran vue aérienne.png";

        $url = $document->url;

        $this->assertStringContainsString('%27', $url); // ' encoded
        $this->assertStringContainsString('%20', $url); // spaces encoded
    }

    public function test_url_preserves_directory_slashes()
    {
        $document = new Document;
        $document->path = 'documents/ads/123/filename.png';

        $url = $document->url;

        $this->assertStringContainsString('documents/ads/123/filename.png', $url);
    }

    public function test_url_encoding_matches_expected_format()
    {
        $document = new Document;
        $document->path = "documents/ads/8743/65bfdc53e58a6Capture d'écran vue aérienne.png";

        $url = $document->url;

        // The URL should contain properly encoded path
        $this->assertStringContainsString(
            'documents/ads/8743/65bfdc53e58a6Capture%20d%27%C3%A9cran%20vue%20a%C3%A9rienne.png',
            $url
        );
    }
}
