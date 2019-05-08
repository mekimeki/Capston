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
    public $videoName;
    public function __construct($video_pk,$videoName)//,$frameTime
    {
        //
        $this->video_pk = $video_pk;

        $this->videoName = $videoName;
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
        
        $videoName = $this->videoName;
        
        $media = FFMpeg::fromDisk('public')->open($videoName);;//fromDisk('video')->open($video_pk.'.mp4');
        $durationInSeconds = $media->getDurationInSeconds();
        
        for($i=0 ; $i<10 ; $i++){
            $num = $i+1;
            FFMpeg::fromDisk('public')//$this->video->disk
                ->open($videoName)
                ->getFrameFromSeconds($durationInSeconds/(10-$i))
                ->export()
                ->toDisk('img')
                ->save($video_pk.'_'.$num.'.jpg');
        }
        
    }
}
