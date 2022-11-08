<?php declare(strict_types=1);

namespace SocialNetwork;

use RuntimeException;

require 'IObservable.php';

class Twitter implements IObservable
{
    //region private attributes
    private array $observers = [];
    private array $twits = [];

    //endregion private attributes

    public function __construct(array $observers = [], array $twits = [])
    {
        $this->setObservers($observers);
        $this->setTwits($twits);
    }

    public function subscribe(array $observers): void
    {
        $this->setObservers($observers);

    }

    public function unsubscribe(IObserver $observer): void
    {
        if (empty($this->getObservers())) {
            throw new EmptyListOfSubscribersException;
        }

        $key = array_search($observer, $this->getObservers(), true);

        if ($key === false) {
            throw new SubscriberNotFoundException;
        }

        unset($this->observers[$key]);
    }

    public function getObservers(): array
    {
        if (empty($this->observers)) {
            $this->observers = [];
        }
        return $this->observers;
    }

    public function setObservers($observers): array
    {
        if (empty($this->observers)) {
            $this->observers = $observers;
        } else {
            foreach ($observers as $observer) {
                if (in_array($observer, $this->observers, true)) {
                    throw new SubscriberAlreadyExistsException();
                }
                $this->observers[] = $observer;
            }
        }
        return $this->observers;
    }

    public function notifyObservers(): void
    {
        throw new EmptyListOfSubscribersException();
    }

    public function getTwits(): array
    {
        if (empty($this->twits)) {
            $this->twits = [];
        }
        return $this->twits;
    }

    public function setTwits($twits): array
    {
        $this->twits = $twits;
        return $this->twits;
    }
}

class TwitterException extends RuntimeException
{
}

class EmptyListOfSubscribersException extends TwitterException
{
}

class SubscriberAlreadyExistsException extends TwitterException
{
}

class SubscriberNotFoundException extends TwitterException
{
}