<?php
//
// +----------------------------------------------------------------------+
// | File List Class (v1.0)                                               |
// +----------------------------------------------------------------------+
// | Get Listing of one or more directories, sorting and filtering        |
// +----------------------------------------------------------------------+
// | Copyright (c) 2012 Jamie Curnow                                      |
// +----------------------------------------------------------------------+
// | Author: Jamie Curnow <jc@jc21.com>                                   |
// +----------------------------------------------------------------------+
//
// $Id:$
//

    class File_List {

        // Constants for the associative Array key names. Customize to your language or preference
        const KEY_TYPE     = 'type';
        const KEY_NAME     = 'name';
        const KEY_DATE     = 'date';
        const KEY_SIZE     = 'size';
        const KEY_EXT      = 'ext';
        const KEY_FOLDER   = 'folder';

        // Constants for the sort order of the items in the folder
        const ASC          = 'asc';
        const DESC         = 'desc';

        // Constants for the type of items you want returned in the listing
        const TYPE_BOTH    = 'both';
        const TYPE_FOLDER  = 'folder';
        const TYPE_FILE    = 'file';


        /**
         * Callback for File Type and Name Filters
         *
         * @var     object
         * @access  private
         *
         **/
        private $_filter_callback = false;

        /**
         * Stores the last directory listing total size in bytes
         *
         * @var     int
         * @access  private
         *
         **/
        private $_last_size = 0;

        /**
         * Stores the last directory listing total number of files
         *
         * @var     int
         * @access  private
         *
         **/
        private $_last_item_count = 0;

        /**
         * Stores any errors that may be encountered
         *
         * @var     mixed
         * @access  private
         *
         **/
        private $_last_error = false;



        /**
         * Sets the Filter Callback object
         *
         * @access public
         * @param  object  $obj
         * @return void
         */
        public function setFilterCallback($obj) {
            $this->_filter_callback = $obj;
        }


        /**
         * Return the listing of a directory
         *
         * @access public
         * @param  mixed   $directories
         * @param  int     $type
         * @param  int     $order
         * @param  int     $direction
         * @param  int     $start
         * @param  int     $limit
         * @param  array   $extensions
         * @return array
         */
        public function getListing($directories, $type = self::TYPE_BOTH, $order = self::KEY_NAME, $direction = self::ASC, $start = 0, $limit = false, $displaySizes = false, $extensions = array()) {
            // Reset the Error
            $this->_last_error = false;

            if (!is_array($directories)) {
                $directories = array($directories);
            }

            // Initialize the array of items to be returned
            $listing = array();
            // Initialize var storing the total size of the listing
            $total_size = 0;

            foreach ($directories as &$directory) {
                $directory = rtrim($directory,'/');

                // Check Dir
                if (!is_dir($directory)) {
                    // Can't find this directory.
                    $this->_last_error = 'Directory '.$directory.' does not exist';
                    continue;
                }

                // Open this folder and process items
                $directory_handle = @opendir($directory);
                while (false !== ($file = @readdir($directory_handle))) {
                    if (substr($file, 0, 1) !== '.') {

                        // Directories
                        if ($this->_getItemType($directory.'/'.$file) == self::TYPE_FOLDER && ($type == self::TYPE_BOTH || $type == self::TYPE_FOLDER)) {
                            if ($type == self::TYPE_BOTH || $type == self::TYPE_FOLDER) {
                                $listing[] = array(
                                    self::KEY_TYPE    => self::TYPE_FOLDER,
                                    self::KEY_NAME    => $file,
                                    self::KEY_DATE    => filemtime($directory.'/'.$file),
                                    self::KEY_SIZE    => '',
                                    self::KEY_EXT     => '',
                                    self::KEY_FOLDER  => $directory,
                                );
                            }

                        // Files
                        } else if ($type == self::TYPE_BOTH || $type == self::TYPE_FILE) {
                            // Check that we are filtering extensions and this file has the correct extension
                            $file_ext = $this->_getExtension($file);
                            if (!count($extensions) || in_array($file_ext, $extensions)) {
							
                            if($displaySizes==1) {  $filesize = filesize($directory.'/'.$file); } else {  $filesize = 0; }
                                $total_size += $filesize;

                                $listing[] = array(
                                    self::KEY_TYPE    => self::TYPE_FILE,
                                    self::KEY_NAME    => $file,
                                    self::KEY_DATE    => @filemtime($directory.'/'.$file),
                                    self::KEY_SIZE    => $filesize,
                                    self::KEY_EXT     => $file_ext,
                                    self::KEY_FOLDER  => $directory,
                                );
                            }
                        }
                    }
                }
                @closedir($directory_handle);
            }

            // Sorting
            $listing = $this->_sort($listing, $type, $order, $direction);

            // Filter Callback
            if ($this->_filter_callback) {
                // Process the Listing
                $listing = call_user_func($this->_filter_callback, $listing);

                // Find out the filesize after it has passed through the callback
                $total_size = 0;
                foreach ($listing as $item) {
                    $total_size += $item[self::KEY_SIZE];
                }
            }

            // Item Count and Size
            $this->_last_item_count = count($listing);
            $this->_last_size       = $total_size;

            // Crop and Limit the items if desired. This must be done after sorting the result.
            if ($start || $limit) {
                $listing = array_slice($listing, $start, ($limit ? $limit : false));
            }

            return $listing;
        }


        /**
         * Return the last listing size in bytes
         *
         * @access public
         * @return int
         */
        public function getLastSize() {
            return $this->_last_size;
        }


        /**
         * Return the last listing count of items
         *
         * @access public
         * @return int
         */
        public function getLastItemCount() {
            return $this->_last_item_count;
        }


        /**
         * Return the last error. False means there was no error.
         *
         * @access public
         * @return mixed
         */
        public function getLastError() {
            return $this->_last_error;
        }


        /**
         * Return the type of item, either Folder or File
         *
         * @access private
         * @param  string  $item
         * @return string
         */
        private function _getItemType($item) {
            return (is_dir($item) ? self::TYPE_FOLDER : self::TYPE_FILE);
        }


        /**
         * Returns the extension of a file, lowercase
         *
         * @access private
         * @param  string  $file
         * @return string
         */
        private function _getExtension($file) {
            if (strpos($file, '.') !== false) {
                $tempext = strtolower(substr($file, strrpos($file,'.')+1,strlen($file)-strrpos($file,'.')));
                return strtolower(trim($tempext,'/'));
            }
            return '';
        }


        /**
         * Order the results of a directory listing
         *
         * @access private
         * @param  array   $array
         * @param  int     $type
         * @param  int     $by
         * @param  int     $direction
         * @return array
         */
        private function _sort($array, $type = self::TYPE_BOTH, $by = self::KEY_NAME, $direction = self::ASC) {
            $return_array = array();
            if (count($array) > 0) {
                // The Sorting
                $tmp_arr = array();
                foreach($array as $key => $value) {
                    $tmp_arr[$key] = $value[$by];
                }
                natcasesort($tmp_arr);
                if ($direction == self::DESC) {
                    $tmp_arr = array_reverse($tmp_arr, true);
                }
                foreach($tmp_arr as $key => $value) {
                    $return_array[] = $array[$key];
                }
                // If sorting by name, lets seperate the files from the dirs.
                if ($by == self::KEY_NAME && $type == self::TYPE_BOTH) {
                    $files = array();
                    $dirs  = array();
                    foreach ($return_array as $value) {
                        if ($value[self::KEY_TYPE] == self::TYPE_FILE) {
                            $files[] = $value;
                        } elseif ($value[self::KEY_TYPE] == self::TYPE_FOLDER) {
                            $dirs[] = $value;
                        }
                    }
                    if ($direction == self::DESC) {
                        $return_array = array_merge($files, $dirs);
                    } else {
                        $return_array = array_merge($dirs, $files);
                    }
                }
            }
            return $return_array;
        }


    }
