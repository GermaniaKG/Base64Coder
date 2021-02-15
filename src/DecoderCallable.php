<?php
namespace Germania\Base64Coder;


class DecoderCallable extends CallableCoderAbstract {

    public function __invoke($encrypted) {
        return $this->coder->decode($encrypted);
    }
}
