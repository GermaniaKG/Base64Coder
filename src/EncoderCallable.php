<?php
namespace Germania\Base64Coder;

class EncoderCallable extends CallableCoderAbstract {

    public function __invoke($selector, $token) {
        return $this->coder->encode($selector, $token);
    }
}
