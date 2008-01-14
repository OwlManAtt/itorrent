<?php

// +----------------------------------------------------------------------+
// | Decode and Encode data in Bittorrent format                          |
// +----------------------------------------------------------------------+
// | Copyright (C) 2004-2005 Markus Tacker <m@tacker.org>                 |
// +----------------------------------------------------------------------+
// | This library is free software; you can redistribute it and/or        |
// | modify it under the terms of the GNU Lesser General Public           |
// | License as published by the Free Software Foundation; either         |
// | version 2.1 of the License, or (at your option) any later version.   |
// |                                                                      |
// | This library is distributed in the hope that it will be useful,      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU    |
// | Lesser General Public License for more details.                      |
// |                                                                      |
// | You should have received a copy of the GNU Lesser General Public     |
// | License along with this library; if not, write to the                |
// | Free Software Foundation, Inc.                                       |
// | 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA               |
// +----------------------------------------------------------------------+

/**
* Encode/Decode data in the Bencode format.
*
* Based on
*   Original Python implementation by Petru Paler <petru@paler.net>
*   PHP translation by Gerard Krijgsman <webmaster@animesuki.com>
*   Gerard's regular expressions removed by Carl Ritson <critson@perlfu.co.uk>
* BEncoding is a simple, easy to implement method of associating
* data types with information in a file. The values in a torrent
* file are bEncoded.
* There are 4 different data types that can be bEncoded:
* Integers, Strings, Lists and Dictionaries.
* [http://www.monduna.com/bt/faq.html]
*
* @package Bencode
* @category File
* @author Markus Tacker <m@tacker.org>
* @version $Id: Encode.php 76 2007-08-25 15:11:16Z m $
*/

/**
* Include required classes
*/
require_once 'Exception.php';

/**
* Encode/Decode data in the Bencode format.
*
* Based on
*   Original Python implementation by Petru Paler <petru@paler.net>
*   PHP translation by Gerard Krijgsman <webmaster@animesuki.com>
*   Gerard's regular expressions removed by Carl Ritson <critson@perlfu.co.uk>
* BEncoding is a simple, easy to implement method of associating
* data types with information in a file. The values in a torrent
* file are bEncoded.
* There are 4 different data types that can be bEncoded:
* Integers, Strings, Lists and Dictionaries.
* [http://www.monduna.com/bt/faq.html]
*
* @package Bencode
* @category File
* @author Markus Tacker <m@tacker.org>
*/
class Bencode 
{
    /**
    * Encode a var in BEncode format
    *
    * @param mixed    Variable to encode
    * @return string
    * @throws Bencode_Exception if unsupported type should be encoded
    */
    function encode($mixed)
    {
        switch (gettype($mixed)) {
        case is_null($mixed):
            return $this->encode_string('');
        case 'string':
            return $this->encode_string($mixed);
        case 'integer':
        case 'double':
            return  $this->encode_int(round($mixed));
        case 'array':
            return $this->encode_array($mixed);
        default:
	    throw new Bencode_Exception('Unsupported type. Variable must be one of \'string\', \'integer\', \'double\' or \'array\'', Bencode_Exception::encode);
        }
    }

    /**
    * BEncodes a string
    *
    * Strings are prefixed with their length followed by a colon.
    * For example, "Monduna" would bEncode to 7:Monduna and "BitTorrents"
    * would bEncode to 11:BitTorrents.
    *
    * @param string
    * @return string
    */
    function encode_string($str)
    {
        return strlen($str) . ':' . $str;
    }

    /**
    * BEncodes a integer
    *
    * Integers are prefixed with an i and terminated by an e. For
    * example, 123 would bEcode to i123e, -3272002 would bEncode to
    * i-3272002e.
    *
    * @param int
    * @return string
    */
    function encode_int($int)
    {
        return 'i' . $int . 'e';
    }

