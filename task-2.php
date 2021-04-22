<?php
function what_list_am_i_on(
	array $actions
): string {
	$collectionLetter = new CollectionLetter();
	$sentenceChecker  = new SentenceChecker();
	$counterManager   = new Counter();

	$sentenceChecker->set_letter_naughty( $collectionLetter->get_letter_naughty() );
	$sentenceChecker->set_letter_nice( $collectionLetter->get_letter_nice() );
	$sentenceChecker->set_count_manager( $counterManager );
	$sentenceChecker->init( $actions );

	return $counterManager->get_count_is_nice() > $counterManager->get_count_is_naughty() ? "nice" : 'naughty';
}

class SentenceChecker {

	private $letter_naughty;
	private $letter_nice;
	private $count_manager;

	/**
	 * @param $count_manager
	 */
	public function set_count_manager( $count_manager ) {
		$this->count_manager = $count_manager;
	}

	/**
	 * @param $letters
	 */
	function set_letter_naughty( $letters ) {
		$this->letter_naughty = $letters;
	}

	/**
	 * @param $letters
	 */
	function set_letter_nice( $letters ) {
		$this->letter_nice = $letters;
	}

	/**
	 * @return mixed
	 */
	function get_letter_naughty() {
		return $this->letter_naughty;
	}

	/**
	 * @return mixed
	 */
	function get_letter_nice() {
		return $this->letter_nice;
	}

	/**
	 * @param $letter
	 */
	function checkSentence( $letter ) {
		if ( in_array( $letter, $this->get_letter_nice() ) ) {
			$this->count_manager->UpNice();
		} elseif ( in_array( $letter, $this->get_letter_naughty() ) ) {
			$this->count_manager->UpNaughty();
		}
	}

	/**
	 * @param $actions
	 */
	public function init( $actions ) {
		foreach ( $actions as $sentence ) {
			if ( ! isset( $sentence[0] ) ) {
				continue;
			}
			$this->checkSentence( $sentence[0] );
		}
	}

}

class CollectionLetter {
	private $letter_naughty = [ 'b', 'f', 'k' ];
	private $letter_nice = [ 'g', 's', 'n' ];

	/**
	 * @return string[]
	 */
	function get_letter_naughty() {
		return $this->letter_naughty;
	}

	/**
	 * @return string[]
	 */
	function get_letter_nice() {
		return $this->letter_nice;
	}

}

class Counter {
	private $isNice = 0;
	private $isNaughty = 0;

	/**
	 *
	 */
	public function UpNice() {
		$this->isNice ++;
	}

	/**
	 *
	 */
	public function UpNaughty() {
		$this->isNaughty ++;
	}

	/**
	 * @return int
	 *
	 */
	public function get_count_is_nice() {
		return $this->isNice;
	}

	/**
	 * @return int
	 */
	public function get_count_is_naughty() {
		return $this->isNaughty;
	}
}
