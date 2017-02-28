<?php

namespace Elemeno\Content;

class Entity {

    public function __construct( array $data = array() )
    {
        $this->populate( $data );
    }

    /**
     * Will populate an entity from an array
     *
     * @param array $data
     *
     * @return \Mothership\Model\AbstractEntity
     */
    public function populate( array $data = array() )
    {
        // if we have some data, lets prepopulate this class
        if( !empty( $data ) )
        {
            foreach( $data as $name => $value )
            {
                $this->__set( $name, $value );
            }
        }

        return $this; // allow for fluid interfacing
    }

    /**
     * Assign a value to the specified field via the corresponding mutator
     *
     * @param string $name  The setter name, if not defined, will be the key name
     * @param mixed  $value The value to set on the object
     *
     * @throws \Exception
     */
    public function __set( $name, $value )
    {
        // check if we have a mutator (setter) defined or not
        $mutator = 'set' . ucfirst( $name );

        if( method_exists( $this, $mutator ) /*&& is_callable( array( $this, $mutator ) )*/ )
        {
            $this->$mutator( $value );
        }
    }

    /**
     * Get the value assigned to the specified field via the corresponding getter
     *
     * @param string $name The value to get (and/or the getter to call)
     *
     * @throws \Exception
     */
    public function __get( $name )
    {
        // check if an accessor is defined (if not retrieve the value from the values array)
        $accessor = 'get' . ucfirst( $name );

        if( method_exists( $this, $accessor ) && is_callable( array( $this, $accessor ) ) )
            return $this->$accessor();

        // if there is no getter on the property, don't allow access to it.
        throw new \Exception( 'The object property ' . $name . ' is not defined or exposed through a getXXX() method. HINT: Make sure the object you are accessing has a getter for the property ' . $name );
    }

}
