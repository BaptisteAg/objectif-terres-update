<?php

namespace Tests\Unit;

use App\Models\AdNote;
use App\Models\BioCertification;
use App\Models\City;
use App\Models\Document;
use App\Models\Research;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DocumentsTest extends TestCase
{
    use WithFaker;

    private $ad;

    protected function setUp(): void
    {
        parent::setUp();

    }

    public function test()
    {
        //        $document = factory(Document::class)->create();
        //        $ad = factory(AdRequest::class)->create();
        //        $adNote = factory(AdNote::class)->create();
        //
        //        $ad->documents()->save($document);
        //
        //        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $document->documentable);

        //        $productionGenre = factory(BioCertification::class)->create();
        $research = factory(Research::class)->create();
        //
        //        $research->bioCertifications()->save($productionGenre);

        $cities = City::all()->random()->id;
        $research->cities()->save($cities);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $cities->researches);
    }
}
