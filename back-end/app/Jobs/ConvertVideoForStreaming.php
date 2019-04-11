<?php

namespace App\Jobs;

//use App\Video2;
use Carbon\Carbon;
use FFMpeg;
use FFMpeg\FFProbe;
use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Video;
class ConvertVideoForStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $path;
    public function __construct($path)//Video $video
    {
        //$this->video = $video;
        $this->path = $path;
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //return $this->video->path;
        // create some video formats...
        $lowBitrateFormat = (new X264('aac', 'libx264'))->setKiloBitrate(500);
        $midBitrateFormat  = (new X264('aac', 'libx264'))->setKiloBitrate(1500);
        $highBitrateFormat = (new X264('aac', 'libx264'))->setKiloBitrate(3000);
        $start = \FFMpeg\Coordinate\TimeCode::fromSeconds(7);
        $duration = \FFMpeg\Coordinate\TimeCode::fromSeconds(1);
        $clipFilter = new \FFMpeg\Filters\Video\ClipFilter($start,$duration);
        // open the uploaded video from the right disk...
        FFMpeg::fromDisk('public')//$this->video->disk
            ->open($this->path)
            //->addFilter($clipFilter)
            ->exportForHLS()
            ->toDisk('public')// streamable_videos
            ->setSegmentLength(15)
            ->addFormat($lowBitrateFormat)
            ->save('test1234'. '.m3u8');//$this->video->video_pk 

            /*
        $this->video->update([
            'converted_for_streaming_at' => Carbon::now(),
        ]);
        */
    }
}
