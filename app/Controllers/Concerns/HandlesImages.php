<?php

namespace App\Controllers\Concerns;

use CodeIgniter\HTTP\Files\UploadedFile;
use Config\Services;
use RuntimeException;

trait HandlesImages
{
    private function storeImage(UploadedFile $file, string $folder, int $width, int $height): string
    {
        if (! $file->isValid() || $file->hasMoved()) {
            throw new RuntimeException($file->getErrorString());
        }

        $directory = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . $folder;
        if (! is_dir($directory) && ! mkdir($directory, 0775, true) && ! is_dir($directory)) {
            throw new RuntimeException('The upload folder could not be created.');
        }

        $name = $file->getRandomName();
        $file->move($directory, $name);
        $path = $directory . DIRECTORY_SEPARATOR . $name;

        Services::image()
            ->withFile($path)
            ->fit($width, $height, 'center')
            ->save($path, 86);

        return 'uploads/' . $folder . '/' . $name;
    }
}
