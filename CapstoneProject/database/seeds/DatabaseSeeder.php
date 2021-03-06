<?php

use Illuminate\Database\Seeder;
use database\seeds\PaymentTypeSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Initializes the database 
        DB::table('tblpaymenttype')->insert(array(
             array('strPaymentTypeID'=>'1','strPaymentType'=>'Initial Bill'),
             array('strPaymentTypeID'=>'2','strPaymentType'=>'Down Payment'),
             array('strPaymentTypeID'=>'3','strPaymentType'=>'Initial Payment'),
             array('strPaymentTypeID'=>'4','strPaymentType'=>'Additional Bill'),
             array('strPaymentTypeID'=>'5','strPaymentType'=>'Additional Payment'),
             array('strPaymentTypeID'=>'6','strPaymentType'=>'Other Bill')
        ));
        
        //for verification
        $this->command->info("Payment Type table seeded :)");
    }
}
