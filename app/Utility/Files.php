<?php
namespace App\Utility;

/**
 *  This class is belong to Reasie
 *
 *  It is used to process data with file
 */

use Illuminate\Support\Facades\Input;

class Files {

    /**
    * @param $filename
    *
    * @return void
    */
    public static function delete($filename) {
        if (file_exists($filename)) {
          unlink($filename);
        }
    }

    /**
     * @param $fileImage
     * @param $prefixName
     * @param $basePath
     * @return string
     */
    public static function saveUploadImage($fileImage, $prefixName, $basePath) {
        $imagePath = '';
        if (Input::hasFile($fileImage) && Input::file($fileImage) !== null) {
            $imagePath = $basePath;
            $image = Input::file($fileImage);

            /* Remove space from image filename */
            $filename = $prefixName . '_' . str_replace(' ', '', $image->getClientOriginalName());
            $image->move($imagePath, $filename);
            $imagePath = $imagePath . '/' . $filename;
        }
        return $imagePath;
    }

    /**
     * @param $data
     * @param $objectImagePath
     * @param $fieldImage
     * @param $prefixName
     * @param $basePath
     * @param $storeDelete
     * @return null|string
     */
    public static function saveEditUploadImage($data, $objectImagePath, $fieldImage, $prefixName, $basePath, $storeDelete) {
        $imagePath = $objectImagePath;
        if (isset($data[$storeDelete]) && (int)$data[$storeDelete] == 1) {
            $imagePath = NULL;
        }
        if (Input::hasFile($fieldImage) && Input::file($fieldImage) !== null) {
            $imagePath = $basePath;
            $image = Input::file($fieldImage);

            /* Remove space from image filename */
            $filename = $prefixName . '_' . str_replace(' ', '', $image->getClientOriginalName());
            $image->move($imagePath, $filename);
            $imagePath = $imagePath . '/' . $filename;
            Files::delete($objectImagePath);
        }
        return $imagePath;
    }
}
