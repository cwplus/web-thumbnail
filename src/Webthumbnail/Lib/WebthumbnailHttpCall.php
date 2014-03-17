<?php

/**
* Webthumbnail
* @author El Hakym Khalid <khalid.elhakym@gmail.com>
*/

/**
 * =============================================================================
 * 
 * @file        WebthumbnailHttpCall.php
 *              Modified by El Hakym Khalid <khalid.elhakym@gmail.com>
 *             
 * 
 * @desc        http://webthumbnail.org
 *              The Webthumbnail.org is a free webapi for capturing website 
 *              screenshots in real browsers. Ready to serve thousands of 
 *              thumbnails, fully scalable, cloud based!
 *              Visit http://webthumbnail.org for more information.
 *              
 * @copyright   Copyright (C) 2012 HellWorx Software, Lukasz Cepowski
 *              All rights reserved.
 *              www.hellworx.com
 *              
 * @license     Redistribution and use in source and binary forms, with or 
 *              without modification, are permitted provided that the following 
 *              conditions are met:
 *              
 *              - Redistributions of source code must retain the above copyright 
 *                notice, this list of conditions and the following disclaimer.
 *              
 *              - Redistributions in binary form must reproduce the above 
 *                copyright notice, this list of conditions and the following 
 *                disclaimer in the documentation and/or other materials 
 *                provided with the distribution.
 *                
 *              THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND 
 *              CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, 
 *              INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF 
 *              MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE 
 *              DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR 
 *              CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, 
 *              SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT 
 *              NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; 
 *              LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) 
 *              HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN 
 *              CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR 
 *              OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, 
 *              EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *              
 * =============================================================================
 */

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
