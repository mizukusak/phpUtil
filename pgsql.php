<?php
namespace util;

class PgSQL {
    /**
     * PHP の配列を PostgreSQL の VALUES リストに変換
     * 
     * dirty data はこのメソッドによる変換を行わないこと
     * @param array $array 配列
     * @param string $tblName 仮テーブル名
     * @return string VALUES リスト文字列
     */
    private function arrayToPgValuesList(array $array, $tblName)
    {
        $result = "";
        if (!empty($array[0])) {
            $result = "(VALUES ";
            // 一番最初の要素から key 名を取得
            $keyList = array_keys($array[0]);

            foreach ($array as $value) {
                // すべての要素をクォートする
                $quotedData = array_map(function ($v) {
                    return "'${v}'";
                }, $value);

                $result .= "(" . implode(",", $quotedData) . "),";
            }

            // 最後の文字を削る
            $result = substr($result, 0, -1);
            $result .= ") as ${tblName} (". implode(",", $keyList) .")";
        }
        return $result;
    }
    /*
    test:
    echo arrayToPgValuesList([[
        "a"=>1,    
        "n"=>2    
    ]], "hoge");
    */
}
