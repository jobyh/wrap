<?php

require_once(dirname(__DIR__) . '/src/wrap.php');

class WrapTestCase extends PHPUnit_Framework_TestCase {

    //
    // It should return the same $string if it is shorter than $length.
    //
    public function test_wrap_output_string_shorter_than_length() {

        $string = 'short string';
        $expected = $string;
        $actual = wrap($string, (strlen($string) + 1));

        $this->assertEquals($expected, $actual);

    }

    //
    // It should return the same $string if it is equal to $length.
    //
    public function test_wrap_output_string_equal_to_length() {

        $string = 'short string';
        $expected = $string;
        $actual = wrap($string, strlen($string));

        $this->assertEquals($expected, $actual);

    }

    //
    // It should return the same $string if all lines are shorter than
    // or equal to $length
    //
    public function test_wrap_output_lines_shorter_than_or_equal_to_length() {

        $string = "one\ntwo\nthree";
        $expected = $string;
        $actual = wrap($string, 5);

        $this->assertEquals($expected, $actual);

    }

    public function test_wrap_output_line_longer_than_length() {

        $string = "This is a long line right here\nThis is not long.";
        $expected = "This is a long line\nright here\nThis is not long.";
        $actual = wrap($string, strlen('This is a long line'));

        $this->assertEquals($expected, $actual);

    }

    //
    // It should break a word which is longer than $length.
    //
    // public function test_wrap_output_word_longer_than_length() {

        // $string = 'Reallylongwordwithnobreaks';
        // $expected = "Reallylongword\nwithnobreaks";
        // $actual = wrap($string, strlen('Reallylongword'));
        //
        // $this->assertEquals($expected, $actual);

    // }

    // public function test_wrap_output_string_longer_than_length() {

//        $string = 'This line is longer than length.';
//        $expected = "This line is\nlonger than length";
//        $actual = wrap($string, strlen('This line is'));
//
//        $this->assertEquals($expected, $actual);

    // }

    // public function test_wrap_output_preserves_whitespace_at_start() {

//        $string = " \n\t Whitespace at start";
//        $expected = " \n\t Whitespace\nat start";
//        $actual = wrap($string, strlen(" \n\t Whitespace"));
//
//        $this->assertEquals($expected, $actual);

    // }

    // public function test_wrap_output_preserves_whitespace_at_end() {

        // TODO.

    // }


    // //
    // // It should throw an exception if parameter $string is wrong type.
    // //
    // public function test_wrap_throws_incorrect_type_string() {
    //
    //     $this->setExpectedException('WrapException');
    //     $actual = wrap(new stdClass(), 7);
    //
    // }
    //
    // //
    // // It should throw an exception if parameter $length is wrong type.
    // //
    // public function test_wrap_throws_incorrect_type_length() {
    //
    //     $this->setExpectedException('WrapException');
    //     $actual = wrap('test', '42');
    //
    // }

}
