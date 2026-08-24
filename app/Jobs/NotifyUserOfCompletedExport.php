<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Models\ReporteGeneral;
use App\Mail\ReportGeneralCompleted;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyUserOfCompletedExport implements ShouldQueue
{
    use Queueable, SerializesModels;


    private $user;
    private $reporte;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $reporte)
    {
       $this->user = $user;
       $this->reporte = $reporte;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       
        $email = $this->user->email;

        $details = [
            'idreporte' => $this->reporte,
            'solicitante' => $this->user->nombres.' '.$this->user->apellidos
        ];

        \Mail::to($email)->send(new ReportGeneralCompleted($details));
        
       
       
          
    }

     /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed()
    {

       
    }
}
