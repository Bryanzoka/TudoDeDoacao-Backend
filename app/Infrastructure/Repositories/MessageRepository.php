<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\IMessageRepository;
use App\Domain\Entities\Message;
use App\Infrastructure\Models\MessageModel;

class MessageRepository implements IMessageRepository
{
    public function getById(int $id): ?Message
    {
        $model = MessageModel::where('id', '=', $id)->first();

        if (!$model) {
            return null;
        }

        return Message::restore(
            $model->id,
            $model->sender_id,
            $model->recipient_id,
            $model->text,
            $model->read_at
        );
    }

    public function getByUsersIds(int $senderId, int $recipientId, int $limit = 25, int $offset = 0): array
    {
        return MessageModel::where(function ($q) use ($senderId, $recipientId){
            $q->where('sender_id', '=', $senderId)->where('recipient_id', '=', $recipientId);
        })->orWhere(function ($q) use ($senderId, $recipientId){
            //treats both the receiver and the sender as equals.
            $q->where('sender_id', '=', $recipientId)->where('recipient_id', '=', $senderId);
        })->orderBy('created_at', 'asc')->offset($offset)->limit($limit)->get()->map(fn ($m) => Message::restore(
            $m->id,
            $m->sender_id,
            $m->recipient_id,
            $m->text,
            $m->read_at
        ))->toArray();
    }

    public function create(Message $message): void
    {
        MessageModel::create([
            'sender_id' => $message->getSenderId(),
            'recipient_id' => $message->getRecipientId(),
            'text' => $message->getText(),
            'read_at' => null
        ]);
    }

    public function update(Message $message): void
    {
        MessageModel::where('id', '=', $message->getId())->update([
            'read_at' => $message->getReadAt()->format('Y-m-d H:i:s')
        ]);
    }
}