<?php

use Illuminate\Support\Facades\DB;

test('initial roles accounts and contact are installed', function () {
    expect(DB::table('roles')->where('id', 1)->value('name_role'))->toBe('Superadmin')
        ->and(DB::table('roles')->where('id', 2)->value('name_role'))->toBe('Admin');

    $superadmin = DB::table('users')->where('email', 'superadmin@pepresma.test')->first();
    $admin = DB::table('users')->where('email', 'admin@pepresma.test')->first();

    expect($superadmin->role)->toBe(1)
        ->and(password_get_info($superadmin->password)['algoName'])->toBe('bcrypt')
        ->and($admin->role)->toBe(2)
        ->and(password_get_info($admin->password)['algoName'])->toBe('bcrypt')
        ->and(DB::table('contact')->exists())->toBeTrue();
});
