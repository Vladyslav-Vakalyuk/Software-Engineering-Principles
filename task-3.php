<?php
/**
 * @param $a
 *
 * @return string
 */
function planeSeat( $a ) {

	$planeSeatManager = new SeatManager();
	$planeSeatChecker = new SeatChecker();
	$planeSeatChecker->setSeatManager( $planeSeatManager );

	return $planeSeatChecker->init( $a );
}

/**
 * Class SeatChecker
 */
class SeatChecker {

	/**
	 * Seat Manager.
	 *
	 * @var SeatManagerInterface
	 */
	protected $seatManager;

	/**
	 * Seat Place.
	 *
	 * @var string
	 */
	protected $seatPlace;

	/**
	 * Seat number.
	 *
	 * @var string
	 */
	protected $seatNumber;

	/**
	 * Seat letter.
	 *
	 * @var string
	 */
	protected $seatLetter;

	/**
	 * SeatPlace.
	 *
	 * @param $seatPlace
	 *
	 * @return string
	 */
	public function init( $seatPlace ) {
		$this->seatPlace = $seatPlace;

		if ( !$this->checkPlaceByNumber() || !$this->checkPlaceByLetter() ) {
			return 'No Seat!!';
		}

		return $this->getSeatNumber() . '-' . $this->getSeatLetter();
	}

	/**
	 * GetSeatLetter.
	 *
	 * @return mixed
	 */
	protected function getSeatLetter() {
		return $this->seatLetter;
	}

	/**
	 * GetSeatNumber.
	 *
	 * @return mixed
	 */
	protected function getSeatNumber() {
		return $this->seatNumber;
	}

	/**
	 * SetSeatLetter.
	 *
	 * @param $seatLetter
	 */
	protected function setSeatLetter( $seatLetter ) {
		$this->seatLetter = $seatLetter;
	}

	/**
	 * SetSeatNumber.
	 *
	 * @param $seatNumber
	 */
	protected function setSeatNumber( $seatNumber ) {
		$this->seatNumber = $seatNumber;
	}

	/**
	 * SetSeatManager.
	 *
	 * @param SeatManagerInterface $seatManager
	 */
	public function setSeatManager( SeatManagerInterface $seatManager ) {
		$this->seatManager = $seatManager;
	}

	/**
	 * GetSeatPlace.
	 *
	 * @return mixed
	 */
	public function getSeatPlace() {
		return $this->seatPlace;
	}

	/**
	 * checkPlaceByLetter.
	 *
	 * @return bool
	 */
	public function checkPlaceByLetter() {
		$seat_letter = $this->getSeatPlace();
		$arraySearch = [
			$this->seatManager->getSeatLeftLetter(),
			$this->seatManager->getSeatMiddleLetter(),
			$this->seatManager->getSeatRightLetter(),
		];

		foreach ( $arraySearch as $keyLetter => $letter ) {
			foreach ( $letter as $key => $value ) {

				$resultCompareByLetter = $this->compareByLetter( $seat_letter, $value );
				if ( $resultCompareByLetter ) {
					$this->setSeatLetter( $key );

					return true;
				}
			}
		}

		return false;
	}

	/**
	 * CompareByLetter.
	 *
	 * @param $seatLetter
	 * @param $letterCompare
	 *
	 * @return bool
	 */
	public function compareByLetter( $seatLetter, $letterCompare ) {
		return strpos( $seatLetter, $letterCompare[0] ) > 0 || strpos( $seatLetter, $letterCompare[1] ) > 0 ? true : false;
	}

