<?php

namespace Guzzle\Tests\Mock;

use Guzzle\Common\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MockObserver implements \Countable, EventSubscriberInterface {
	public $events = [];

	public function count() {
		return count($this->events);
	}

	public function getData($event, $key, $occurrence = 0) {
		$grouped = $this->getGrouped();
		if (isset($grouped[$event])) {
			return $grouped[$event][$occurrence][$key];
		}

		return;
	}

	public function getGrouped() {
		$events = [];
		foreach ($this->events as $event) {
			if (!isset($events[$event->getName()])) {
				$events[$event->getName()] = [];
			}
			$events[$event->getName()][] = $event;
		}

		return $events;
	}

	public function getLastEvent() {
		return end($this->events);
	}

	public static function getSubscribedEvents() {
		return [];
	}

	public function has($eventName) {
		foreach ($this->events as $event) {
			if ($event->getName() == $eventName) {
				return true;
			}
		}

		return false;
	}

	public function update(Event $event) {
		$this->events[] = $event;
	}
}
