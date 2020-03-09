<?php
/**
 * Created by PhpStorm.
 * User: mohit
 * Date: 14/2/20
 * Time: 5:23 PM
 */

namespace App\MessageHandler;


use App\Message\AddPonkaToImage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddPonkaToImageHandler implements MessageHandlerInterface
{
        public function __invoke(AddPonkaToImage $addPonkaToImage)
        {
            dump($addPonkaToImage);exit();
        }
}
