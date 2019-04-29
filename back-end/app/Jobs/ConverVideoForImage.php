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

class ConverVideoForImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $video_pk;
    public $frameTime;
    public function __construct($video_pk,$frameTime)
    {
        //
        $this->video_pk = $video_pk;
        $this->frameTime = $frameTime;
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
        $frameTime = $this->frameTime;
        FFMpeg::fromDisk('video')//$this->video->disk
            ->open($video_pk.'.mp4')
            ->getFrameFromSeconds($frameTime)
            ->export()
            ->toDisk('img')
            ->save($video_pk.'.png');
    }
}
