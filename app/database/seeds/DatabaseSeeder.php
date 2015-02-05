<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UserTableSeeder');
	}
}

class UserTableSeeder extends Seeder {

    public function run()
    {
    	$password = Hash::make('admin');
        User::create(array('id'=>1,'first_name' => 'Admin','role'=>'admin', 'email'=>'admin','password'=>$password));
    }
}
