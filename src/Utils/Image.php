<?php

namespace HackbartPR\Utils;

use finfo;
use Psr\Http\Message\UploadedFileInterface;

trait Image
{
    private UploadedFileInterface $file;
    private ?string $extension = null;
    private int $maxSize = 1048576;
    private string $name;

    private function isValid(UploadedFileInterface $file): bool
    {        
        if ($file->getError() !== UPLOAD_ERR_OK) {
            return false;
        }
        
        $pathFile = $file->getStream()->getMetadata('uri');

        if (!$this->checkMimeType($pathFile)) {
            return false;
        }

        if (filesize($pathFile) > $this->maxSize) {
            return false;
        }

        $this->file = $file;        
        $this->setName();

        if (!$this->moveFile()) {
            return false;
        }

        return true;        
    }
    
    private function getName(): string
    {        
        return $this->name;
    }

    private function setName(): void
    {        
        $this->name = md5($this->file->getClientFilename()) . '.' . $this->extension;        
    }

    private function setMaxSize(int $size): void
    {
        $this->maxSize = $size;
    }

    private function moveFile(): bool
    {
        $uploadsPath = __DIR__ . '/../../public/img/uploads/';            
        $pathWithName = $uploadsPath . $this->getName();
        
        $this->file->moveTo($pathWithName);

        if (!file_exists($pathWithName)) {
            return false;
        }

        return true;
    }

    private function checkMimeType(string $tmpFile): bool
    {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($tmpFile);

        if (!str_starts_with($mimeType, 'image/')) {
            return false;
        }

        $this->getExtension($mimeType);

        return true;
    }

    private function getExtension(string $mimeType): void
    {
        $array = explode('/', $mimeType);

        $this->extension = $array[1];
    }
}