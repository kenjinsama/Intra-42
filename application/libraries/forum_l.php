<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class forum_l
{
	private $_img_max_w = 720;
	private $_img_max_h = 1280;
	private $_bad_words = array(
		'french' => "connard|conar|connar|pute|tête de bite|salope|enculé|encule|porn|pr0n|con|conne",
		'english' => "fuck you|fuck|fucking|asshole|shit|ass|twat"
	);
	private $_censored = array(
		'french' => "<3 chaton(s) tout mignon(s) <3",
		'english' => "<3 little bird <3"
	);

	public function setImgMaxSize($width, $height)
	{
		if ($width < 12 || $height < 12)
			die("Size must be greater than 12px.");
		$this->_img_max_w = $height;
		$this->_img_max_h = $height;
	}

	public function formatPost($str)
	{
		$str = strip_tags($str);
		$str = $this->_parseBbcode($str);
		$str = $this->_trimBadWords($str);
		$str = $this->_easterEggs($str);
		return ($str);
	}

	private function _parseBbcode($str = '', $max_images = 0)
	{
		if($max_images > 0)
			$str_max = "style=\"max-width:" . $max_images . "px; width: [removed]this.width > " . $max_images . " ? " . $max_images . ": true);\"";

		$find = array(
		  "'\[b\](.*?)\[/b\]'is",
		  "'\[i\](.*?)\[/i\]'is",
		  "'\[u\](.*?)\[/u\]'is",
		  "'\[s\](.*?)\[/s\]'is",
		  "'\[img\](.*?)\[/img\]'i",
		  "'\[url\](.*?)\[/url\]'i",
		  "'\[url=(.*?)\](.*?)\[/url\]'i",
		  "'\[link\](.*?)\[/link\]'i",
		  "'\[link=(.*?)\](.*?)\[/link\]'i"
		);

		$replace = array(
		  '<strong>\\1</strong>',
		  '<em>\\1</em>',
		  '<u>\\1</u>',
		  '<s>\\1</s>',
		  '<img style="max-width:' . $this->_img_max_w . ';max-height:' . $this->_img_max_h . ';" src="\\1" alt="" />',
		  '<a href="\\1">\\1</a>',
		  '<a href="\\1">\\2</a>',
		  '<a href="\\1">\\1</a>',
		  '<a href="\\1">\\2</a>'
		);

		return (preg_replace($find, $replace, $str));
	}

	private function _trimBadWords($str, $language)
	{
		$dictionary = $this->_bad_words[$language];
		$censor = $this->_censored[$language];
		$str = preg_replace('`\b(' . $dictionary . ')[sx]?\b`si', $censor, $str);
	}

	private function _easterEggs($str)
	{
		$str = preg_replace('`\b(' . 'Chuck Norris' . ')[sx]?\b`si', '<img style="width:64px;height:64px;" src="http://fc00.deviantart.net/fs10/f/2006/097/a/5/chucknorrist.gif" alt="Chuck Norris" />', $str);
		$str = preg_replace('`\b(' . 'Windows' . ')[sx]?\b`si', 'Windaube', $str);
		$str = preg_replace('`\b(' . 'Epitech' . ')[sx]?\b`si', 'une grosse erreur dans ma vie', $str);		
	}
}
?>