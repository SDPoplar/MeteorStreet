<?php
namespace Mxs\Exceptions\Runtimes;

class ReceiveFileFailedException extends MxsRuntime
{
    public static function saveFailed(string $full_path): static
    {
        return new static('Save file to '.$full_path.' failed', UPLOAD_ERR_OK);
    }

    public static function cannotWrite(): static
    {
        return new static('Failed to temporarily save the file', UPLOAD_ERR_CANT_WRITE);
    }

    public static function unknown(int $reason): static
    {
        return new static('Unknown reason, error code = '.$reason, $reason);
    }

    public static function fileSizeLimitedByIni(int $got_size): static
    {
        $allow = ini_get('post_max_size');
        return new static(
            "The uploaded file exceeds the upload_max_filesize directive in php.ini, max {$allow} allowed, got {$got_size}",
            UPLOAD_ERR_INI_SIZE
        );
    }

    public static function tooLargeForm(): static
    {
        return new static('The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form', UPLOAD_ERR_FORM_SIZE);
    }

    public static function noTempDir(): static
    {
        return new static('Missing a temporary folder', UPLOAD_ERR_NO_TMP_DIR);
    }

    public static function partial(): static
    {
        return new static('The uploaded file was only partially uploaded', UPLOAD_ERR_PARTIAL);
    }

    public static function noFile(): static
    {
        return new static('No file was uploaded', UPLOAD_ERR_NO_FILE);
    }

    public static function extentionRefused(): static
    {
        return new static('A PHP extension stopped the file upload', UPLOAD_ERR_EXTENSION);
    }

    protected function __construct(string $msg, int $file_error_code)
    {
        parent::__construct(
            \SeaDrip\Http\Status::InternalServerError,
            InnerCode::ReceiveFileFailed->value,
            "[{$file_error_code}]{$msg}"
        );
    }
}
