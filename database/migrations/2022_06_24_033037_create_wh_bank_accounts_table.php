<?php

use App\Models\WhBankAccount;
use App\Models\WhParam;
use Hashids\Hashids;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_id');
            $table->string('accountno',30);
            $table->string('shortname',15);
            $table->foreignId('currency_id');
            $table->enum('isactive',['Y','N'])->default('Y');
            $table->string('token',60);
            $table->timestamps();
        });
        $hash = new Hashids();
        $row = new WhBankAccount();
        $row->create([
            'bank_id' => WhParam::where('shortname','BCP')->where('group_id',2)->first()->id,
            'accountno' => '191-12345678-0-00',
            'shortname' => 'BCP SOLES',
            'currency_id' => 1,
            'token' => $hash->encode(WhBankAccount::all()->count('id') + 1),
        ]);
        $row->create([
            'bank_id' => WhParam::where('shortname','BCP')->where('group_id',2)->first()->id,
            'accountno' => '191-12345678-1-00',
            'shortname' => 'BCP DOLARES',
            'currency_id' => 2,
            'token' => $hash->encode(WhBankAccount::all()->count('id') + 1),
        ]);
  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_bank_accounts');
    }
}
