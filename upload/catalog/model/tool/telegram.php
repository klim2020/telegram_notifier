<?php


class ModelToolTelegram extends Model {
   public function getModuleByName($name) {
        $qry = "SELECT * FROM `" . DB_PREFIX . "module` WHERE `code` = 'telegram' AND `name` = '".$name."' ORDER BY `name`";

        $query = $this->db->query($qry);

        return $query->row;
    }

    function sendMessageByName($botname,$text,$format='Markdown'){

        $res = unserialize($this->getModuleByName($botname)['setting']);
        $this->mylog->write(serialize($res->row));
        $website="https://api.telegram.org/bot".$res['bot_token'];
        $this->mylog->write($website);
        $params=[
            'chat_id'=>$res['chat_id'],
            'text'=>$text,
            'parse_mode'=>$format
        ];
        $this->mylog->write($params);

        $ch = curl_init($website . '/sendMessage');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

}
?>