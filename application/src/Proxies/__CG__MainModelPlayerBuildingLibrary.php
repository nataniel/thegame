<?php

namespace Main\Proxies\__CG__\Main\Model\Player\Building;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Library extends \Main\Model\Player\Building\Library implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', 'player', 'amount', 'id', '_errors', '_readonly'];
        }

        return ['__isInitialized__', 'player', 'amount', 'id', '_errors', '_readonly'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Library $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getPrice($amount = 1)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPrice', [$amount]);

        return parent::getPrice($amount);
    }

    /**
     * {@inheritDoc}
     */
    public function canBeBuilt($amount = 1)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'canBeBuilt', [$amount]);

        return parent::canBeBuilt($amount);
    }

    /**
     * {@inheritDoc}
     */
    public function build($amount = 1)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'build', [$amount]);

        return parent::build($amount);
    }

    /**
     * {@inheritDoc}
     */
    public function setAmount($amount)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAmount', [$amount]);

        return parent::setAmount($amount);
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, '__toString', []);

        return parent::__toString();
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getName', []);

        return parent::getName();
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDescription', []);

        return parent::getDescription();
    }

    /**
     * {@inheritDoc}
     */
    public function getPlayer()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPlayer', []);

        return parent::getPlayer();
    }

    /**
     * {@inheritDoc}
     */
    public function getAmount()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAmount', []);

        return parent::getAmount();
    }

    /**
     * {@inheritDoc}
     */
    public function addAmount($amount = 1)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addAmount', [$amount]);

        return parent::addAmount($amount);
    }

    /**
     * {@inheritDoc}
     */
    public function getType()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getType', []);

        return parent::getType();
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function id()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'id', []);

        return parent::id();
    }

    /**
     * {@inheritDoc}
     */
    public function offsetExists($offset)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'offsetExists', [$offset]);

        return parent::offsetExists($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet($offset)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'offsetGet', [$offset]);

        return parent::offsetGet($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetSet($offset, $value)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'offsetSet', [$offset, $value]);

        return parent::offsetSet($offset, $value);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset($offset)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'offsetUnset', [$offset]);

        return parent::offsetUnset($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function loadForm($form)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'loadForm', [$form]);

        return parent::loadForm($form);
    }

    /**
     * {@inheritDoc}
     */
    public function toArray($useGetters = true)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'toArray', [$useGetters]);

        return parent::toArray($useGetters);
    }

    /**
     * {@inheritDoc}
     */
    public function showEntity($showFields = true, $maxLevel = 0, $currentLevel = 0)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'showEntity', [$showFields, $maxLevel, $currentLevel]);

        return parent::showEntity($showFields, $maxLevel, $currentLevel);
    }

    /**
     * {@inheritDoc}
     */
    public function dump($property = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'dump', [$property]);

        return parent::dump($property);
    }

    /**
     * {@inheritDoc}
     */
    public function destroy()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'destroy', []);

        return parent::destroy();
    }

    /**
     * {@inheritDoc}
     */
    public function getClassMetadata()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getClassMetadata', []);

        return parent::getClassMetadata();
    }

    /**
     * {@inheritDoc}
     */
    public function isReadOnly()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isReadOnly', []);

        return parent::isReadOnly();
    }

    /**
     * {@inheritDoc}
     */
    public function setReadOnly($flag = true)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setReadOnly', [$flag]);

        return parent::setReadOnly($flag);
    }

    /**
     * {@inheritDoc}
     */
    public function prePersist()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'prePersist', []);

        return parent::prePersist();
    }

    /**
     * {@inheritDoc}
     */
    public function preUpdate(\Doctrine\ORM\Event\PreUpdateEventArgs $event)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'preUpdate', [$event]);

        return parent::preUpdate($event);
    }

    /**
     * {@inheritDoc}
     */
    public function preRemove()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'preRemove', []);

        return parent::preRemove();
    }

    /**
     * {@inheritDoc}
     */
    public function postLoad()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'postLoad', []);

        return parent::postLoad();
    }

    /**
     * {@inheritDoc}
     */
    public function postPersist()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'postPersist', []);

        return parent::postPersist();
    }

    /**
     * {@inheritDoc}
     */
    public function postRemove()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'postRemove', []);

        return parent::postRemove();
    }

    /**
     * {@inheritDoc}
     */
    public function postUpdate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'postUpdate', []);

        return parent::postUpdate();
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdatedNow()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUpdatedNow', []);

        return parent::setUpdatedNow();
    }

    /**
     * {@inheritDoc}
     */
    public function valid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'valid', []);

        return parent::valid();
    }

    /**
     * {@inheritDoc}
     */
    public function getErrors($field = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getErrors', [$field]);

        return parent::getErrors($field);
    }

    /**
     * {@inheritDoc}
     */
    public function addError($message, $field = '')
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addError', [$message, $field]);

        return parent::addError($message, $field);
    }

    /**
     * {@inheritDoc}
     */
    public function validate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'validate', []);

        return parent::validate();
    }

    /**
     * {@inheritDoc}
     */
    public function isManaged()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'isManaged', []);

        return parent::isManaged();
    }

    /**
     * {@inheritDoc}
     */
    public function update()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'update', []);

        return parent::update();
    }

    /**
     * {@inheritDoc}
     */
    public function refresh()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'refresh', []);

        return parent::refresh();
    }

    /**
     * {@inheritDoc}
     */
    public function doSave(array &$visited)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'doSave', [$visited]);

        return parent::doSave($visited);
    }

    /**
     * {@inheritDoc}
     */
    public function save()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'save', []);

        return parent::save();
    }

    /**
     * {@inheritDoc}
     */
    public function cascadeMerge(array &$visited)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'cascadeMerge', [$visited]);

        return parent::cascadeMerge($visited);
    }

    /**
     * {@inheritDoc}
     */
    public function loadArray($attributes, $propertyList = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'loadArray', [$attributes, $propertyList]);

        return parent::loadArray($attributes, $propertyList);
    }

    /**
     * {@inheritDoc}
     */
    public function __call($name, $argv)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, '__call', [$name, $argv]);

        return parent::__call($name, $argv);
    }

}
