<?php


namespace App\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ExceptionNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = array())
    {
        return array('status_code' => 'foo');
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof \My\Exception;
    }
}