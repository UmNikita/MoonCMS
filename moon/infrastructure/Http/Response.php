<?php

namespace Moon\infrastructure\Http;

class Response {

    private int $statusCode;
    private string $template;
    private array $headers;
    private ?string $kernelDir;

    public function __construct($statusCode = 200, $template = 'Example', $headers = [])
    {
        $this->statusCode = $statusCode;
        $this->template = $template;
        $this->headers = $headers;
        $this->kernelDir = null;
    }
 
    public function setKernelDir(string $kernelDir) {
        $this->kernelDir = $kernelDir;
    }

    public function getKernelDir(): ?string {
        return $this->kernelDir;
    }

    public function getTemplate()
    {
        return $this->template;
    }
}