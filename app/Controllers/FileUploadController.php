<?php
/**
 * Created by PhpStorm.
 * User: owenl
 * Date: 2018-11-12
 * Time: 11:27
 */

namespace Controllers;

use Firebase\JWT\JWT;
use \interop\Container\ContainerInterface;
use PDO;
use \Slim\Http\Request;
use \Slim\Http\Response;
use Slim\Http\StatusCode;
use Slim\Http\UploadedFile;
use utils\SQL;

class FileUploadController
{
    protected $app;
    protected $pdo;


    public function __construct(ContainerInterface $ci)
    {
        $this->app = $ci;
        $this->pdo = $ci->db;
    }

    public function upload(Request $request, Response $response)
    {
        //上传文件名称
        $uploadedFiles = $request->getUploadedFiles();
        if(count($uploadedFiles) == 0) {
            return '';
        }
        $fileNames = [];
        foreach ($uploadedFiles as $uploadedFile) {
            $directory = $_SERVER['DOCUMENT_ROOT']  . '/statics/upload/';
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                $filename = $this->moveUploadedFile($directory, $uploadedFile);
                $fileNames[] = '/statics/upload/'.$filename;
            }
        }
        return $response->withJson($fileNames);

    }

    function moveUploadedFile($directory, UploadedFile $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        try {
            $basename = bin2hex(random_bytes(8));
        } catch (\Exception $e) {
        } // see http://php.net/manual/en/function.random-bytes.php
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }

}