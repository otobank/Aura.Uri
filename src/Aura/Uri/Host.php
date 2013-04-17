<?php
/**
 *
 * This file is part of the Aura project for PHP.
 *
 * @package Aura.Uri
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 *
 */
namespace Aura\Uri;

/**
 *
 * Processing the host
 *
 * @package Aura.Uri
 *
 */
class Host
{
    /**
     * 
     * The public suffix list.
     * 
     * @var array
     * 
     */
    protected $psl;

    /**
     * 
     * Subdomain portion of host.
     * 
     * @var string
     * 
     */
    protected $subdomain;

    /**
     * 
     * Registerable domain portion of host.
     * 
     * @var string 
     * 
     */
    protected $registerable_domain;

    /**
     * 
     * Public suffix portion of host.
     * 
     * @var string
     * 
     */
    protected $public_suffix;

    /**
     *
     * Constructor.
     *
     * @param PublicSuffixList $psl Public suffix list.
     *
     * @param array $spec Host elements.
     *
     */
    public function __construct(PublicSuffixList $psl, array $spec = [])
    {
        $this->psl = $psl;
        foreach ($spec as $key => $val) {
            $this->$key = $val;
        }
    }

    /**
     *
     * Returns this Host object as a string.
     *
     * @return string The full Host this object represents.
     *
     */
    public function __toString()
    {
        $str = array_filter(
            [$this->subdomain, $this->registerable_domain],
            'strlen'
        );

        return implode('.', $str);
    }

    public function __get($name)
    {
        throw new \Exception;
    }
    
    /**
     *
     * Sets values from a host string; overwrites any previous values.
     *
     * @param string $spec The host string to use; e.g., 'example.com'.
     *
     * @return void
     *
     */
    public function setFromString($spec)
    {
        $this->public_suffix = $this->psl->getPublicSuffix($spec);
        $this->registerable_domain = $this->psl->getRegisterableDomain($spec);
        $this->subdomain = $this->psl->getSubdomain($spec);
    }
    
    public function getPsl()
    {
        return $this->psl;
    }
    
    public function getPublicSuffix()
    {
        return $this->public_suffix;
    }

    public function getSubdomain()
    {
        return $this->subdomain;
    }
    
    public function getRegisterableDomain()
    {
        return $this->registerable_domain;
    }
    
}
