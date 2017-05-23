<?php
namespace App\Classes;

/**
 * Class URL
 * A URL helper class
 * @package App\Classes
 */
class URL
{

    // Remove stop words from string?
    private static $remove_stop_words = true;

    // Minimum number of words in slug to remove stop words from
    private static $min_word_count = 3;

    // For SEO purposes, these are extremely common words that most search engines skip over in order to save space in their databases.
    private static $stop_words = array("a","an","and","are","the","of","for","in","whats","or","to","how","do","you","your","they","its","if","can","test","does","on","that","was");

    private static $slug;
    private static $string;

    /**
     * Return a url slug
     * @param $sting
     * @return string
     */
    public static function get_slug($sting) {
        self::$string = $sting;

        if (self::$remove_stop_words) {
            self::$slug = self::clean_string(self::$string);
            self::$slug = self::remove_stop_words(self::$slug);
            return self::$slug;
        } else {
            self::$slug = self::clean_slug($sting);
            return self::$slug;
        }
    }

    /**
     * Takes a string and turns into SEO friendly slug
     * @param $str
     * @return string
     */
    private static function clean_string($str) {
        $str = strtolower(strip_tags(trim($str)));

        // Preserve escaped octets.
        $str = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $str);

        // Remove percent signs that are not part of an octet.
        $str = str_replace('%', '', $str);

        // Restore octets.
        $str = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $str);
        $str = preg_replace('/&.+?;/', '', $str); // kill entities
        $str = str_replace('.', '-', $str);

        $str = preg_replace('/[^%a-z0-9 _-]/', '', $str);
        $str = preg_replace('/\s+/', '-', $str);
        $str = preg_replace('|-+|', '-', $str);
        $str = trim($str, '-');

        return $str;
    }

    private static function remove_stop_words($str) {

        // Array of words found not part of self::$stop_words ,will eventually be our return string
        $slug_parts = array_diff( explode( '-', $str ), self::$stop_words );

        // Return sanitized string if less/equal self::$min_word_count words after removing stop words
        if ( count( $slug_parts ) <= self::$min_word_count )
            return $str;

        // Turn the sanitized array into a string.
        $slug = join( '-', $slug_parts );

        return $slug;
    }
}