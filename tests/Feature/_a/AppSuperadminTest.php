<?php

namespace Tests\Feature;

use Tests\TestCase;

class AppSuperadminTest extends TestCase
{
    public static $email = "forondalouie@gmail.com";
    public static $user = [];
    public function testSuperAdminCantLogin()
    {
        $response = $this->post("api/auth/login",[
            "email" => self::$email,
            "password" => "qwesad"
        ]);

        $response->assertStatus(401)
            ->assertSeeText("UNAUTHORIZED_USER");
    }

    public function testSuperAdminCanForceChangePassword()
    {
        $response = $this->json("PUT","api/auth/force-change-password/forondalouie@gmail.com?superadmin=true",[
            "new_password" => "qweasd"
        ]);
        
        $response->assertStatus(200)
            ->assertSeeText("SUCCESSFUL_FORCE_PASSWORD_CHANGE");
    }

    public function testSuperAdminCanLogin(){
        $response = $this->json("POST","api/auth/login",[
            "email" => self::$email,
            "password" => "qweasd"
        ]);

        $response->assertStatus(200)
        ->assertSeeText(self::$email)
        ->assertSeeText("access_token");

        self::$user = $response->original['result'];

    }

    public function testSuperAdminCanRefreshToken()
    {
        $response = $this->json("POST","api/auth/refresh",[],[
            'Authorization' => 'Bearer '. self::$user['token']['access_token']
        ]);

        $response->assertStatus(200)
            ->assertSeeText('access_token');
        // ->assertSeeText(self::$email)
        // ->assertSeeText("access_token");

    }

}
