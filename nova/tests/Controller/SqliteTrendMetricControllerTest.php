<?php

namespace Laravel\Nova\Tests\Controller;

use Laravel\Nova\Tests\IntegrationTest;

class SqliteTrendMetricControllerTest extends IntegrationTest
{
    use TrendDateTests;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authenticate();
    }
}
