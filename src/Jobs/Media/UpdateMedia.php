<?php

namespace Backender\Contents\Jobs\Media;

use Backender\Contents\Http\Requests\Media\UpdateMediaRequest;
use Backender\Contents\Entities\Media;

use Intervention\Image\ImageManagerStatic as Image;
use Storage;
use Auth;

class UpdateMedia
{
    private $fields = [
        'metadata',
        'formats'
    ];

    public function __construct(Media $media, $attributes = [])
    {
        $this->media = $media;
        $this->attributes = array_only($attributes, $this->fields);

    }

    public static function fromRequest(Media $media, UpdateMediaRequest $request)
    {
        return new self($media, $request->all());
    }


    private function processImageFormats()
    {
        $formats = isset($this->attributes['formats']) ? $this->attributes['formats'] : null;

        if(!$formats) {
            return;
        }

        foreach($formats as $f) {
            $data = isset($f['data']) ? $f['data'] : null;

            if($data) {
                $path = str_replace('/storage/', '/public/', $f['url']);
                $image = Image::make($data);
                /*Dani fix images */
                if($f['ratio'] !== null){
                  if($f['width']/$f['height'] >=  $image->width()/$image->height()){
                    //control height of new image
                    if($image->height() > $f['height']){
                      $image->resize(null, $f['height'], function ($constraint) {
                          $constraint->aspectRatio();
                      });
                      //we do that in case aspect ratio of selector has been modified or incorrect
                      $image->resizeCanvas($f['width'], $f['height']);
                    }
                  }else{
                    //control width of new image
                    if($image->width() > $f['width']){
                      $image->resize($f['widht'], null,  function ($constraint) {
                          $constraint->aspectRatio();
                      });
                      //we do that in case aspect ratio of selector has been modified or incorrect
                      $image->resizeCanvas($f['width'], $f['height']);
                    }
                  }
                }
                /* End dani fix images */
                $imageData = (string) $image->encode();


                Storage::put($path, $imageData);
            }
        }
    }


    public function handle()
    {
        if(is_array($this->media->metadata)) {
            $metadata = isset($this->attributes["metadata"])
                ? array_merge($this->media->metadata, $this->attributes["metadata"])
                : $this->media->metadata;
        } else {
            $metadata = isset($this->attributes["metadata"])
                ? array_merge(json_decode($this->media->metadata, true), $this->attributes["metadata"])
                : $this->media->metadata;
        }

        if($this->media->update([
            'metadata' => $metadata
        ])) {
            $this->processImageFormats();

            return true;
        }

        return false;
    }
}
