<?php

/**
* Webthumbnail
* @author El Hakym Khalid <khalid.elhakym@gmail.com>
*/

/**
 * =============================================================================
 * 
 * @file        webthumbnail.php
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

use Webthumbnail\Lib\WebthumbnailHttpCall;
use Webthumbnail\Lib\WebthumbnailException;


class Webthumbnail
{
    
    const API_URL = 'http://api.webthumbnail.org/';
    
    const FORMAT_PNG = 'png';
    const FORMAT_JPG = 'jpg';
    const FORMAT_GIF = 'gif';
    
    const MIN_WIDTH = 100;
    const MAX_WIDTH = 500;
    
    const MIN_HEIGHT = 100;
    const MAX_HEIGHT = 500;
    
    const SCREEN_1024 = 1024;
    const SCREEN_1280 = 1280;
    const SCREEN_1650 = 1650;
    const SCREEN_1920 = 1920;
    
    protected $_url;
    protected $_width = self::MIN_WIDTH;
    protected $_height = self::MIN_HEIGHT;
    protected $_format = self::FORMAT_PNG;
    protected $_screen = self::SCREEN_1024;
    protected $_timeout = 120;
    
    /**
     * Init webthumbnail.
     * @param string $url
     */
    public function __construct()
    {

    }
    
    /**
     * Get url.
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }

        
    /**
     * Set url.
     * @return Webthumbnail
     */
    public function setUrl($url)
    {
        $this->_url=$url;
        return $this;
    }
    
    /**
     * Set path.
     * @param string $path
     * @return Webthumbnail
     */    
    public function setPath($path)
    {
        $this->_path = $path;
        return $this;
    }      
    
    /**
     * Set width.
     * @param int $width
     * @return Webthumbnail
     */
    public function setWidth($width)
    {
        $this->_width = $this->_minmax((int) $width, self::MIN_WIDTH, self::MAX_WIDTH);
        return $this;
    }
    
    /**
     * Get width.
     * @return int
     */
    public function getWidth()
    {
        return $this->_width;
    }
    
    /**
     * Set height.
     * @param int $height
     * @return Webthumbnail
     */
    public function setHeight($height)
    {
        $this->_height = $this->_minmax((int) $height, self::MIN_HEIGHT, self::MAX_HEIGHT);
        return $this;
    }
    
    /**
     * Get height.
     * @return int
     */
    public function getHeight()
    {
        return $this->_height;
    }
    
    /**
     * Set format type.
     * @param string $format
     * @throws WebthumbnailException
     * @return Webthumbnail
     */
    public function setFormat($format)
    {
        switch (strtolower($format)) {
            case self::FORMAT_PNG:
            case self::FORMAT_JPG:
            case self::FORMAT_GIF:
                $this->_format = strtolower($format);
                break;
            default:
                throw new WebthumbnailException("Unsupported format type '{$format}'!");
        }
        return $this;
    }
    
    /**
     * Get format type.
     * @return string
     */
    public function getFormat()
    {
        return $this->_format;
    }
    
    /**
     * Get screen width.
     * @param string $screen
     * @throws WebthumbnailException
     * @return Webthumbnail
     */
    public function setScreen($screen)
    {
        switch ($screen) {
            case self::SCREEN_1024:
            case self::SCREEN_1280:
            case self::SCREEN_1650:
            case self::SCREEN_1920:
                $this->_screen = $screen;
                break;
            default:
                throw new WebthumbnailException("Unsupported screen width {$screen}!");
        }
        return $this;
    }
    
    /**
     * Get screen width.
     * @return string
     */
    public function getScreen()
    {
        return $this->_screen;
    }
    
    /**
     * Set timeout in seconds.
     * @param int $timeout
     * @return Webthumbnail
     */
    public function setTimeout($timeout)
    {
        $this->_timeout = (int) $timeout;
        return $this;
    }
    
    /**
     * Get timeout.
     * @return int
     */
    public function getTimeout()
    {
        return $this->_timeout;
    }
    
    /**
     * Get capture url.
     * @return string
     */
    public function getCaptureUrl()
    {
        return self::API_URL . 
            '?width='   . $this->_width .
            '&height='  . $this->_height .
            '&format='  . $this->_format .
            '&screen='  . $this->_screen .
            '&url=' . $this->_url;
    }
    
    /**
     * Execute the capture call.
     * @return WebthumbnailHttpCall
     */
    public function callCapture()
    {
        return new WebthumbnailHttpCall($this->getCaptureUrl());
    }
    
    /**
     * Execute the get-status call.
     * @return WebthumbnailHttpCall
     */
    public function callGetStatus()
    {
        return new WebthumbnailHttpCall($this->getCaptureUrl().'&action=get-status');
    }
    
    /**
     * Check if thumbnail is captured.
     * @return boolean
     */
    public function isCaptured()
    {
        $call = $this->callGetStatus();
        $response = $call->getResponse();
        switch ($response) {
            case 'finished':
                return true;
                
            case 'waiting':
            case 'pending':
            case 'loaded':
                return false;
                
            default:
                throw new WebthumbnailException('Invalid response from api server!');
        }
    }
    
    /**
     * Capture a thumbnail.
     * This method send a capture call and waits untill the thumbnail is ready or timeout is reached.
     * @return WebthumbnailHttpCall
     */
    public function capture($wait = true)
    {
        $i = 0;
        $this->callCapture();
        if ($wait) {
            while (!$this->isCaptured()) {
                if ($i++ >= $this->_timeout) {
                    throw new WebthumbnailException('Timeout, try again later!');
                }
                sleep(1);
            }
        }
        return $this->callCapture();
    }
    
    /**
     * Capture a thumbnail and send it to the browser.
     * @see examples/capture_to_browser.php
     * @return WebthumbnailHttpCall
     */
    public function captureToOutput($wait = true)
    {
        $call = $this->capture($wait);
        header("Content-Type: ".$call->getContentType());
        header("Content-Length: ".$call->getContentLength());
        echo $call->getResponse();
        return $call;
    }
    
    /**
     * Capture a thumbnail and send it to the file.
     * @see examples/capture_to_file.php
     * @param string $filename
     * @throws WebthumbnailException
     * @return WebthumbnailHttpCall
     */
    public function captureToFile($filename, $wait = true)
    {
        if(!is_null($this->_path)) $filename = $this->_path.$filename;
        $call = $this->capture($wait);
        if (!@file_put_contents($filename, $call->getResponse(), LOCK_EX)) {
            throw new WebthumbnailException("Cannot write thumbnail to file '{$filename}'!");
        }
        return $call;
    }
    
    protected function _minmax($x, $min, $max)
    {
        if ($x < $min) {
            return $min;
        } else if ($x > $max) {
            return $max;
        }
        return $x;
    }
    
}



