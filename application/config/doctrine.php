<?php
return [
    /**
     * Doctrine configuration settings for Entity Manager
     * @link http://docs.doctrine-project.org/en/2.0.x/reference/configuration.html
     */

    /* Doctrine\ORM\Configuration#setProxyDir() */
    'proxy_dir' => 'application/src/Proxies',

    /* Doctrine\ORM\Configuration#setProxyDir() */
    'proxy_namespace' => APPLICATION.'\Proxies',

    /* Doctrine\ORM\Configuration#newDefaultAnnotationDriver() */
    # 'entities_dir' => array('application/src/Model', 'application/modules'),

    /* Doctrine\ORM\Mapping\Driver\XmlDriver */
    # 'entities_xml' => 'application/config/mappings',

    /* Doctrine\ORM\Configuration#setAutoGenerateProxyClasses() */
    'auto_generate_proxies' => true,

    /* Doctrine\ORM\Configuration#setSQLLogger() */
    # 'sql_logger' => 'Doctrine\DBAL\Logging\EchoSQLLogger',

    /* Doctrine\ORM\Configuration#setMetadataCacheImpl() */
    /* Doctrine\ORM\Configuration#setQueryCacheImpl() */
    'cache_class' => \Doctrine\Common\Cache\ArrayCache::class,
];