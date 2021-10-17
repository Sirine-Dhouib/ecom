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
            [ 'id' => 1 , 'name' => 'sirine' , 'type' => 'administrateur' , 'mobile' => ' 44 444 444' , 'email' => 'sirine21644444444@gmail.com' ,
             'password' => '$2y$10$WeGgU9FCKhR0mQtMgHF5TuV.7TWXepw6EX9RF9NXUv4.328N9gqUa' , 'image' => '' , 'status' => 1] ,
            [ 'id' => 2 , 'name' => 'mohamed' , 'type' => ' sous administrateur' , 'mobile' => ' 55 555 555' , 'email' => 'mohamed21655555555@gmail.com' ,
             'password' => '$2y$10$WeGgU9FCKhR0mQtMgHF5TuV.7TWXepw6EX9RF9NXUv4.328N9gqUa' , 'image' => '' , 'status' => 1] ,
             
               
        ] ; 


        DB::table('admins')->insert($adminRecords);

        /*foreach ($adminRecords as $key => $record){
          
            \App\Admin::create($record);
        }*/
    }
}
