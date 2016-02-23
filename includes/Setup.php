<?php
/**
 *
 * @addtogroup Extensions
 * @author James Montalvo
 * @copyright © 2016 by James Montalvo
 * @licence GNU GPL v3+
 */

namespace ImageList;

class Setup {

	/**
	* Handler for ParserFirstCallInit hook; sets up parser functions.
	* @see http://www.mediawiki.org/wiki/Manual:Hooks/ParserFirstCallInit
	* @param $parser Parser object
	* @return bool true in all cases
	*/
	static function setupParserFunctions ( &$parser ) {

		$imageList = new ImageList( $parser );
		$imageList->setupParserFunction();

		// always return true
		return true;

	}

}