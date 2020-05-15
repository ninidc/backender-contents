<?php

namespace Backender\Contents\Jobs\Media;

use Backender\Contents\Http\Requests\Media\CreateMediaRequest;
use Backender\Contents\Entities\Media;
use Backender\Contents\Tasks\Media\BuildImageCrops;

use Intervention\Image\ImageManagerStatic as Image;
use Storage;
use Auth;

class CreateMedia
{

    private $filePath = null;
    private $metadata = null;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public static function fromRequest(CreateMediaRequest $request)
    {
        return new self($request->file('file'));
    }

    private function getFileMimeType()
    {
        return $this->file->getMimeType();
    }

    private function getFileType()
    {
        return explode('/', $this->getFileMimeType())[0] ?: null;
    }

    private function processImage()
    {
        $this->filePath = $this->file->store(config('images.storage_directory') . '/original');

        if ($this->filePath) {
            // Build cropped images
            (new BuildImageCrops(storage_path() . '/app/' . $this->filePath))->run();

            // Build medatadata
            $image = Image::make(storage_path() . '/app/' . $this->filePath);

            $this->metadata = [
                'filesize' => number_format($image->filesize() / 1000, 2, ',', ' '),
                'dimension' => sprintf('%dx%d', $image->width(), $image->height()),
            ];

            return true;
        }

        return false;
    }

    private function processFile()
    {
        $this->filePath = $this->file->store('public/medias/files');
    }


    public function handle()
    {
        switch ($this->getFileType()) {
            case 'image':
                $this->processImage();
            break;

            default:
                $this->processFile();
            break;
        }

        return $this->filePath
            ? Media::create([
                'stored_filename' => basename($this->filePath),
                'uploaded_filename' => $this->file->getClientOriginalName(),
                'type' => $this->getFileType(),
                'mime_type' => $this->getFileMimeType(),
                'metadata' => $this->metadata ? $this->metadata : null
            ])
            : false;
    }
}
