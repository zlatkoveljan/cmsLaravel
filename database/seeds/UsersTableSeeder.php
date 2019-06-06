<?php
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'zlatkoveljan@gmail.com')->first();
        //$ip = $_SERVER['REMOTE_ADDR'];
        //dd($ip);
        if (!$user)
        {
        	User::Create([
        		'name' => 'Zlatko Veljanoski',
        		'email' => 'zlatkoveljan@gmail.com',
        		'role' => 'admin',
                'password' => Hash::make('password'),
                'ip_address' => '127.0.0.1',
        	]);
        }
    }
}