    /**
    * BEncodes an array
    * This code assumes arrays with purely integer indexes are lists,
    * arrays which use string indexes assumed to be dictionaries.
    *
    * Dictionaries are prefixed with a d and terminated by an e. They
    * are similar to list, except that items are in key value pairs. The
    * dictionary {"key":"value", "Monduna":"com", "bit":"Torrents", "number":7}
    * would bEncode to d3:key5:value7:Monduna3:com3:bit:8:Torrents6:numberi7ee
    *
    * Lists are prefixed with a l and terminated by an e. The list
    * should contain a series of bEncoded elements. For example, the
    * list of strings ["Monduna", "Bit", "Torrents"] would bEncode to
    * l7:Monduna3:Bit8:Torrentse. The list [1, "Monduna", 3, ["Sub", "List"]]
    * would bEncode to li1e7:Mondunai3el3:Sub4:Listee
    *
    * @param array
    * @return string
    */
    function encode_array(array $array)
    {
        // Check for strings in the keys
        $isList = true;
        foreach (array_keys($array) as $key) {
            if (!is_int($key)) {
                $isList = false;
                break;
            }
        }
        if ($isList) {
            // Wie build a list
            ksort($array, SORT_NUMERIC);
            $return = 'l';
            foreach ($array as $val) {
                $return .= $this->encode($val);
            }
            $return .= 'e';
        } else {
            // We build a Dictionary
            ksort($array, SORT_STRING);
            $return = 'd';
            foreach ($array as $key => $val) {
                $return .= $this->encode(strval($key));
                $return .= $this->encode($val);
            }
            $return .= 'e';
        }
        return $return;
    }
    /**
    * @var string   Source string
    */
    protected $source = '';

    /**
    * @var int      Source length
    */
    protected $source_length = 0;

    /**
    * @var int      Current position of the string
    */
    protected $position = 0;

    /**
    * @var array    Decoded data from Bencode_Decode::decodeFile()
    */
    protected $decoded = array();

    /**
    * Decode a Bencoded string
    *
    * @param string
    * @return mixed
    * @throws Bencode_Exception if decoded data contains trailing garbage
    */
    function decode($str)
    {
        $this->source = $str;
        $this->position  = 0;
        $this->source_length = strlen($this->source);
        $result = $this->bdecode();
        if ($this->position < $this->source_length) {
			throw new Bencode_Exception('Trailing garbage in file.', Bencode_Exception::decode);
        }
        return $result;
    }

    /**
    * Decode a BEncoded String
    *
    * @return mixed    Returns the representation of the data in the BEncoded string or false on error
    */
    protected function bdecode()
    {
        switch ($this->getChar()) {
        case 'i':
            $this->position++;
            return $this->decode_int();
            break;
        case 'l':
            $this->position++;
            return $this->decode_list();
            break;
        case 'd':
            $this->position++;
            return $this->decode_dict();
            break;
        default:
            return $this->decode_string();
        }
    }

    /**
    * Decode a BEncoded dictionary
    *
    * Dictionaries are prefixed with a d and terminated by an e. They
    * are similar to list, except that items are in key value pairs. The
    * dictionary {"key":"value", "Monduna":"com", "bit":"Torrents", "number":7}
    * would bEncode to d3:key5:value7:Monduna3:com3:bit:8:Torrents6:numberi7ee
    *
    * @return array
    * @throws Bencode_Exception if bencoded dictionary contains invalid data
    */
    protected function decode_dict()
    {
        $return = array();
        $ended = false;
        $lastkey = NULL;
        while ($char = $this->getChar()) {
            if ($char == 'e') {
                $ended = true;
                break;
            }
            if (!ctype_digit($char)) {
				throw new Bencode_Exception('Invalid dictionary key.', Bencode_Exception::decode);
            }
            $key = $this->decode_string();
            if (isset($return[$key])) {
                throw new Bencode_Exception('Duplicate dictionary key.', Bencode_Exception::decode);
            }
            if ($key < $lastkey) {
                throw new Bencode_Exception('Missorted dictionary key.', Bencode_Exception::decode);
            }
            $val = $this->bdecode();
            if ($val === false) {
                throw new Bencode_Exception('Invalid value.', Bencode_Exception::decode);
            }
            $return[$key] = $val;
            $lastkey = $key;
        }
        if (!$ended) {
            throw new Bencode_Exception('Unterminated dictionary.', Bencode_Exception::decode);
        }
        $this->position++;
        return $return;
    }

