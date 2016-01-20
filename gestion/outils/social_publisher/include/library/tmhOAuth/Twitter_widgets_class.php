<?php

class Twitter_widgets_class
{
	/*
	Custom values
	*/
	var $username = 'yougapi'; //defaut username
	var $lang = 'en'; //fr, de, it, es, ko, ja
	
	/*
	Twitter Follow buttons
	http://twitter.com/about/resources/buttons
	*/
	function get_follow_button($criteria=array()) {
		$username = $criteria['username'];
		$type = $criteria['type'];
		$colorscheme = $criteria['colorscheme'];
		$alt = $criteria['alt'];
		
		if($username=='') $username = $this->username;
		if($type=='') $type = '1';
		if($colorscheme=='') $colorscheme = 'green'; //green, clear, dark
		if($alt=='') $alt = 'Follow '.$username.' on Twitter';
		
		$target = 'target="_blank"';
		
		if($type==1) {
			if($colorscheme=='dark') $content = '<a href="http://www.twitter.com/'.$username.'" '.$target.'><img src="http://twitter-badges.s3.amazonaws.com/follow_me-c.png" alt="'.$alt.'"/></a>';
			else if($colorscheme=='clear') $content = '<a href="http://www.twitter.com/'.$username.'" '.$target.'><img src="http://twitter-badges.s3.amazonaws.com/follow_me-b.png" alt="'.$alt.'"/></a>';
			else $content = '<a href="http://www.twitter.com/'.$username.'" '.$target.'><img src="http://twitter-badges.s3.amazonaws.com/follow_me-a.png" alt="'.$alt.'"/></a>';
		}
		if($type==2) {
			if($colorscheme=='dark') $content = '<a href="http://www.twitter.com/'.$username.'" '.$target.'><img src="http://twitter-badges.s3.amazonaws.com/follow_us-c.png" alt="'.$alt.'"/></a>';
			else if($colorscheme=='clear') $content = '<a href="http://www.twitter.com/'.$username.'" '.$target.'><img src="http://twitter-badges.s3.amazonaws.com/follow_us-b.png" alt="'.$alt.'"/></a>';
			else $content = '<a href="http://www.twitter.com/'.$username.'" '.$target.'><img src="http://twitter-badges.s3.amazonaws.com/follow_us-a.png" alt="'.$alt.'"/></a>';
		}
		else if($type==3) {
			if($colorscheme=='dark') $content = '<a href="http://www.twitter.com/'.$username.'" '.$target.'><img src="http://twitter-badges.s3.amazonaws.com/twitter-c.png" alt="'.$alt.'"/></a>';
			else if($colorscheme=='clear') $content = '<a href="http://www.twitter.com/'.$username.'" '.$target.'><img src="http://twitter-badges.s3.amazonaws.com/twitter-b.png" alt="'.$alt.'"/></a>';
			else $content = '<a href="http://www.twitter.com/'.$username.'" '.$target.'><img src="http://twitter-badges.s3.amazonaws.com/twitter-a.png" alt="'.$alt.'"/></a>';
		}
		else if($type==4) {
			if($colorscheme=='dark') $content = '<a href="http://www.twitter.com/'.$username.'" '.$target.'><img src="http://twitter-badges.s3.amazonaws.com/t_logo-c.png" alt="'.$alt.'"/></a>';
			else if($colorscheme=='clear') $content = '<a href="http://www.twitter.com/'.$username.'" '.$target.'><img src="http://twitter-badges.s3.amazonaws.com/t_logo-b.png" alt="'.$alt.'"/></a>';
			else $content = '<a href="http://www.twitter.com/'.$username.'" '.$target.'><img src="http://twitter-badges.s3.amazonaws.com/t_logo-a.png" alt="'.$alt.'"/></a>';
		}
		else if($type==5) {
			if($colorscheme=='dark') $content = '<a href="http://www.twitter.com/'.$username.'" '.$target.'><img src="http://twitter-badges.s3.amazonaws.com/t_small-c.png" alt="'.$alt.'"/></a>';
			else if($colorscheme=='clear') $content = '<a href="http://www.twitter.com/'.$username.'" '.$target.'><img src="http://twitter-badges.s3.amazonaws.com/t_small-b.png" alt="'.$alt.'"/></a>';
			else $content = '<a href="http://www.twitter.com/'.$username.'" '.$target.'><img src="http://twitter-badges.s3.amazonaws.com/t_small-a.png" alt="'.$alt.'"/></a>';
		}
		else if($type==6) {
			if($colorscheme=='dark') $content = '<a href="http://www.twitter.com/'.$username.'" '.$target.'><img src="http://twitter-badges.s3.amazonaws.com/t_mini-c.png" alt="'.$alt.'"/></a>';
			else if($colorscheme=='clear') $content = '<a href="http://www.twitter.com/'.$username.'" '.$target.'><img src="http://twitter-badges.s3.amazonaws.com/t_mini-b.png" alt="'.$alt.'"/></a>';
			else $content = '<a href="http://www.twitter.com/'.$username.'" '.$target.'><img src="http://twitter-badges.s3.amazonaws.com/t_mini-a.png" alt="'.$alt.'"/></a>';
		}
		
		return $content;
	}
	
