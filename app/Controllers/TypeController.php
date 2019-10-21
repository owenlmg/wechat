<?php
/**
 * Created by PhpStorm.
 * User: owenl
 * Date: 2018-11-12
 * Time: 11:27
 */

namespace Controllers;


use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;

class TypeController extends BaseController
{
    public $searchColumns = ['name_', 'desc_'];
    public $table = 't_type';
    public $tableKeys = ['name_', 'desc_', 'icon', 'url_'];
    public $tableKeysCanUpdate = ['name_', 'desc_', 'icon', 'url_'];
    public $uniqueKeys = ['name_'];

//    public function upload(Request $request, Response $response)
//    {
//        //上传文件名称
//        $uploadedFiles = $request->getUploadedFiles();
//        if(count($uploadedFiles) == 0) {
//            return '';
//        }
//        $uploadedFile = $uploadedFiles['icon'];
//        $directory = $_SERVER['DOCUMENT_ROOT']  . '/statics/upload/';
//        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
//            $filename = $this->moveUploadedFile($directory, $uploadedFile);
//            return $response->withJson('/statics/upload/'.$filename);
//        }
//        return $response->withJson('文件上传错误');
//
//    }
//
//    function moveUploadedFile($directory, UploadedFile $uploadedFile)
//    {
//        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
//        try {
//            $basename = bin2hex(random_bytes(8));
//        } catch (\Exception $e) {
//        } // see http://php.net/manual/en/function.random-bytes.php
//        $filename = sprintf('%s.%0.8s', $basename, $extension);
//
//        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
//
//        return $filename;
//    }
}