    /**
    * Decode a BEncoded string
    *
    * Strings are prefixed with their length followed by a colon.
    * For example, "Monduna" would bEncode to 7:Monduna and "BitTorrents"
    * would bEncode to 11:BitTorrents.
    *
    * @return string|false
    * @throws Bencode_Exception if bencoded data is invalid
    */
    protected function decode_string()
    {
        // Check for bad leading zero
        if (substr($this->source, $this->position, 1) == '0' and
        substr($this->source, $this->position + 1, 1) != ':') {
			throw new Bencode_Exception('Leading zero in string length.', Bencode_Exception::decode);
        }
        // Find position of colon
        // Supress error message if colon is not found which may be caused by a corrupted or wrong encoded string
        if (!$pos_colon = @strpos($this->source, ':', $this->position)) {
            throw new Bencode_Exception('Colon not found.', Bencode_Exception::decode);
        }
        // Get length of string
        $str_length = intval(substr($this->source, $this->position, $pos_colon));
        if ($str_length + $pos_colon + 1 > $this->source_length) {
            throw new Bencode_Exception('Input too short for string length.', Bencode_Exception::decode);
        }
        // Get string
        if ($str_length === 0) {
            $return = '';
        } else {
            $return = substr($this->source, $pos_colon + 1, $str_length);
        }
        // Move Pointer after string
        $this->position = $pos_colon + $str_length + 1;
        return $return;
    }

    /**
    * Decode a BEncoded integer
    *
    * Integers are prefixed with an i and terminated by an e. For
    * example, 123 would bEcode to i123e, -3272002 would bEncode to
    * i-3272002e.
    *
    * @return int
    * @throws Bencode_Exception if bencoded data is invalid
    */
    protected function decode_int()
    {
        $pos_e  = strpos($this->source, 'e', $this->position);
        $p = $this->position;
        if ($p === $pos_e) {
            throw new Bencode_Exception('Empty integer.', Bencode_Exception::decode);
        }
        if (substr($this->source, $this->position, 1) == '-') $p++;
        if (substr($this->source, $p, 1) == '0' and
        ($p != $this->position or $pos_e > $p+1)) {
            throw new Bencode_Exception('Leading zero in integer.', Bencode_Exception::decode);
        }
        for ($i = $p; $i < $pos_e-1; $i++) {
            if (!ctype_digit(substr($this->source, $i, 1))) {
                throw new Bencode_Exception('Non-digit characters in integer.', Bencode_Exception::decode);
            }
        }
        // The return value showld be automatically casted to float if the intval would
        // overflow. The "+ 0" accomplishes exactly that, using the internal casting
        // logic of PHP
        $return = substr($this->source, $this->position, $pos_e - $this->position) + 0;
        $this->position = $pos_e + 1;
        return $return;
    }

    /**
    * Decode a BEncoded list
    *
    * Lists are prefixed with a l and terminated by an e. The list
    * should contain a series of bEncoded elements. For example, the
    * list of strings ["Monduna", "Bit", "Torrents"] would bEncode to
    * l7:Monduna3:Bit8:Torrentse. The list [1, "Monduna", 3, ["Sub", "List"]]
    * would bEncode to li1e7:Mondunai3el3:Sub4:Listee
    *
    * @return array
    * @throws Bencode_Exception if bencoded data is invalid
    */
    protected function decode_list()
    {
        $return = array();
        $char = $this->getChar();
        $p1 = $p2 = 0;
        if ($char === false) {
            throw new Bencode_Exception('Unterminated list.', Bencode_Exception::decode);
        }
        while ($char !== false && substr($this->source, $this->position, 1) != 'e') {
            $p1 = $this->position;
            $val = $this->bdecode();
            $p2 = $this->position;
            // Empty does not work here
            if($p1 == $p2)  {
                throw new Bencode_Exception('Unterminated list.', Bencode_Exception::decode);
            }
            $return[] = $val;
        }
        $this->position++;
        return $return;
    }

    /**
    * Get the char at the current position
    *
    * @return string|false
    */
    protected function getChar()
    {
        if (empty($this->source)) return false;
        if ($this->position >= $this->source_length) return false;
        return substr($this->source, $this->position, 1);
    }
}
?>
