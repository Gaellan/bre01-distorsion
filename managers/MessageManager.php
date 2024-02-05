<?php
/**
 * @author : Gaellan
 * @link : https://github.com/Gaellan
 */


class MessageManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findByChannel(int $channelId) : array
    {
        $query = $this->db->prepare('SELECT * FROM messages WHERE channel_id=:channel_id');
        $parameters = [
            "channel_id" => $channelId
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $messages = [];

        foreach($result as $item)
        {
            $um = new UserManager();
            $cm = new ChannelManager();

            $user = $um->findOne(intval($item["user_id"]));
            $channel = $cm->findOne(intval($item["channel_id"]));
            $message = new Message($item["content"], $channel, $user);
            $messages[] = $message;
        }

        return $messages;
    }

    public function delete(Message $message) : void
    {

    }
}