	/**
	 * CheckPlaceByNumber.
	 *
	 * @return bool
	 */
	public function checkPlaceByNumber() {
		$seatNumber = intval( $this->getSeatPlace() );

		$arraySearch = [
			$this->seatManager->getSeatFrontNumber(),
			$this->seatManager->getSeatMiddleNumber(),
			$this->seatManager->getSeatBackNumber(),
		];

		foreach ( $arraySearch as $keyNumbers => $numbersRadius ) {
			foreach ( $numbersRadius as $key => $value ) {
				$resultCompareByNumber = $this->compareByNumber( $seatNumber, $value );

				if ( $resultCompareByNumber ) {
					$this->setSeatNumber( $key );

					return true;
				}
			}
		}

		return false;
	}

	/**
	 * CompareByNumber.
	 *
	 * @param $seatNumber
	 * @param $numbersRadius
	 *
	 * @return bool
	 */
	protected function compareByNumber(
		$seatNumber, $numbersRadius
	) {
		return $seatNumber >= $numbersRadius[0] && $seatNumber <= $numbersRadius[1];
	}
}

/**
 * Class SeatManager
 */
class SeatManager implements SeatManagerInterface {

	/**
	 * SatLeftLetter.
	 *
	 * @var string[][]
	 */
	private $seatLeftLetter = [ 'Front' => [ 'A', 'C' ] ];

	/**
	 * SeatLeftLetter.
	 *
	 * @var string[][]
	 */
	private $seatMiddleLetter = [ 'Middle' => [ 'D', 'F' ] ];

	/**
	 * SeatMiddleLetter.
	 *
	 * @var string[][]
	 */
	private $seatRightLetter = [ 'Back' => [ 'G', 'K' ] ];

	/**
	 * SeatFrontNumber.
	 *
	 * @var int[][]
	 */
	private $seatFrontNumber = [ 'Left' => [ 1, 20 ] ];

	/**
	 * SeatMiddleNumber.
	 *
	 * @var int[][]
	 */
	private $seatMiddleNumber = [ 'Middle' => [ 21, 40 ] ];

	/**
	 * SeatBackNumber.
	 *
	 * @var int[][]
	 */
	private $seatBackNumber = [ 'Right' => [ 40, 60 ] ];

	/**
	 * GetSeatLeftLetter.
	 *
	 * @return string[][]
	 */
	public function getSeatLeftLetter() {
		return $this->seatLeftLetter;
	}

	/**
	 * GetSeatMiddleLetter.
	 *
	 * @return string[][]
	 */
	public function getSeatMiddleLetter() {
		return $this->seatMiddleLetter;
	}

	/**
	 * GetSeatRightLetter.
	 *
	 * @return string[][]
	 */
	public function getSeatRightLetter() {
		return $this->seatRightLetter;
	}

	/**
	 * GetSeatFrontNumber.
	 *
	 * @return int[][]
	 */
	public function getSeatFrontNumber() {
		return $this->seatFrontNumber;
	}

	/**
	 * GetSeatMiddleNumber.
	 *
	 * @return int[][]
	 */
	public function getSeatMiddleNumber() {
		return $this->seatMiddleNumber;
	}

	/**
	 * GetSeatBackNumber.
	 *
	 * @return int[][]
	 */
	public function getSeatBackNumber() {
		return $this->seatBackNumber;
	}
}

/**
 * Interface SeatManagerInterface
 */
interface SeatManagerInterface {

	/**
	 * GetSeatLeftLetter.
	 *
	 * @return string[][]
	 */
	public function getSeatLeftLetter();

	/**
	 * GetSeatMiddleLetter.
	 *
	 * @return string[][]
	 */
	public function getSeatMiddleLetter();

	/**
	 * GetSeatRightLetter.
	 *
	 * @return string[][]
	 */
	public function getSeatRightLetter();

	/**
	 * GetSeatFrontNumber.
	 *
	 * @return int[][]
	 */
	public function getSeatFrontNumber();

	/**
	 * GetSeatMiddleNumber.
	 *
	 * @return int[][]
	 */
	public function getSeatMiddleNumber();

	/**
	 * GetSeatBackNumber.
	 *
	 * @return int[][]
	 */
	public function getSeatBackNumber();
}

planeSeat();
