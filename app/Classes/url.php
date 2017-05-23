<?php
namespace App\Classes;

/**
 * Class URL
 * A URL helper class
 * @package App\Classes
 */
class URL
{

    // Stop words are words that appear so frequently in documents and on web pages that search engines would often ignore them when indexing the words on pages.
    private static $stop_words = array("a","an","and","are","the","of","for","in","whats","or","to","how","do","you","your","they","its","if","can","test","does","on","that","was");
    private static $min_word_count = 3;
    private static $slug;

    /**
     * Return a url slug
     * @param $sting
     * @return string
     */
    public static function get_url($sting) {
        self::$slug = self::slug($sting);
        return self::$slug;
    }

    /**
     * Takes a string and turns into SEO friendly slug
     * @param $str
     * @return string
     */
    public static function slug($str) {
        $str = strtolower(strip_tags($str));

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

        // Words not found in self::$stop_words
        $slug_parts = array_diff( explode( '-', $str ), self::$stop_words );

        // Return sanitized string if less/equal self::$min_word_count words after removing stop words
        if ( count( $slug_parts ) <= self::$min_word_count )
            return $str;

        // Turn the sanitized array into a string.
        $slug = join( '-', $slug_parts );
        return $slug;
    }
}