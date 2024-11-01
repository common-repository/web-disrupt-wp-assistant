<?php
/**
 * A helper library with common PHP reusable functions
 *
 */

class Web_Disrupt_WordPress_Assistant_Helpers {
    
    public function __construct() {

    }

    /**
     * Deletes everything inside a folder. The arguments are the directory path which
     * is the folder path that should everything be deleted. The next is a bool which 
     * will also delete the folder.
     *
     * @param [type] $dir
     * @param [type] $deleteRootToo
     * 
     * @return void
     * 
     */
    public function unlink_recursive($dir, $deleteRootToo)
    {
        if(!$dh = @opendir($dir))
        {
            return;
        }
        while (false !== ($obj = readdir($dh)))
        {
            if($obj == '.' || $obj == '..')
            {
                continue;
            }
            if (!@unlink($dir . '/' . $obj))
            {
                $this->unlink_recursive($dir.'/'.$obj, true);
            }
        }
        closedir($dh);
    
        if ($deleteRootToo)
        {
            @rmdir($dir);
        } 
        return;
    } 


    /**
     * This function is used to recursively copy all the files in a folder and duplicate them. 
     * The arguments require a source folder and a destination folder path
     *
     * @param [type] $source
     * @param [type] $dest
     * 
     * @return void
     * 
     */
    public function copy_recursive($source, $dest)
    {
        /* if destination is a directory then create it if it doesn't exist */
        if(!file_exists($dest)){
            mkdir($dest, 0755);
        }
        /* Loop through and copy files and create directories as needed */
        foreach (
        $iterator = new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
        \RecursiveIteratorIterator::SELF_FIRST) as $item
        ) {
            if ($item->isDir()) {
                if(!file_exists($dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName())){
                    mkdir($dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName(), 0755);
                }
            } else {
                copy($item, $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());     
            }
        }
    }


    /**
     * This function removes a value in a list by its key. The arguments needed are the array,
     * the name of the key and the value of that key that needs to be removed.
     *
     * @param [type] $array
     * @param [type] $name
     * @param [type] $value
     * 
     * @return void
     * 
     */
    public function remove_from_array_by_name ($array, $name, $value )
    {
        for ($i=0; $i < count($array); $i++) { 
            if($array[$i][$name] == $value){
                array_splice($array, $i, 1);
            }
        }
        return $array;
    }


    /**
     * This function will return everything inside a tag
     *
     * @param [type] $data
     * @param [type] $start_tag
     * @param [type] $end_tag
     * 
     * @return void
     */
    public function grab_data_inside_tag($data, $start_tag, $end_tag){
        $final_output = explode($start_tag, $data);
        $final_output = explode($end_tag, $final_output[1]);
        return $final_output[0];
    }


    /**
     * This function will return a string after deleting everything between a specific start and end tag
     * This is used for filtering out the custom data classes when importing the config.less file
     *
     * @param [type] $beginning
     * @param [type] $end
     * @param [type] $string
     * 
     * @return void
     * 
     */  
    public function filter_out_everything_between_these_tags($beginning, $end, $string) {
        $finalString = $string;
        for($i = 0; $i < substr_count($string, $beginning); $i++){
            $beginningPos = strpos($finalString, $beginning);
            $endPos = strpos($finalString, $end);
            $replaceString = substr($finalString, $beginningPos, ($endPos + strlen($end)) - $beginningPos);
            $finalString = str_replace($replaceString, '', $finalString);
        }
        return $finalString;
    }

    /**
     * This function take a directory and filter through and returns a unique name. 
     * Set the "directory", "name.ext", and "particle" and it will do the rest. 
     *
     * @param [type] $dir
     * @param [type] $filename
     * @param [type] $particle
     * @return void
     * 
     */
    public function unique_name_in_dir($dir, $filename, $particle){
        $extention = explode(".", $filename);
        $filename = $extention[0];
        if(isset($extention[1])){
            $extention = ".".$extention[1];
        } else {
            $extention = "";
        }
        $directory = glob($dir."*".$extention);    
        $i = 1;
        $returnName = $filename.$particle.$i.$extention;
        foreach ($directory as $file) {
            $file_path_final = explode("/", $file);
            $file_name_final = $file_path_final[count($file_path_final)-1];
            if($filename.$particle.$i.$extention == $file_name_final){
                $i += 1;
                $returnName = $filename.$particle.$i.$extention;   
            }
        }
    return $returnName; 
    }
    

}