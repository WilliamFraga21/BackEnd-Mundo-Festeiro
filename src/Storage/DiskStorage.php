<?php

namespace MiniRest\Storage;

use Exception;

class DiskStorage extends Storage
{
    private string $basePath;

    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    public function put($fileName, $imageData)
    {
        $filePath = $this->basePath . '/' . $fileName;

        // Verifique se o caminho do arquivo contém caracteres nulos
        if (strpos($filePath, "\0") !== false) {
            throw new Exception("O caminho do arquivo contém caracteres nulos.");
        }

        // Salve a imagem diretamente no caminho correto
        file_put_contents($filePath, $imageData);
    }


    public function get($path)
    {
        $fullPath = $this->basePath . '/' . $path;
        if (file_exists($fullPath)) {
            return file_get_contents($fullPath);
        }
        return null;
    }

    public function delete($path)
    {
        $fullPath = $this->basePath . '/' . $path;
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}