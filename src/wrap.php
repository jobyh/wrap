<?php

// Can't namespace functions until PHP 5.6

/**
 * @copyright 2015 Joby Harding <http://iamjoby.com>
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPL v3 or later.
 */

/**
 * Fold a given string when longer than a given length.
 *
 * Returns $string folded with newline at each $length
 * characters. Newline defaults to the Unix newline \n
 * but this can be made platform-specific (\r\n on Windows)
 * by passing optional parameter $lineend.
 *
 * The wrap function will attempt to wrap at word breaks
 * where possible. When folding on a word break all
 * whitespace characters will be replaced with the
 * newline character. Other whitespace will be preserved.
 *
 * Note: This function is not currently multibyte safe.
 *
 * @param string $string The string to wrap.
 * @param int $length    The maximum length of a line.
 * @param bool $lineend  Optional. Allow line end to be passed
 *                       for portability (e.g. so PHP_EOL may
 *                       be passed in to support Windows).
 * @return string
 */
function wrap($string, $length, $lineend="\n") {

    $wrappedstring  = '';

    while ($string !== '') {

        // This array will contain 1 or 2 items only.
        // The first will be a string up to the first
        // linebreak. If there was a linebreak in $string
        // the second item will be the rest of $string
        // following the linebreak otherwise the first
        // item will contain the whole string and there
        // will be no second item.
        $linesplit = preg_split("/$lineend/", $string, 2);

        $islastline = !array_key_exists(1, $linesplit);
        $linelength = strlen($linesplit[0]);

        // No need to break the line.
        if ($linelength <= $length) {
            $wrappedstring .= $linesplit[0];
            $wrappedstring .= $islastline ? '' : $lineend;
            $string = $islastline ? '' : $linesplit[1];
            continue;
        }

        // Line needs wrapping. Create an array by
        // effectively splitting at word-boundaries.
        // We use this method rather than the regex
        // /\b/ as we want to treat hyphenated words
        // as a single word ('foo-bar' not 'foo' '-' 'bar').
        $fragments = preg_split('/(\s+)/', $linesplit[0], null, PREG_SPLIT_DELIM_CAPTURE);

        $wrappedline = '';
        $remaining = '';

        foreach ($fragments as $i => $fragment) {

            $wrappedlinelength = strlen($wrappedline);
            $fragmentlength = strlen($fragment);

            // We will not exceed $length so add $fragment.
            if (($wrappedlinelength + $fragmentlength) <= $length) {
                $wrappedline .= $fragment;
                continue;
            }

            // $fragment is longer than $length or is just remaining
            // whitespace therefore we must split it.
            if ($fragmentlength > $length || trim($fragment) === '') {
                $charsleft = $length - $wrappedlinelength;
                $wrappedline .= substr($fragment, 0, $charsleft);
                $fragments[$i] = substr($fragment, $charsleft);
            }

            // Break the line.
            $remaining = implode('', array_slice($fragments, $i));

            // If wrapping between words collapse white space.
            if (trim($wrappedline) !== '' && trim($remaining) !== '') {
                $wrappedline = rtrim($wrappedline);
                $remaining = ltrim($remaining);
            }

            $wrappedline .= $lineend;
            $remaining .= ($islastline) ? '' : $lineend;
            break;

        }

        $wrappedstring .= $wrappedline;

        $string = $islastline ? $remaining : $remaining . $linesplit[1];

    }

    return $wrappedstring;

}
