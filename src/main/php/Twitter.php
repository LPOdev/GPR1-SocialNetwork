<?php declare(strict_types=1);

namespace SocialNetwork;

use RuntimeException;

require 'IObservable.php';

class Twitter implements IObservable
{
    //region private attributes
    private array $observers;
    private $twits;
    //endregion private attributes
    
    public function __construct(array $observers = [], array $twits = null)
    {
        $this->observers = $observers;
        $this->twits = $twits;
    }
    
    public function subscribe(array $observers): void
    {
        $this->setObservers($observers);
        
    }
    
    public function unsubscribe(IObserver $observer): void
    {
        throw new RuntimeException();
    }
    
    public function notifyObservers(): void
    {
        //throw new EmptyListOfSubscribersException();
        throw new EmptyListOfSubscribersException();
    }
    
    public function getObservers(): array
    {
        if ($this->observers == null) {
            $this->observers = [];
        }
        return $this->observers;
    }
    
    public function setObservers($observers): array
    {
        if ($this->observers == null) {
            $this->observers = $observers;
        } else {
            $this->observers[] = $observers;
        }
        return $this->observers;
    }
    
    public function getTwits(): array
    {
        if ($this->twits == null) {
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