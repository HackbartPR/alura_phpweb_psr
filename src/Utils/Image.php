<?php

namespace HackbartPR\Utils;

class Image
{
    private array $file;
    private ?string $extension = null;
    private int $maxSize = 1048576;

    public function isValid(array $file): bool
    {        
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }
        
        $info = getimagesize($file['tmp_name']);        

        if (!$info) {
            return false;
        }

        if (filesize($file['tmp_name']) > $this->maxSize) {
            return false;
        }

        $this->file = $file;
        $this->extension = image_type_to_extension($info[2]);
        $this->setName();

        if (!$this->moveFile()) {
            return false;
        }

        return true;        
    }
    
    public function getName(): string
    {        
        return $this->file['name'];
    }

    private function setName(): void
    {        
        $this->file['name'] = md5($this->file['name']) . $this->extension;        
    }

    public function setMaxSize(int $size): void
    {
        $this->maxSize = $size;
    }

    private function moveFile(): bool
    {
        $uploadsPath = __DIR__ . '/../../public/img/uploads/';            
        $pathWithName = $uploadsPath . $this->getName();
        
        move_uploaded_file($this->file['tmp_name'], $pathWithName);

        if (!file_exists($pathWithName)) {
            return false;
        }

        return true;
    }
}