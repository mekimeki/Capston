<?php

namespace App\Jobs;

use Carbon\Carbon;
use FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Model\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConverVideoForThumbnail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $video_pk;
    public function __construct($video_pk)
    {
        //
        $this->video_pk = $video_pk;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $video_pk = $this->video_pk;
        
        
        $media = FFMpeg::fromDisk('video')->open($video_pk.'.mp4');;//fromDisk('video')->open($video_pk.'.mp4');
        $durationInSeconds  = $media->getDurationInSeconds();
        $frameTime = rand(1,$durationInSeconds);
            FFMpeg::fromDisk('video')//$this->video->disk
                ->open($video_pk.'.mp4')
                ->getFrameFromSeconds($frameTime)
                ->export()
                ->toDisk('img')
                ->save($video_pk.'.jpg');
    }
}
