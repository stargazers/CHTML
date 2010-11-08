<?php
	
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
			@brief Create site bottom. Close </body> and </html>

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

			@param $keywords. Should be string, so multiple values
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

			// Define supported attributes for 'a'. 
			// See http://s.runosydan.net/oku7 for more info.
			if( $type == 'a' )
			{
				$specific = array( 'href', 'hreflang', 'media',
					'ping', 'rel', 'target', 'type' );
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
