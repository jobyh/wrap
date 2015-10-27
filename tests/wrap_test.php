<?php

require_once(dirname(__DIR__) . '/src/wrap.php');

/**
 * Tests for wrap().
 */
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
        $actual = wrap($string, strlen('three'));

        $this->assertEquals($expected, $actual);

    }

    //
    // It should wrap lines longer than $length.
    //
    public function test_wrap_output_line_longer_than_length() {

        $string = "This is a long line right here\nThis is a long line right here\nThis is not long.";
        $expected = "This is a long line\nright here\nThis is a long line\nright here\nThis is not long.";
        $actual = wrap($string, strlen('This is a long line'));

        $this->assertEquals($expected, $actual);

    }

    //
    // It should compress whitespace between words when wrapping.
    //
    public function test_wrap_output_whitespace_compressed() {

        $string = "Whitespace between\t \t words\nWhitespace between\r\rwords";
        $expected = "Whitespace between\nwords\nWhitespace between\nwords";
        $actual = wrap($string, strlen("Whitespace between"));

        $this->assertEquals($expected, $actual);

    }

    //
    // It should preserve leading and trailing whitespace.
    //
    public function test_wrap_output_preserve_leading_and_trailing_whitespace() {

        $string = "\t\r  Leading and trailing whitespace\t \t";
        $expected = "\t\r  Leading and trailing\nwhitespace\t \t";
        $actual = wrap($string, strlen("\t\r  Leading and trailing"));

        $this->assertEquals($expected, $actual);

    }

    //
    // It should break words longer than $length.
    //
    public function test_wrap_output_break_word_longer_than_length() {

        $string = "\r\0 \tThisisalongwordlongerthanlength ";
        $expected = "\r\0 \tThisisalongword\nlongerthanlength ";
        $actual = wrap($string, strlen("\r\0 \tThisisalongword"));

        $this->assertEquals($expected, $actual);

    }

    //
    // It should preserve whitespace when wrapping if no words are present.
    //
    public function test_wrap_output_only_preserve_whitespace_without_words() {

        $string = "\t\t\t\t \n\t\t\t\t  ";
        $expected = "\t\t\t\n\t \n\t\t\t\n\t  ";
        $actual = wrap($string, strlen("\t\t\t"));

        $this->assertEquals($expected, $actual);

    }

    //
    // It should preserve whitespace when wrapping single word and whitespace.
    //
    public function test_wrap_output_only_preserve_trailing_whitespace_single_word() {

        $string = "singleword\t\t";
        $expected = "singleword\t\n\t";
        $actual = wrap($string, strlen("singleword\t"));

        $this->assertEquals($expected, $actual);

    }

    //
    // It should use a provided newline character if passed.
    //
    public function test_wrap_output_use_custom_newline() {

        $string = "one\r\none one";
        $expected = "one\r\none\r\none";
        $actual = wrap($string, strlen('one'), "\r\n");

        $this->assertEquals($expected, $actual);

    }

}
