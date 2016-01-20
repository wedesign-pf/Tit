<?php

// +----------------------------------------------------------------------+
// | Copyright (c) 2012 Jamie Curnow                                      |
// +----------------------------------------------------------------------+
// | Author: Jamie Curnow <jc@jc21.com>                                   |
// +----------------------------------------------------------------------+
//
// $Id:$
//

    // The Class File location
    require_once('file_list.class.php');

    // Look for GET parameters that affect the display of files
    $path      = (isset($_GET['path'])  ? $_GET['path']  : '../');
    $order_by  = (isset($_GET['order']) ? $_GET['order'] : File_List::KEY_NAME);
    $order_dir = (isset($_GET['dir'])   ? $_GET['dir']   : File_List::ASC);
    $start     = (isset($_GET['start']) ? $_GET['start'] : 0);
    $limit     = (isset($_GET['limit']) ? $_GET['limit'] : 10);

    // Very important to sanitize the Path for security
    //$path      = sanitizePath($path);

    // Get started looking for files
    $file_list = new File_List();
    $listing   = $file_list->getListing($path, File_List::TYPE_BOTH, $order_by, $order_dir, $start, $limit);


?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<meta http-equiv="Content-Type" content="text/html;">
    	<title>File List Class Full Example</title>
        <link rel="stylesheet" type="text/css" href="outils/filelistclass/stylex.css" />
    </head>
    <body>

        <?php
        // Show a messge when there are no items in the top folder
        if (!$file_list->getLastItemCount() && !$file_list->getLastError() && !$path) {
            ?>
            <p align="center">This example requires that you add files to the subdirectory "files". Once you've done that, they will be listed<br />
            below and you can play with the example. Add more than <?php print $limit; ?> files to see some pagination.</p>
            <?php
        }
        ?>

        <!-- Begin Breadcrumbs -->
        <div id="breadcrumbs">
            <?php
            if ($file_list->getLastError()) {
                print '<p align="center" style="color:#f00;">'.$file_list->getLastError().'</p>';
            } else {
                print '<ul>';
                print '<li>You are here: &nbsp; <a href="'.getOrderLink(false, false).'">Home</a></li>';

                $path_items   = explode('/', $path);
                $current_path = '';
                foreach ($path_items as $folder) {
                    $current_path .= '/'.$folder;
                    print '<li>&raquo; <a href="'.getOrderLink(false, false).'&path='.$current_path.'">'.htmlspecialchars($folder).'</a></li>';
                }

                print '</ul>';
            }
            ?>
        </div>
        <!-- End Breadcrumbs -->

        <!-- Begin file table -->
        <div id="main">
            <table border="0" width="800" cellspacing="0">
                <thead>
                    <tr>
                        <td width="20">&nbsp;</td>
                        <td><a href="<?php print getOrderLink(File_List::KEY_NAME).'&path='.$path; ?>">Name</a></td>
                        <td><a href="<?php print getOrderLink(File_List::KEY_DATE).'&path='.$path; ?>">Date</a></td>
                        <td><a href="<?php print getOrderLink(File_List::KEY_SIZE).'&path='.$path; ?>">Size</a></td>
                        <td><a href="<?php print getOrderLink(File_List::KEY_EXT).'&path='.$path;  ?>">Extension</a></td>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    // Iterate over the items in this folder
                    if ($file_list->getLastItemCount()) {
                        foreach ($listing as $item) {
                            print '<tr>';
                            print '  <td width="20"><img src="'.($item[File_List::KEY_TYPE] == File_List::TYPE_FOLDER ? 'folder.png' : 'file.png').'" border="0" /></td>';

                            // Directories are traversable in this example
                            if ($item[File_List::KEY_TYPE] == File_List::TYPE_FOLDER) {
                                print '  <td><a href="'.getOrderLink(false, false).'&path='.$path.'/'.urlencode($item[File_List::KEY_NAME]).'">'.htmlspecialchars($item[File_List::KEY_NAME]).'</a></td>';
                            } else {
                                print '  <td>'.htmlspecialchars($item[File_List::KEY_NAME]).'</td>';
                            }

                            print '  <td>'.date('jS F, Y, g:i a', $item[File_List::KEY_DATE]).'</td>';
                            print '  <td>'.($item[File_List::KEY_TYPE] == File_List::TYPE_FILE ? niceSize($item[File_List::KEY_SIZE]) : '&nbsp;').'</td>';
                            print '  <td>'.($item[File_List::KEY_TYPE] == File_List::TYPE_FILE ? $item[File_List::KEY_EXT] : '&nbsp;').'</td>';
                            print '</tr>';
                        }

                        // Show pagination if there are enough items
                        print '<tfoot>';
                        print '  <tr>';

                        if ($file_list->getLastItemCount() > $limit || $start != 0) {
                            print '    <td colspan="3">'.getPagination($file_list->getLastItemCount(), $start, $limit).'</td>';
                        } else {
                            print '    <td colspan="3">&nbsp;</td>';
                        }

                        print '    <td colspan="2" align="right">Showing '.($start + 1).' to '.(($start + $limit) > $file_list->getLastItemCount() ? $file_list->getLastItemCount() : ($start + $limit)).' of '.$file_list->getLastItemCount().' files &nbsp; </td>';
                        print '  </tr>';
                        print '<tfoot>';

                    } else {
                        // There aren't any files in the folder
                        print '<tr><td colspan="5" align"center" style="text-align:center;padding:10px;">There are no files in the folder</td></tr>';
                    }

                    ?>
                </tbody>
            </table>
        </div>
        <!-- End file table -->

        <div class="back">
            <p><a href="../docs/index.html">&laquo; Documentation</a></p>
        </div>

    </body>
