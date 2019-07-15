<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function comment($message)
    {
        fwrite(STDOUT, $message."\n");
    }
}
