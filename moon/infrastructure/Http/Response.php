<?php

namespace Moon\infrastructure\Http;

class Response {

    private int $statusCode;
    private string $template;
    private Headers $headers;
    private ?string $kernelDir = null;

    public function __construct($statusCode = 200, $template = 'Example')
    {
        $this->statusCode = $statusCode;
        $this->template = $template;
    }
    public function getTemplate()
    {
        return $this->template;
    }

    public function setKernelDir(string $kernelDir) {
        $this->kernelDir = $kernelDir;
    }

    public function getKernelDir(): ?string {
        return $this->kernelDir;
    }

    public function setTemplate(string $template) {
        $this->template = $template;
    }
}