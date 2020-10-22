<?php

namespace App\Youtube;

use DateInterval;
use Illuminate\Support\Facades\Http;

class YoutubeServices
{
    private $key = null;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function handleYoutubeVideoDuration(string $video_url)
    {
        // get id from video url
        preg_match('/embed\/(.+)/', $video_url, $matches);
        $id = $matches[1];

        // call youtube's api to get the video duration
        $response = Http::get("https://www.googleapis.com/youtube/v3/videos?id={$id}&key={$this->key}&part=contentDetails");
        $duration = (json_decode($response))->items[0]->contentDetails->duration;

        // convert it in seconds
        $interval = new DateInterval($duration);
        return $interval->s + $interval->i * 60 + $interval->h * 3600;

    }
}
