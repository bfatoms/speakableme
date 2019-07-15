<?php

namespace Tests\Feature;

use Tests\TestCase;

class AppSuperadminTest extends TestCase
{
    public function testSuperAdminCantLogin()
    {
        $response = $this->post("api/auth/login",[
            "email" => "forondalouie@gmail.com",
            "password" => "qwesad"
        ]);

        $response->assertStatus(401);
    }

    public function testSuperAdminCanForceChangePassword()
    {
        $response = $this->json("PUT","api/auth/force-change-password/forondalouie@gmail.com?superadmin=true",[
            "new_password" => "qweasd"
        ]);
        
        $response->assertStatus(200)
            ->assertSeeText("SUCCESS_FORCE_PASSWORD_CHANGE");
    }

    public function testSuperAdminCanLogin(){
        $response = $this->json("POST","api/auth/login",[
            "email" => "forondalouie@gmail.com",
            "password" => "qweasd"
        ]);
        
        $response->assertStatus(200)
        ->assertSeeText("forondalouie@gmail.com")
        ->assertSeeText("access_token");
    }

}
