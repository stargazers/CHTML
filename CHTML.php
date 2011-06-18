<?php
	
	// ************************************************
	//	CHTML
	/*!
		@brief CHTML - HTML Class for PHP

		@author Aleksi Räsänen
		        aleksi.rasanen@runosydan.net
	*/
	// ************************************************
	class CHTML
	{
		//! Language to set in <html language part
		private $language;

		//! Character set to set in <meta part
		private $charset;

		//! Javascript file/files to include in <head> part
		private $js_files;

		//! CSS file/files to include in <head> part
		private $css_files;

		//! Keywords for <meta part
		private $keywords;

		//! Array of extra parameters for next creating item
		private $params;

		//! Messages what will be shown with getMessage are stored here.
		private $message = array();


		// ************************************************
		//	__construct
		/*!
			@brief Set class default variables.
		*/
		// ************************************************
		public function __construct()
		{
			$this->language = 'en';
			$this->charset = 'utf-8';
			$this->keywords = '';
			$this->js_files = null;
			$this->css_files = null;
			$this->params = null;
			$this->message['msg'] = '';
		}

		// ************************************************
		//	createSiteTop
		/*!
			@brief Create standard HTML5 header.

			@param $title HTML page title.

			@return String.
		*/
		// ************************************************
		public function createSiteTop( $title )
		{
			$out = '<!DOCTYPE html>' . "\n";
			$out .= '<html lang="' . $this->language . '">' . "\n";
			$out .= '<head>' . "\n";
			$out .= '<meta charset="' . $this->charset . '" />' . "\n";
			$out .= '<meta name="keywords" content="' 
				. $this->keywords . '" />' . "\n";
			$out .= $this->include_files( 'css', $this->css_files );
			$out .= '<title>' . $title . '</title>' . "\n";
			$out .= $this->include_files( 'js', $this->js_files );
			$out .= '</head>' . "\n\n";
			$out .= '<body>' . "\n";
			return $out;
		}

		// ************************************************
		//	createSiteBottom
		/*!
			@brief Create site bottom. This will Close 
			  </body> and </html> tags.

			@return String.
		*/
		// ************************************************
		public function createSiteBottom()
		{
			$out = '</body>' . "\n";
			$out .= '</html>' . "\n";
			return $out;
		}

		// ************************************************
		//	setCSS
		/*!
			@brief Set CSS files to include in HTML header.

			@param $files CSS filename. Can be array of files.
		*/
		// ************************************************
		public function setCSS( $files )
		{
			$this->css_files = $files;
		}

		// ************************************************
		//	setJS
		/*!
			@brief Set JavaScript files to include in HTML header.

			@param $files JavaScript filename. Can be array of files.
		*/
		// ************************************************
		public function setJS( $files )
		{
			$this->js_files = $files;
		}

		// ************************************************
		//	setCharset
		/*!
			@brief Set character set to use in HTML header.

			@param $charset Character set as a string.
		*/
		// ************************************************
		public function setCharset( $charset )
		{
			$this->charset = $charset;
		}

		// ************************************************
		//	setLanguage
		/*!
			@brief Set language to use in HTML header.

			@param $language Language as a string.
		*/
		// ************************************************
		public function setLanguage( $language )
		{
			$this->language = $language;
		}

		// ************************************************
		//	setKeywords
		/*!
			@brief Set keywords to use in HTML header.

			@param $keywords Should be string, so multiple values
			  are given just using , as a separator.
		*/
		// ************************************************
		public function setKeywords( $keywords )
		{
			$this->keywords = $keywords;
		}

		// ************************************************
		//	setExtraParams
		/*!
			@brief Set extra parameters for next creating item.
			  This will be used when we want to give id, name,
			  class, title and element specific values to 
			  item what will be created next after this method.

			@param $params Assoc array, where key must be parameter
			  and value must be value of that parameter.
		*/
		// ************************************************
		public function setExtraParams( $params )
		{
			$this->params = $params;
		}

		// ************************************************
		//	createLink
		/*!
			@brief Create a link.

			@param $url URL where we link to.

			@param $caption Link title text.

			@return String.
		*/
		// ************************************************
		public function createLink( $url, $caption )
		{
			$out = '<a href="' . $url . '"';
			$out .= $this->add_extra_params( 'a' );
			$out .= '>' . $caption . '</a>' . "\n";

			return $out;
		}

		// **************************************************
		//	createImg
		/*!
			@brief This will create HTML <img> tag

			@param $src Image source

			@return String.
		*/
		// **************************************************
		public function createImg( $src )
		{
			$out = '<img src="' . $src . '"';
			$out .= $this->add_extra_params( 'img' );
			$out .= ' />' . "\n";

			return $out;
		}

		// **************************************************
		//	createH
		/*!
			@brief Create header tag, eg. h1-h6

			@param $size Size of header, 1-6

			@param $text Title of header

			@return String
		*/
		// **************************************************
		public function createH( $size, $text )
		{
			$out = '<h' . $size;
			$out .= $this->add_extra_params( 'h' );
			$out .= '>' . $text . '</h' . $size . '>' . "\n";

			return $out;
		}

		// **************************************************
		//	createP
		/*!
			@brief Create paragraph

			@param $text Text inside <p> and </p> tags.

			@return String
		*/
		// **************************************************
		public function createP( $text )
		{
			$out = '<p';
			$out .= $this->add_extra_params( 'p' );
			$out .= '>' . $text;
			$out .= '</p>' . "\n";

			return $out;
		}

		// ************************************************** 
		//  createPre
		/*!
			@brief Create pre element
			@param $text Text inside <pre> and </pre> tags
			@returm String
		*/
		// ************************************************** 
		public function createPre( $text )
		{
			$out = '<pre';
			$out .= $this->add_extra_params( 'pre' );
			$out .= '>' . $text;
			$out .= '</pre>' . "\n";

			return $out;
		}

		// **************************************************
		// 	createDiv
		/*!
			@brief Create div-element

			@param $text Text inside div.

			@return String
		*/
		// **************************************************
		public function createDiv( $text )
		{
			$out = '<div';
			$out .= $this->add_extra_params( 'div' );
			$out .= '>' . "\n" . $text . '</div>' . "\n";
			
			return $out;
		}

		// **************************************************
		//	createSpan
		/*!
			@brief Create span-element

			@param $text Text inside <span> and </span> tags

			@return String
		*/
		// **************************************************
		public function createSpan( $text )
		{
			$out = '<span';
			$out .= $this->add_extra_params( 'span' );
			$out .= '>' . $text . '</span>' . "\n";

			return $out;
		}

		// **************************************************
		//	createTable
		/*!
			@brief Create HTML table and add rows CSS class
			  'odd' and 'even'.

			@param $values Array of values.

			@return Generated HTML in string.
		*/
		// **************************************************
		public function createTable( $values )
		{
			$out = '<table>';
			$tmp = 0;

			foreach( $values as $val )
			{
				if( $tmp == 2 )
					$tmp = 0;

				if( $tmp == 0 )
					$out .= '<tr class="odd">';
				else
					$out .= '<tr class="even">';

				$num_vals = count( $val );
				for( $i=0; $i < $num_vals; $i++ )
				{
					$out .= '<td>';
					$out .= $val[$i];
					$out .= '</td>';
				}

				$out .= '</tr>';
				$tmp++;

			}

			$out .= '</table>';
			return $out;
		}

		// **************************************************
		//	setMessage
		/*!
			@brief This will set message what can be later
			  seen by getMessage or showMessage.

			@param $msg Message
		*/
		// **************************************************
		public function setMessage( $msg )
		{
			$this->message['msg'] = $msg;
		}

		// **************************************************
		//	getMessage
		/*!
			@brief Read message from class private variable.
			  This message is stored via setMessage method.

			@return String.
		*/
		// **************************************************
		public function getMessage()
		{
			return $this->message['msg'];
		}

		// ************************************************** 
		//  setClass
		/*!
			@brief Shortcut to setExtraParams where we only
			  define a class.
			@param $class_name CSS class name
		*/
		// ************************************************** 
		public function setClass( $class_name )
		{
			$this->setExtraParams( array( 'class' => $class_name ) );
		}

		// ************************************************** 
		//  setID
		/*!
			@brief Shortcut to setExtraParams where we only
			  define a ID.
			@param $id_name CSS ID name
		*/
		// ************************************************** 
		public function setID( $id_name )
		{
			$this->seExtraParams( array( 'id' => $id_name ) );
		}

		// **************************************************
		//	showMessage
		/*!
			@brief Creates a DIV with class message and shows
			  a message if any is stored in $message array.

			@return String.
		*/
		// **************************************************
		public function showMessage()
		{
			$message = $this->message;
			$params = $this->params;
			$out = '';

			if( $message['msg'] != '' )
			{
				$out .= '<div id="msg" class="message">' . "\n";

				// If there is icon what is set to params array, 
				// then add it if file exists.
				if( isset( $params['icon'] ) )
				{
					if( file_exists( $params['icon'] ) )
						$out .= $this->createImg( $params['icon'] );
				}

				// Add our message
				$out .= $message['msg'] . "\n";

				if( file_exists( 'icons/close_message.png' ) )
					$text = $this->createImg( 'icons/close_message.png' );
				else
					$text = 'Close';

				// JavaScript to hide element "msg" (eg. our msg div).
				// Seems to wok in Safari and Firefox at least.
				$js = 'document.getElementById(\'msg\').style.'
					. 'display=\'none\'; return false;';

				// Set extra parameters for our close-button/text.
				$this->setExtraParams( array(
					'class' => 'close_icon',
					'title' => 'Close this message',
					'onclick' => $js ) );

				$out .= $this->createLink( '#', $text );
				$out .= '</div>' . "\n";
			} 
			return $out;
		}

		// ************************************************
		//	add_extra_params
		/*!
			@brief Add extra parameters for items.

			@param $type Type of an element, like 'a', 'img' and so on.
			  This will define what parameters are supported.

			@return String.
		*/
		// ************************************************
		private function add_extra_params( $type )
		{
			if( is_null( $this->params ) )
				return;

			$supported = array();
			$out = '';

			// Commonly supported attributes. 
			// See http://s.runosydan.net/hZo8 for more info.
			$common = array( 'accesskey', 'class', 'contenteditable',
				'contextmenu', 'dir', 'draggable', 'hidden', 'id',
				'item', 'itemprop', 'lang', 'spellcheck', 'style',
				'subject', 'tabindex', 'title' );
			
			$mouse_events = array( 'onclick', 'ondblclick', 'ondrag',
				'ondragend', 'ondragenter', 'ondragleave', 'ondragover',
				'ondragstop', 'ondrop', 'onmousedown', 'onmousemove',
				'onmouseout', 'onmouseover', 'onmouseup', 'ommousewheel',
				'onscroll' );

			$common = array_merge( $common, $mouse_events );
			$specific = array();

			switch( $type )
			{
				// See http://s.runosydan.net/oku7 for more info.
				case 'a':
					$specific = array( 'href', 'hreflang', 'media',
						'ping', 'rel', 'target', 'type' );
					break;

				case 'img':
					$specific = array( 'alt', 'height', 'ismap', 'usemap',
						'width' );
					break;
			}

			foreach( $common as $val )
				$supported[] = $val;

			foreach( $specific as $val )
				$supported[] = $val;

			// Add supported extra parameters to output string.
			foreach( $this->params as $key => $val )
			{
				if( in_array( $key, $supported ) )
					$out .= ' ' . $key . '="' . $val . '"';
			}

			// Empty this array
			$this->params = null;

			// Return our string.
			return $out;
		}

		// ************************************************
		//	include_files
		/*!
			@brief Create javascript or CSS include HTML code.

			@param $type 'css' or 'js'.

			@param $files Filename. If array, multiple files are
			  included. If null, none.

			@return String.
		*/
		// ************************************************
		private function include_files( $type, $files )
		{
			$out = '';

			// Do not add anything if value was null as it is by default.
			if( is_null( $files ) )
				return $out;

			// Define tags for CSS and JavaScript.
			if( $type == 'css' )
			{
				$str_start = '<link rel="stylesheet" href="';
				$str_end = '" />' . "\n";
			}
			else
			{
				$str_start = '<script type="text/javascript" src="';
				$str_end = '"></script>' . "\n";
			}

			// Create HTML for file/files.
			if( is_array( $files ) )
			{
				foreach( $files as $file )
					$out .= $str_start . $file . $str_end;
			}
			else
			{
				$out .= $str_start . $files . $str_end;
			}

			return $out;
		}

	}

?>
