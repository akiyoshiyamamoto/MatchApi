<?php

namespace App\Http\Controllers;

use App\Domain\Chat\Services\ChatService;
use App\Domain\Chat\Services\MessageService;
use App\Http\Requests\GetConversationRequest;
use App\Http\Resources\ChatResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ChatController extends Controller
{
    private $chatService;
    private $messageService;

    public function __construct(ChatService $chatService, MessageService $messageService)
    {
        $this->chatService = $chatService;
        $this->messageService = $messageService;
    }

    public function show($id)
    {
        $chat = $this->chatService->getById($id);

        if (!$chat) {
            return response()->json(['message' => 'Chat not found'], 404);
        }

        return new ChatResource($chat);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user1_id' => 'required',
            'user2_id' => 'required',
        ]);

        $chat = $this->chatService->create($validated);

        return response()->json([
            'chat' => $chat,
            'message' => 'Chat created successfully'
        ], 201);
    }

    public function getConversation(GetConversationRequest $request): AnonymousResourceCollection
    {
        $userId = auth()->user()->id;
        $partnerId = $request->input('partner_id');
        $chats = $this->chatService->getConversation($userId, $partnerId);

        return ChatResource::collection($chats);
    }
}
