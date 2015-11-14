<?php


namespace yii2utils\helpers;


class ArrayHelpers {

    /**
     * Extracts data by fields mapping
     * @param array $array
     * @param array $map
     * @return array
     *
     * for example:
     * $input = [
     *     ['id' => 1, 'name' => 'Potato'],
     *     ['id' => 2, 'name' => 'Orange'],
     *     ['id' => 3, 'name' => 'Apple']
     * ]
     *
     * convertByFieldsMapping($input, ['id' => 'value', 'name' => 'title'])
     * returns:
     * [
     *     ['value' => 1, 'title' => 'Potato'],
     *     ['value' => 2, 'title' => 'Orange'],
     *     ['value' => 3, 'title' => 'Apple']
     * ]
     *
     */
    static public function convertByFieldsMapping($array = [], $map = []) {
        $result = [];
        if(is_array($array) && $array) {
            foreach($array as $row) {
                $row_ = [];
                foreach(array_keys($row) as $key) {
                    if(isset($map[$key])) {
                        $row_[$map[$key]] = $row[$key];
                    }
                }
                if($row_) {
                    $result[] = $row_;
                }

            }
        }
        return $result;
    }



}