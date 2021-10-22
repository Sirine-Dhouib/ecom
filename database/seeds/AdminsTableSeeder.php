<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();

        $adminRecords = [
            [ 'id' => 1 , 'name' => 'mohamed' , 'type' => 'administrateur' , 'mobile' => '+216 55 555 555' , 'email' => 'mohamed21655555555@gmail.com' ,
             'password' => '$2y$10$WeGgU9FCKhR0mQtMgHF5TuV.7TWXepw6EX9RF9NXUv4.328N9gqUa' , 'image' => '' , 'status' => 1] ,
             [ 'id' => 2 , 'name' => 'sirine' , 'type' => 'sous administrateur' , 'mobile' => '+216 44 444 444' , 'email' => 'sirine21644444444@gmail.com' ,
             'password' => '$2y$10$WeGgU9FCKhR0mQtMgHF5TuV.7TWXepw6EX9RF9NXUv4.328N9gqUa' , 'image' => '' , 'status' => 1] ,
             [ 'id' => 3 , 'name' => 'ines' , 'type' => 'sous administrateur' , 'mobile' => '+216 33 333 333' , 'email' => 'ines21633333333@gmail.com' ,
             'password' => '$2y$10$WeGgU9FCKhR0mQtMgHF5TuV.7TWXepw6EX9RF9NXUv4.328N9gqUa' , 'image' => '' , 'status' => 1] ,
             [ 'id' => 4 , 'name' => 'ahmed' , 'type' => 'administrateur' , 'mobile' => '+216 22 222 222' , 'email' => 'ahmed21622222222@gmail.com' ,
             'password' => '$2y$10$WeGgU9FCKhR0mQtMgHF5TuV.7TWXepw6EX9RF9NXUv4.328N9gqUa' , 'image' => '' , 'status' => 1] , 
               
        ] ; 


        DB::table('admins')->insert($adminRecords);

        /*foreach ($adminRecords as $key => $record){
          
            \App\Admin::create($record);
        }*/
    }
}
