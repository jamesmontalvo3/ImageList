<?php
/**
 *
 * @addtogroup Extensions
 * @author James Montalvo
 * @copyright © 2016 by James Montalvo
 * @licence GNU GPL v3+
 */

namespace ImageList;
use ParserFunctionHelper\ParserFunctionHelper;

class ImageList extends ParserFunctionHelper {


	public $mwImageSize;
	public $extImageHeight;
	public $thumbHeight;

	public function __construct ( \Parser &$parser ) {

		parent::__construct(
			$parser,
			'image_list',
			array( 'images' => '' ),
			array( 'max height' => '' )
		);

	}

	public function render ( \Parser &$parser, $params ) {

		global $wgOut;
		$wgOut->addModules( 'ext.imagelist.base' );

		$imageLines = explode( "\n", $params['images'] );

		$maxHeight = $params['max height'];
		if ( $maxHeight === '' ) {
			$this->mwImageSize = "150x150px";
			$this->extImageHeight = '';
			$this->thumbHeight = 150;
		}
		else {
			$this->mwImageSize = "x{$maxHeight}px";
			$this->extImageHeight = "style='height:{$maxHeight}px;'";
			$this->thumbHeight = $maxHeight;
		}

		$output = '<ul class="gallery">';

		foreach( $imageLines as $imageLine ) {

			$imgArr = explode( '##', $imageLine );

			$img = trim( $imgArr[0] );
			if ( count( $imgArr ) > 1 ) {
				$caption = trim( $imgArr[1] );
			}

			$output .= '<li class="gallerybox" style="background-color:transparent;border-color:transparent;">'
				. '<div class="image-list-thumb image-list-thumb-left">'
					. '<table style="background-color:#f9f9f9;">'
						. '<tr><td style="text-align:center;">';

			if ( strpos( $img, 'File:' ) === 0 ) {
				$output .= $this->getWikiImageContent( $img );
			}
			else {
				$output .= $this->getExternalImageContent( $img );
			}

			$output .= "</td></tr><tr><td style='text-align:center'>$caption</td></tr></table></div></li>";

		}

		$output .= '</ul>';

		return array( $output,  'noparse' => true, 'isHTML' => true ;

	}

	public function getWikiImageContent ( $img ) {

		$filepath = '{{filepath:' . str_replace('File:', '', $img) . '}}';

		return "[[$img|frameless|border|{$this->mwImageSize}|link=$filepath]]"
			. "<br />"
			. "[[:$img|Info Page]]";

	}

	public function getExternalImageContent ( $img ) {

		global $wgImageListPrefixes;

		// check all prefixes to see if this image belongs
		$sourceData = false;
		foreach( $wgImageListPrefixes as $prefix => $meta ) {
			if ( strpos( $img, "$prefix:" ) === 0 ) {
				$sourceData = $meta;
				$id = substr( $img, strlen( $prefix ) );
				break;
			}
		}

		// none found? use the noprefix source
		if ( ! $sourceData ) {
			$sourceData = $wgImageListPrefixes['noprefix'];
			$id = $img;
		}

		$thumbURI = $this->getExternalThumbURI( $sourceData, $id );
		$hiresURI = $this->getExternalHiresURI( $sourceData, $id );


		// Does using this do anything:
		// Xml::element( 'img', $attribs )
		return "<span class='plainlinks'>
				<a href='$hiresURI'><img src='$thumbURI' class='thumbimage image-list' {$this->extImageHeight}/></a>
			</span>
			<br />
			<a href='$hiresURI'>$img</a>";

	}

	public function getExternalThumbURI ( $sourceData, $id ) {
		foreach ( $sourceData['sizes'] as $maxHeight => $uri ) {
			if ( $this->extImageHeight <= $maxHeight ) {
				return str_replace( '__ID__', $id, $uri );
			}
		}
	}

	public function getExternalHiresURI ( $sourceData, $id ) {
		return str_replace( '__ID__', $id, end( $sourceData['sizes'] ) );
	}

}