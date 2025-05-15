<?php

namespace App\Services;

use App\Models\ChatRoom;
use App\Models\ChatInvitees;
use App\Models\Chat;

class ChatService
{
    private ChatRoom $chatRoomModel;
    private ChatInvitees $inviteesModel;
    private Chat $chatModel;

    public function __construct()
    {
        $this->chatRoomModel = new ChatRoom();
        $this->inviteesModel = new ChatInvitees();
        $this->chatModel = new Chat();
    }

    // ==== Chat Room Operations ====

    public function createRoom(array $data): int
    {
        return $this->chatRoomModel->create($data);
    }

    public function updateRoom(int $id, array $data): bool
    {
        return $this->chatRoomModel->updateById($data, $id);
    }

    public function deleteRoom(int $id): bool
    {
        return $this->chatRoomModel->delete($id);
    }

    public function getRoomById(int $id): ?array
    {
        return $this->chatRoomModel->findById($id);
    }

    public function listRooms(): array
    {
        return $this->chatRoomModel->all();
    }

    // ==== Invitees Operations ====

    public function inviteUser(array $data): int
    {
        return $this->inviteesModel->create($data);
    }

    public function updateInvitee(int $id, array $data): bool
    {
        return $this->inviteesModel->updateById($data, $id);
    }

    public function removeInvitee(int $id): bool
    {
        return $this->inviteesModel->delete($id);
    }

    public function getInviteeById(int $id): ?array
    {
        return $this->inviteesModel->findById($id);
    }

    public function listInvitees(): array
    {
        return $this->inviteesModel->all();
    }

    public function getInviteesByRoom(int $roomId): array
    {
        return $this->inviteesModel->getInviteesByRoomId($roomId);
    }

    // ==== Chat Message Operations ====

    public function sendMessage(array $data): int
    {
        return $this->chatModel->create($data);
    }

    public function updateMessage(int $id, array $data): bool
    {
        return $this->chatModel->updateById($data, $id);
    }

    public function deleteMessage(int $id): bool
    {
        return $this->chatModel->delete($id);
    }

    public function getMessageById(int $id): ?array
    {
        return $this->chatModel->findById($id);
    }

    public function listMessages(): array
    {
        return $this->chatModel->all();
    }

    public function getMessagesByRoom(int $roomId): array
    {
        return $this->chatModel->getMessagesByRoomId($roomId);
    }

    public function getMessagesByInvitee(int $inviteeId): array
    {
        return $this->chatModel->getMessagesByRoomId($inviteeId);
    }

    // ==== Relationships and Statistics ====

    public function getRoomWithInviteesAndMessages(int $roomId): array
    {
        $room = $this->getRoomById($roomId);
        if (!$room) return [];

        $invitees = $this->getInviteesByRoom($roomId);
        $messages = $this->getMessagesByRoom($roomId);

        return [
            'room' => $room,
            'invitees' => $invitees,
            'messages' => $messages
        ];
    }

    public function countMessagesInRoom(int $roomId): int
    {
        return $this->chatModel->countMessagesInRoomId($roomId);
        
    }

    public function countRoomsByUser(int $userId): int
    {
        return $this->chatRoomModel->countRoomsByUserId($userId);
    }

    public function countInviteesInRoom(int $roomId): int
    {
        return $this->inviteesModel->countInviteesInRoomId($roomId);
    }
}
