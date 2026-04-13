<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_home_page_renders_the_mobile_material_shell(): void
    {
        $response = $this->get(route('app.home'));

        $response->assertOk();
        $response->assertSee('name="viewport"', false);
        $response->assertSee('safe-area-inset-bottom', false);
        $response->assertSee('https://esm.run/@material/web/all.js', false);
        $response->assertSee('Today');
        $response->assertSee('Upcoming');
        $response->assertSee('Projects');
    }
}
