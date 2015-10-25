<?php

// Can't namespace functions until PHP 5.6

/**
 * Fold a given string when longer than a given length.
 *
 * Returns $string folded with newline at each $length
 * characters. Newline defaults to the Unix newline \n
 * but this can be made platform-specific (\r\n on Windows)
 * by passing the optional parameter $lineend.
 *
 * This function is not currently multibyte safe.
 *
 * The wrap function will attempt to wrap at word breaks
 * where possible. When folding on a word break all
 * whitespace characters will be replaced with the
 * newline character. Other whitespace will be preserved.
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
        // splitting on word-boundaries.
        $fragments = preg_split('/\b/', $linesplit[0]);

        $wrappedline = '';
        $remaining = '';

        foreach ($fragments as $i => $fragment) {

            if (strlen($wrappedline . $fragment) <= $length) {
                $wrappedline .= $fragment;
                continue;
            }

            // Adding $fragment would exceed $length so break the line.
            $wrappedline = rtrim($wrappedline) . $lineend;
            $remaining = ltrim(implode('', array_slice($fragments, $i)));
            $remaining .= ($islastline) ? '' : $lineend;
            break;

        }

        $wrappedstring .= $wrappedline;

        $string = $islastline ? $remaining : $remaining . $linesplit[1];

    }

    return $wrappedstring;

}
