<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Dirk Wenzel <wenzel@webfox01.de>
 *  			
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Test case for class Tx_Ajaxmap_Domain_Model_Content.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Ajax Map
 *
 * @author Dirk Wenzel <wenzel@webfox01.de>
 */
class Tx_Ajaxmap_Domain_Model_ContentTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Ajaxmap_Domain_Model_Content
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Ajaxmap_Domain_Model_Content();
	}

	public function tearDown() {
		unset($this->fixture);
	}
	
	/**
	 * @test
	 */
	public function getCrdateForDateTimeReturnsInitialNull() {
		$this->assertNull(
			$this->fixture->getCrdate()		
		);
	}

	/**
	 * @test
	 */
	public function setCrdateForDateTimeSetsCrdate() {
		$date = new DateTime();
		$this->fixture->setCrdate($date);
		$this->assertSame(
				$this->fixture->getCrdate(),
				$date
		);
	}

	/**
	 * @test
	 */
	public function getTstampForDateTimeReturnsInitialNull() {
		$this->assertNull(
				$this->fixture->getTstamp()
		);
	}

	/**
	 * @test
	 */
	public function setTstampForDateTimeSetsTstamp() {
		$date = date("Y-m-d H:i:s");
		$this->fixture->setTstamp($date);
		$this->assertSame(
				$this->fixture->getTstamp(),
				$date
		);
	}

	/**
	 * @test
	 */
	public function getCTypeForStringReturnsInitialNull() {
		$this->assertNull(
				$this->fixture->getCType()
		);
	}

	/**
	 * @test
	 */
	public function setCTypeForStringSetsCType() {
		$this->fixture->setCType('aloha');
		$this->assertSame(
				$this->fixture->getCType(),
				'aloha'
		);
	}

	/**
	 * @test
	 */
	public function getHeaderForStringReturnsInitialNull() {
		$this->assertNull(
				$this->fixture->getHeader()
		);
	}

	/**
	 * @test
	 */
	public function setHeaderForStringSetsHeader() {
		$this->fixture->setHeader('aloha');
		$this->assertSame(
				$this->fixture->getHeader(),
				'aloha'
		);
	}

	/**
	 * @test
	 */
	public function getHeaderPositionForStringReturnsInitialNull() {
		$this->assertNull(
				$this->fixture->getHeaderPosition()
		);
	}

	/**
	 * @test
	 */
	public function setHeaderPositionForStringSetsHeaderPosition() {
		$this->fixture->setHeaderPosition('aloha');
		$this->assertSame(
				$this->fixture->getHeaderPosition(),
				'aloha'
		);
	}

	/**
	 * @test
	 */
	public function getBodytextForStringReturnsInitialNull() {
		$this->assertNull(
				$this->fixture->getBodytext()
		);
	}

	/**
	 * @test
	 */
	public function setBodytextForStringSetsBodytext() {
		$this->fixture->setBodytext('aloha');
		$this->assertSame(
				$this->fixture->getBodytext(),
				'aloha'
		);
	}

	/**
	 * @test
	 */
	public function getImageForStringReturnsInitialNull() {
		$this->assertNull(
				$this->fixture->getImage()
		);
	}

	/**
	 * @test
	 */
	public function setImageForStringSetsImage() {
		$this->fixture->setImage('aloha');
		$this->assertSame(
				$this->fixture->getImage(),
				'aloha'
		);
	}


	/**
	 * @test
	 */
	public function getImagewidthForStringReturnsInitialNull() {
		$this->assertNull(
				$this->fixture->getImagewidth()
		);
	}

	/**
	 * @test
	 */
	public function setImagewidthForStringSetsImagewidth() {
		$this->fixture->setImagewidth('aloha');
		$this->assertSame(
				$this->fixture->getImagewidth(),
				'aloha'
		);
	}

	/**
	 * @test
	 */
	public function getImagecolsForIntegerReturnsInitialNull() {
		$this->assertNull(
				$this->fixture->getImagecols()
		);
	}

	/**
	 * @test
	 */
	public function setImagecolsForIntegerSetsImagecols() {
		$this->fixture->setImagecols(3);
		$this->assertSame(
				$this->fixture->getImagecols(),
				3
		);
	}

	/**
	 * @test
	 */
	public function getImageorientForIntegerReturnsInitialNull() {
		$this->assertNull(
				$this->fixture->getImageorient()
		);
	}

	/**
	 * @test
	 */
	public function setImagorientForIntegerSetsImageorient() {
		$this->fixture->setImageorient(3);
		$this->assertSame(
				$this->fixture->getImageorient(),
				3
		);
	}

	/**
	 * @test
	 */
	public function getImagecaptionForStringReturnsInitialNull() {
		$this->assertNull(
				$this->fixture->getImagecaption()
		);
	}

	/**
	 * @test
	 */
	public function setImagecaptionForStringSetsImagecaption() {
		$this->fixture->setImagecaption('aloha');
		$this->assertSame(
				$this->fixture->getImagecaption(),
				'aloha'
		);
	}

	/**
	 * @test
	 */
	public function getImageborderForIntegerReturnsInitialNull() {
		$this->assertNull(
				$this->fixture->getImageborder()
		);
	}

	/**
	 * @test
	 */
	public function setImageborderForIntegerSetsImageborder() {
		$this->fixture->setImageborder(3);
		$this->assertSame(
				$this->fixture->getImageborder(),
				3
		);
	}
	
	/**
	 * @test
	 */
	public function getMediaForStringReturnsInitialNull() {
		$this->assertNull(
				$this->fixture->getMedia()
		);
	}

	/**
	 * @test
	 */
	public function setMediaForStringSetsMedia() {
		$this->fixture->setMedia('aloha');
		$this->assertSame(
				$this->fixture->getMedia(),
				'aloha'
		);
	}

	/**
	 * @test
	 */
	public function getLayoutForStringReturnsInitialNull() {
		$this->assertNull(
				$this->fixture->getLayout()
		);
	}

	/**
	 * @test
	 */
	public function setLayoutForStringSetsLayout() {
		$this->fixture->setLayout('aloha');
		$this->assertSame(
				$this->fixture->getLayout(),
				'aloha'
		);
	}


	/**
	 * @test
	 */
	public function getColsForIntegerReturnsInitialNull() {
		$this->assertNull(
				$this->fixture->getCols()
		);
	}

	/**
	 * @test
	 */
	public function setColsForIntegerSetsCols() {
		$this->fixture->setCols(3);
		$this->assertSame(
				$this->fixture->getCols(),
				3
		);
	}

	/**
	 * @test
	 */
	public function getSubheaderForStringReturnsInitialNull() {
		$this->assertNull(
				$this->fixture->getSubheader()
		);
	}

	/**
	 * @test
	 */
	public function setSubheaderForStringSetsSubheader() {
		$this->fixture->setSubheader('aloha');
		$this->assertSame(
				$this->fixture->getSubheader(),
				'aloha'
		);
	}

	/**
	 * @test
	 */
	public function getHeaderLinkForStringReturnsInitialNull() {
		$this->assertNull(
				$this->fixture->getHeaderLink()
		);
	}

	/**
	 * @test
	 */
	public function setHeaderLinkForStringSetsHeaderLink() {
		$this->fixture->setHeaderLink('aloha');
		$this->assertSame(
				$this->fixture->getHeaderLink(),
				'aloha'
		);
	}

	/**
	 * @test
	 */
	public function getImageLinkForStringReturnsInitialNull() {
		$this->assertNull(
				$this->fixture->getImageLink()
		);
	}

	/**
	 * @test
	 */
	public function setImageLinkForStringSetsImageLink() {
		$this->fixture->setImageLink('aloha');
		$this->assertSame(
				$this->fixture->getImageLink(),
				'aloha'
		);
	}

	/**
	 * @test
	 */
	public function getImageZoomForStringReturnsInitialNull() {
		$this->assertNull(
				$this->fixture->getImageZoom()
		);
	}

	/**
	 * @test
	 */
	public function setImageZoomForStringSetsImageZoom() {
		$this->fixture->setImageZoom('aloha');
		$this->assertSame(
				$this->fixture->getImageZoom(),
				'aloha'
		);
	}

	/**
	 * @test
	 */
	public function getAltTextForStringReturnsInitialNull() {
		$this->assertNull(
				$this->fixture->getAltText()
		);
	}

	/**
	 * @test
	 */
	public function setAltTextForStringSetsAltText() {
		$this->fixture->setAltText('aloha');
		$this->assertSame(
				$this->fixture->getAltText(),
				'aloha'
		);
	}

	/**
	 * @test
	 */
	public function getTitleTextForStringReturnsInitialNull() {
		$this->assertNull(
				$this->fixture->getTitleText()
		);
	}

	/**
	 * @test
	 */
	public function setTitleTextForStringSetsTitleText() {
		$this->fixture->setTitleText('aloha');
		$this->assertSame(
				$this->fixture->getTitleText(),
				'aloha'
		);
	}

	/**
	 * @test
	 */
	public function getHeaderLayoutForStringReturnsInitialNull() {
		$this->assertNull(
				$this->fixture->getHeaderLayout()
		);
	}

	/**
	 * @test
	 */
	public function setHeaderLayoutForStringSetsHeaderLayout() {
		$this->fixture->setHeaderLayout('aloha');
		$this->assertSame(
				$this->fixture->getHeaderLayout(),
				'aloha'
		);
	}

	/**
	 * @test
	 */
	public function getListTypeForStringReturnsInitialNull() {
		$this->assertNull(
				$this->fixture->getListType()
		);
	}

	/**
	 * @test
	 */
	public function setListTypeForStringSetsListType() {
		$this->fixture->setListType('aloha');
		$this->assertSame(
				$this->fixture->getListType(),
				'aloha'
		);
	}

}
?>

