<?php

namespace Tests\Feature;

use Faker\Provider\File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\File as FacadesFile;
use Tests\TestCase;

class translaationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_is_all_keys_is_translated_or_note()
    {
        $arabic = array_keys(FacadesFile::getRequire(base_path() . '/resources/lang/ar/translation.php'));
        $eng = array_keys(FacadesFile::getRequire(base_path() . '/resources/lang/en/translation.php'));
        // dd($arabic, $eng);
        $diff = [];
        foreach ($arabic as $value) {
            if (!in_array($value, $eng)) {
                $diff[] = $value;
            }
        }
        if (count($diff) == 0) {
            $this->assertTrue(True);
        }
        dd($diff, count($arabic), count($eng), count($diff));
    }
}
