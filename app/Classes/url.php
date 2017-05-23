<?php
namespace App\Classes;


/**
 * Class URL
 * URL helper class
 * @package App\Classes
 */
class URL
{

    private static $stop_words = array("a","an","and","are","the","of","for","in","whats","or","to","how","do","you","your","they","its","if","can","test","does","on","that","was");
    private static $min_word_count = 3;

    /**
     * Takes a string and turns into SEO friendly slug
     * @param $string
     * @return string
     */
    public static function get_url($string) {
        $string = strtolower(strip_tags($string));

        // Preserve escaped octets.
        $string = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $string);

        // Remove percent signs that are not part of an octet.
        $string = str_replace('%', '', $string);

        // Restore octets.
        $string = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $string);
        $string = preg_replace('/&.+?;/', '', $string); // kill entities
        $string = str_replace('.', '-', $string);
        $string = preg_replace('/[^%a-z0-9 _-]/', '', $string);
        $string = preg_replace('/\s+/', '-', $string);
        $string = preg_replace('|-+|', '-', $string);
        $string = trim($string, '-');

        // Words not found in self::$stop_words
        $slug_parts = array_diff( explode( '-', $string ), self::$stop_words );

        // Return sanitized string if less/equal self::$min_word_count words after removing stop words
        if ( count( $slug_parts ) <= self::$min_word_count ) {
            return $string;
        }

        // Turn the sanitized array into a string.
        $slug = join( '-', $slug_parts );
        return $slug;
    }
}