	/*
	Twitter Tweet buttons
	http://twitter.com/about/resources/tweetbutton
	*/
	
	function get_tweet_button($criteria=array()) {
		$url = $criteria['url'];
		$type = $criteria['type']; //1=vertical count, 2=horizontal count, 3=no count
		$text = $criteria['text'];
		$lang = $criteria['lang']; //fr, de, it, es, ko, ja
		$via = $criteria['via'];
		$related = $criteria['related'];
		
		if($url=='') $url = '';
		if($type=='') $type = 1;
		if($text=='') $text = '';
		if($lang=='') $lang = $this->lang;
		if($via=='') $via = '';
		if($related=='') $related = '';
		
		if($url!='') $data_url = ' data-url="'.$url.'" ';
		if($text!='') $data_text = ' data-text="'.$text.'" ';
		if($lang!='') $data_lang = ' data-lang="'.$lang.'" ';
		if($via!='') $data_via = ' data-via="'.$via.'" ';
		if($related!='') $data_related = ' data-related="'.$related.'" ';
		
		if($type==1) {
			//80px x 20px
			$content = '<a href="http://twitter.com/share" class="twitter-share-button"'.$data_url.''.$data_text.'data-count="none"'.$data_lang.''.$data_via.''.$data_related.'>Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>';
		}
		if($type==2) {
			//80px x 62px
			$content = '<a href="http://twitter.com/share" class="twitter-share-button"'.$data_url.''.$data_text.'data-count="vertical"'.$data_lang.''.$data_via.''.$data_related.'>Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>';
		}
		else if($type==3) {
			//130px x 20px
			$content = '<a href="http://twitter.com/share" class="twitter-share-button"'.$data_url.''.$data_text.'data-count="horizontal"'.$data_lang.''.$data_via.''.$data_related.'>Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>';
		}
		
		return $content;
	}
	
	/*
	Twitter widgets
	https://dev.twitter.com/docs/embedded-timelines
	*/
	function get_widget($criteria=array()) {
		$id = $criteria['id'];
		$username = $criteria['username'];
		$favorite = $criteria['favorite'];
		$list = $criteria['list'];
		$limit = $criteria['limit'];
		$theme = $criteria['theme'];
		$link_color = $criteria['link_color'];
		$width = $criteria['width'];
		$height = $criteria['height'];
		$lang = $criteria['lang'];
		$chrome = $criteria['chrome']; //noheader, nofooter, noborders, transparent
		
		if($limit=='') $limit = ''; //between 1 and 20
		if($theme=='') $theme = 'light'; //light, dark
		if($width=='') $width = 500; //180 minimum
		if($height=='') $height = 400; //200 minimum
		if($lang=='') $lang = 'en'; //en, fr, de, etc...
		
		if($username!='') {
			if($favorite==1) {
				$param = 'data-favorites-screen-name="'.$username.'"';
			}
			else {
				if($list=='') {
					$param = 'data-screen-name="'.$username.'"';
				}
				else {
					$param = 'data-list-owner-screen-name="'.$username.'"';
					$param .= 'data-list-slug="'.$list.'"';
				}
			}
		}
		
		$content = '
		<a class="twitter-timeline" data-theme="'.$theme.'" data-link-color="'.$link_color.'" 
		width="'.$width.'" height="'.$height.'" lang="'.$lang.'"
		data-chrome="'.$chrome.'" data-tweet-limit="'.$limit.'" data-aria-polite="polite" 
		'.$param.'
		href="https://twitter.com/'.$username.'" data-widget-id="'.$id.'">Tweets by @yougapi</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		';
		
		return $content;
	}	
}

?>