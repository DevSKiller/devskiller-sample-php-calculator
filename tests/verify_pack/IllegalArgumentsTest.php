<?php

namespace verify_pack;

class IllegalArgumentsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function shouldThrowExceptionForDivisionByZero()
    {
        // given
        $calculator = new \Calculator();

        // when
        $calculator->divide(10,0);

        // then
        $this->fail('exception should be thrown');
    }

}