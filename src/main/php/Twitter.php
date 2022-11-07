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
        //TODO Review - Single Responsibility Principle
        //Prefer to use the specialized method designed to add followers...
        $this->observers = $observers;
        $this->twits = $twits;
    }
    
    public function subscribe(array $observers): void
    {
        $this->setObservers($observers);
        
    }
    
    public function unsubscribe(IObserver $observer): void
    {
        if ($this->getObservers() == null) {
            throw new EmptyListOfSubscribersException;
        } else {
            $key = array_search($observer, $this->getObservers(), true);
            if ($key === false) {
                throw new SubscriberNotFoundException;
                
            } else {
                unset($this->observers[$key]);
            }
        }
    }
    
    public function getObservers(): array
    {
        if ($this->observers == null) {
            //TODO Review - There is a another way to avoid "null pointer exception"
            $this->observers = [];
        }
        return $this->observers;
    }
    
    public function setObservers($observers): array
    {
        if ($this->observers == null) {
            //TODO Review - Bad idea....
            $this->observers = $observers;
        } else {
            foreach ($observers as $observer) {
                if (in_array($observer, $this->observers, true)) {
                    throw new SubscriberAlreadyExistsException();
                } else {
                    //TODO Review - If the exception is thrown... does it make any sens to write an else ?
                    $this->observers[] = $observer;
                }
            }
        }
        
        return $this->observers;
    }
    
    public function notifyObservers(): void
    {
        //TODO REVIEW please clean your code (no commented code anymore)
        //throw new EmptyListOfSubscribersException();
        throw new EmptyListOfSubscribersException();
    }
    
    public function getTwits(): array
    {
        if ($this->twits == null) {
            //TODO Review - There is a another way to avoid "null pointer exception"
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