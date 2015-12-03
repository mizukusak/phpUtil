<?php
namespace util;

class PgSQL {
    /**
     * HashMap を PostgreSQL の VALUES リストに変換
     * 
     *  * dirty data はこのメソッドによる変換を行わないこと
     *  * 一要素以上必ず存在する前提
     * @param array $array 配列
     * @param string $tblName 仮テーブル名
     * @return string VALUES リスト文字列
     */
    public static function mapToPgValuesList(array $array, $tblName)
    {
        if (empty($array[0])) {
            return false;
        }

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
        $result .= ") as ${tblName}(". implode(",", $keyList) .")";
        return $result;
    }
}

/*
echo PgSQL::mapToPgValuesList([
    [
        "a"=>1,    
        "n"=>2    
    ],
    [
        "a"=>4,    
        "n"=>222    
    ]
], "hoge");
*/
