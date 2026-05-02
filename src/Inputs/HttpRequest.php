<?php
namespace Mxs\Inputs;

use SeaDrip\Tools\Path;
use Mxs\Exceptions\Runtimes\ReceiveFileFailedException;

class HttpRequest extends RootInput
{
    public function __construct()
    {
        //  var_dump($_SERVER, $_ENV); exit;
        parent::__construct($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
        $protocal_parts = explode('/', $_SERVER['SERVER_PROTOCOL']);
        $this->protocal = $protocal_parts[0];
        $this->protocal_version = $protocal_parts[1];
    }

    #[\Override]
    public function input(string $column, mixed $def_val = null)
    {
        return $_POST[$column] ?? $_GET[$column] ?? $def_val;
    }

    public function file(string $column, Path $save_path, ?callable $make_name = null): SavedFile
    {
        $save_path->exists() or $save_path->create() or throw new \Mxs\Exceptions\Runtimes\CreatePathFailed($save_path);
        $save_path->isWritable() or throw new \Mxs\Exceptions\Runtimes\NoWritePermission($save_path);
        array_key_exists($column, $_FILES) or throw new \Mxs\Exceptions\Runtimes\InvalidInput($column);
        $uploaded = $_FILES[$column];
        if ($uploaded['error'] !== UPLOAD_ERR_OK) {
            throw match($uploaded['error']) {
                UPLOAD_ERR_INI_SIZE => ReceiveFileFailedException::fileSizeLimitedByIni($uploaded['size']),
                UPLOAD_ERR_FORM_SIZE => ReceiveFileFailedException::tooLargeForm(),
                UPLOAD_ERR_PARTIAL => ReceiveFileFailedException::partial(),
                UPLOAD_ERR_NO_FILE => ReceiveFileFailedException::noFile(),
                UPLOAD_ERR_NO_TMP_DIR => ReceiveFileFailedException::noTempDir(),
                UPLOAD_ERR_CANT_WRITE => ReceiveFileFailedException::cannotWrite(),
                UPLOAD_ERR_EXTENSION => ReceiveFileFailedException::extentionRefused(),
                default => ReceiveFileFailedException::unknown($uploaded['error']),
            };
        }
        $file_ext = array_last(explode('.', $uploaded['name']));
        $file_hash = md5_file($uploaded['tmp_name']);
        $file_name = is_null($make_name) ? "{$file_hash}.{$file_ext}" : $make_name($file_hash, $file_ext);
        $full_file = $save_path->merge($file_name);
        move_uploaded_file($uploaded['tmp_name'], $full_file) or throw ReceiveFileFailedException::saveFailed($full_file);
        return new SavedFile($file_name, $file_ext, $uploaded['type'], $save_path, $uploaded['size'], $file_hash, $uploaded['name']);
    }

    public readonly string $protocal;
    public readonly string $protocal_version;
}
