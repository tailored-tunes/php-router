<?php

namespace TailoredTunes;

use DateTime;

class RandomGenerator {

	/**
	 * @param integer $max
	 *
	 * @return integer
	 */
	public function randomNumber($max = 1000) {
		return rand(0, $max);
	}

	/**
	 * @return integer
	 */
	public function randomTime() {
		$startDate = new DateTime('1970-01-01 00:00:00');
		$endDate = new DateTime('now');
		$endDate->modify('+100 years');

		return $this->randomDateTime($startDate, $endDate)->getTimestamp();
	}

	/**
	 * @param DateTime $startDate
	 * @param DateTime $endDate
	 *
	 * @return DateTime
	 */
	public function randomDateTime(DateTime $startDate, DateTime $endDate) {
		$newDateTimestamp = mt_rand($startDate->getTimestamp(), $endDate->getTimestamp());
		$randomDate = new DateTime();
		$randomDate->setTimestamp($newDateTimestamp);

		return $randomDate;
	}

	/**
	 * @return string
	 */
	public function hostname() {
		return sprintf('%s.%s.%s', $this->randomText(), $this->randomText(), $this->randomText());
	}

	/**
	 * @return string
	 */
	public function randomText() {
		return uniqid();
	}

}

?>
