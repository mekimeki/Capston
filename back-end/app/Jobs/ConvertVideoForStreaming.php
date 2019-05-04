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
use App\Model\Video;
use Illuminate\Http\Request;
class ConvertVideoForStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $streaming;
    public $video;
    public $request;
    public function __construct(Video $video,$streaming)//Video $video
    {
        $this->video = $video;
        $this->streaming = $streaming;
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
        $video_pk = $this->video->video_pk;
        $lowBitrateFormat = (new X264('aac', 'libx264'))->setKiloBitrate(500);
        $midBitrateFormat  = (new X264('aac', 'libx264'))->setKiloBitrate(1500);
        $highBitrateFormat = (new X264('aac', 'libx264'))->setKiloBitrate(3000);
        $start = \FFMpeg\Coordinate\TimeCode::fromSeconds($this->streaming['start']);
        $duration = \FFMpeg\Coordinate\TimeCode::fromSeconds($this->streaming['duration']);
        $clipFilter = new \FFMpeg\Filters\Video\ClipFilter($start,$duration);
        // open the uploaded video from the right disk...
        FFMpeg::fromDisk('public')//$this->video->disk
            ->open($this->streaming['path'])
            ->addFilter($clipFilter)
            //->exportForHLS()
            ->export()
            //
            ->toDisk('video')// streamable_videos
            //->setSegmentLength(15)
            //->addFormat($lowBitrateFormat)
            ->inFormat($lowBitrateFormat)
            //
            ->save($video_pk. '.mp4');//$this->video->video_pk 
        $this->video->where('video_pk',$video_pk)->update(['v_add'=>asset('storage/video/'.$video_pk.'.mp4')]);
        /*
        $this->video->update([
            'converted_for_streaming_at' => Carbon::now(),
        ]);
        */
    }
}
