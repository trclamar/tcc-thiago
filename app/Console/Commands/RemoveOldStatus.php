<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Vm;
use App\Status;

class RemoveOldStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove as linhas de status mais antigas.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $delimiter = 30;
        $vms = Vm::all();
        foreach( $vms as $vm ) {
            $status = Status::select('id')->where('hash_vm', $vm->hash)->orderBy('created_at', 'desc')->get();
            if(count($status) > $delimiter) {
                $recent     = $status->take($delimiter)->pluck('id')->toArray();
                $toDelete   = Status::select('id')->where('hash_vm', $vm->hash)->whereNotIn('id', $recent)->get();
                foreach($toDelete as $delete) {
                    $delete->delete();
                }
            }
        }

        $this->info('Status removido com sucesso.');
    }
}
