<?php

namespace Webthumbnail\Lib;

use Webthumbnail\Lib\WebthumbnailException;

class WebthumbnailHttpCall
{
    
    public $_response;
    public $_statusCode;
    public $_contentType;
    public $_contentLength;
    
    /**
     * Create and execute a http call.
     * @param string $url
     * @throws WebthumbnailException
     */
    public function __construct($url)
    {
        if (!function_exists('curl_init')) {
            throw new WebthumbnailException("Curl is not supported by your version of PHP!");
        }
        
        $ch = curl_init($url);
        if (!$ch) {
            throw new WebthumbnailException("curl_init failed!");
        }
        
        $referer = '-';
        if (isset($_SERVER) && isset($_SERVER['HTTP_REFERER'])) {
            $referer = $_SERVER['HTTP_REFERER'];
        }
        
        $userAgent = 'Webthumbnail.org Client PHP/'.phpversion();
        if (isset($_SERVER) && isset($_SERVER['SERVER_SOFTWARE'])) {
            $userAgent .= ' ' . $_SERVER['SERVER_SOFTWARE'];
        }
        
        curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
        if (!ini_get('open_basedir') && !ini_get('safe_mode')) {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        }
  
        $this->_response = curl_exec($ch);
        if (!$this->_response) {
            throw new WebthumbnailException("curl_exec failed!");
        }
        
        $this->_statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $this->_contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        $this->_contentLength = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        
        curl_close($ch);
    }
    
    /**
     * Get response body.
     * @return string
     */
    public function getResponse()
    {
        return $this->_response;
    }
    
    /**
     * Get http status code.
     * @return int
     */
    public function getStatusCode()
    {
        return $this->_statusCode;
    }
    
    /**
     * Get content type.
     * @return string
     */
    public function getContentType()
    {
        return $this->_contentType;
    }
    
    /**
     * Get content length.
     * @return int
     */
    public function getContentLength()
    {
        return $this->_contentLength;
    }
    
}