</html>
<?php


    /**
     * sanitizePath
     * Removes relative items from the path
     *
     * @access public
     * @param  string  $path
     * @return string
     */
    function sanitizePath($path) {
        $path = trim($path, '/');
        $path = str_replace('../', '', $path);
        $path = str_replace('\\',  '/', $path);
        $path = trim($path, '.');
        $path = str_replace('//', '/', $path);
        $path = trim($path, '/');
        return $path;
    }


    /**
     * getOrderLink
     * Returns a URL with parameters for ordering based on what is currently selected
     *
     * @access public
     * @param  bool   $column
     * @param  bool   $change_direction
     * @return string
     */
    function getOrderLink($column = false, $change_direction = true) {
        global $order_by, $order_dir;

        if (!$column) {
            $column = $order_by;
        }

        if ($order_by == $column) {
            if ($change_direction) {
                $new_order_dir = ($order_dir == File_List::ASC ? File_List::DESC : File_List::ASC);
            } else {
                $new_order_dir = $order_dir;
            }
        } else {
            $new_order_dir = File_List::ASC;
        }

        return $_SERVER['PHP_SELF'].'?order='.$column.'&dir='.$new_order_dir;
    }


    /**
     * niceSize
     * Formats bytes into human readable file sizes
     *
     * @access public
     * @param  int    $bytes
     * @return string
     */
    function niceSize($bytes) {
        if ($bytes >= 1024) {
            $kb = $bytes / 1024;
            if ($kb >= 1024) {
                $mb = $kb / 1024;
                if ($mb >= 1024) {
                    $gb = $mb / 1024;
                    return number_format($gb, 1).'gb';
                }
                return number_format($mb, 1).'mb';
            }
            return number_format($kb, 1).'kb';
        }
        return $bytes.'b';
    }


    /**
     * getPagination
     * Returns HTML of Pagination links
     *
     * @access public
     * @param  int    $total_items
     * @param  int    $offset
     * @param  int    $rows_per_page
     * @return string
     */
    function getPagination($total_items, $offset, $rows_per_page) {
        global $path;

        $html  = 'Page: ';
        $pages = ceil($total_items / $rows_per_page);

        for ($page = 0; $page < $pages; $page++) {
            $html .= ' &nbsp; <a href="'.getOrderLink(false, false).'&start='.($rows_per_page * $page).'&path='.$path.'">'.($page + 1).'</a>';
        }

        return $html;
    }

?>