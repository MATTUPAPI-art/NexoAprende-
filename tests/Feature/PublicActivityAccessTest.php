<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicActivityAccessTest extends TestCase
{
    public function test_old_public_attention_activity_is_not_available(): void
    {
        $this->get('/actividades/atencion')
            ->assertNotFound();
    }

    public function test_guest_cannot_open_profile_attention_activity(): void
    {
        $this->get(
            route(
                'child-profiles.activities.attention',
                ['childProfile' => 1]
            )
        )->assertRedirect(route('login'));
    }

    public function test_homepage_sends_guest_to_registration(): void
    {
        $this->get(route('inicio'))
            ->assertOk()
            ->assertSee(route('register'));
    }
}
