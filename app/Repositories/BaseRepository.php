<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;
use Closure;

abstract class BaseRepository
{

    /**
     * Additional chainable callbacks
     * @var array
     */
    protected $callbacks = [];

    /**
     * Get key value of given value.
     * @param  mixed $instanceOrId
     * @return numeric
     */
    protected function getKey($instanceOrId)
    {
        if ($instanceOrId instanceof Model) {
            return $instanceOrId->getKey();
        }
        return $instanceOrId;
    }

    /**
     * Register additional callback to repository
     * All public query in the repository should call `applyCallbaks($query)` in order to apply these callbacks
     *
     * @param  Closure $callable
     * @return $this
     */
    public function chain(Closure $callable)
    {
        $this->callbacks[] = $callable;
        return $this;
    }

    /**
     * Apply registered callbacks to given query
     * @param  Query\Builder $query
     * @return Query\Builder
     */
    public function applyCallbacks($query)
    {
        return tap($query, function($query) {
            foreach ($this->callbacks as $callable) {
                $callable($query);
            }
        });
    }

}

