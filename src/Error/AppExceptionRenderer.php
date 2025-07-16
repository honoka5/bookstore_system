<?php
// src/Error/AppExceptionRenderer.php
namespace App\Error;

use Cake\Error\ExceptionRenderer;
use Cake\Database\Exception\MissingConnectionException;
use Cake\Http\Response;
use Psr\Http\Message\ResponseInterface;

class AppExceptionRenderer extends ExceptionRenderer
{
    public function render(): ResponseInterface
    {
        // DB接続エラーをキャッチ
        if ($this->error instanceof MissingConnectionException) {
            $body = '<script>alert("データベースへの接続ができませんでした。");</script>';
            return (new Response())
                ->withType('text/html')
                ->withStringBody($body);
        }

        // それ以外はデフォルト処理
        return parent::render();
    }
}
