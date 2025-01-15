<?php



namespace App\Events;



use Illuminate\Queue\SerializesModels;

use Illuminate\Foundation\Events\Dispatchable;

use Illuminate\Broadcasting\InteractsWithSockets;

use App\Models\File;



class FileUploaded

{

    use Dispatchable, InteractsWithSockets, SerializesModels;



    public $file;



    public function __construct(File $file)

    {

        $this->file = $file;

    }

}


