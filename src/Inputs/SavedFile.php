<?php
namespace Mxs\Inputs;

readonly class SavedFile
{
    public string $origin_name;

    public function __construct(
        public string $name,
        public string $ext,
        public string $mime,
        public \SeaDrip\Tools\Path $save_path,
        public int $file_size,
        public string $file_hash,
        ?string $origin_name = null,
    ) {
        $this->origin_name = $origin_name ?? $name;
    }

    public function getFullPath(): string
    {
        return $this->save_path->merge($this->name);
    }

    public function remove(): bool
    {
        return unlink($this->getFullPath());
    }
}
