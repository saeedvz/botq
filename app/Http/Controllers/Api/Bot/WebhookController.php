<?php

namespace App\Http\Controllers\Api\Bot;

use App\Http\Controllers\Controller;
use Telegram;
use App\Channel;

class WebhookController extends Controller
{
    public function handle($token)
    {
        if ($token == env('TELEGRAM_BOT_TOKEN')) {
            $updates = Telegram::getWebhookUpdates();
            if (isset($updates['entities']) && isset($updates['entities'][0]['type']) && $updates['entities'][0]['type'] == 'bot_command') {
                return response()->json(true);
            }

            if (isset($updates['callback_query'])) {
                $username = $updates['callback_query']['from']['username'];
                $channel = Channel::find($updates['callback_query']['data']);
                try {
                    if ($channel && $channel->channel_users()->where('username', '=', $username)->first()) {
                        $message = $updates['callback_query']['message']['reply_to_message'];
                        if (isset($message['text'])) {
                            Telegram::setAsyncRequest(true)->sendMessage([
                                'chat_id' => '@' . $channel->username,
                                'text' => $this->cleanText($channel, $message['text'])
                            ]);
                        }
                        if (isset($message['photo'])) {
                            $photo = $message['photo'][count($message['photo']) - 1]['file_id'];
                            Telegram::setAsyncRequest(true)->sendPhoto([
                                'chat_id' => '@' . $channel->username,
                                'photo' => $photo,
                                'caption' => isset($message['caption']) ? $this->cleanText($channel, $message['caption']) : ''
                            ]);
                        }
                        if (isset($message['video'])) {
                            Telegram::setAsyncRequest(true)->sendVideo([
                                'chat_id' => '@' . $channel->username,
                                'video' => $message['video']['file_id'],
                                'caption' => isset($message['caption']) ? $this->cleanText($channel, $message['caption']) : ''
                            ]);
                        }
                        if (isset($message['document'])) {
                            Telegram::setAsyncRequest(true)->sendDocument([
                                'chat_id' => '@' . $channel->username,
                                'document' => $message['document']['file_id'],
                                'caption' => isset($message['caption']) ? $this->cleanText($channel, $message['caption']) : ''
                            ]);
                        }
                        if (isset($message['voice'])) {
                            Telegram::setAsyncRequest(true)->sendVoice([
                                'chat_id' => '@' . $channel->username,
                                'voice' => $message['voice']['file_id'],
                                'caption' => isset($message['caption']) ? $this->cleanText($channel, $message['caption']) : ''
                            ]);
                        }
                        if (isset($message['audio'])) {
                            Telegram::setAsyncRequest(true)->sendAudio([
                                'chat_id' => '@' . $channel->username,
                                'audio' => $message['audio']['file_id'],
                                'caption' => isset($message['caption']) ? $this->cleanText($channel, $message['caption']) : ''
                            ]);
                        }
    
                        return response()->json(true);
                    }
                } catch (\Exception $e) {
                    return response()->json(true);
                }
            } else {
                if (isset($updates['message'])) {
                    $username = $updates['message']['from']['username'];
                    $channels = Channel::whereHas('channel_users', function ($query) use ($username) {
                        $query->where('username', '=', $username);
                    })->get();
                    if ($channels) {
                        $keyboard = [];
                        foreach ($channels as $channel) {
                            array_push($keyboard, [
                                ['text' => $channel->name, 'callback_data' => $channel->id]
                            ]);
                        }
                        Telegram::sendMessage([
                            'chat_id' => $updates['message']['chat']['id'],
                            'text' => __('Chose Channel'),
                            'reply_to_message_id' => $updates['message']['message_id'],
                            'reply_markup' => json_encode([
                                'inline_keyboard' => $keyboard
                            ])
                        ]);
                    }
                }
            }
        }
        return response()->json(true);
    }

    private function cleanText(Channel $channel, $text)
    {
        foreach ($channel->user->keywords as $keyword) {
            $text = str_replace($keyword->keyword, $keyword->replace, $text);
        }

        return $text;
    }
}
