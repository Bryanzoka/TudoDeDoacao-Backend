<?php

namespace App\Http\Controllers\Api;

use App\Application\Dtos\Messages\CreateMessageDto;
use App\Application\Dtos\Messages\GetMessagesDto;
use App\Application\UseCases\Messages\CreateMessage;
use App\Application\UseCases\Messages\GetMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\Messages\MessageIndexRequest;
use App\Http\Requests\Messages\MessageStoreRequest;
use App\Http\Resources\MessageResource;
use Exception;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(MessageIndexRequest $request, GetMessages $useCase)
    {
        try {
            $messages = $useCase->handle(GetMessagesDto::create(
                auth()->id(),
                $request->query('recipient_id'),
                $request->query('limit', 25),
                $request->query('offset', 0)
            ));

            return response()->json(['messages' => MessageResource::collection($messages)], 200);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), $ex->getCode());
        }
    }

    public function store(MessageStoreRequest $request, CreateMessage $useCase)
    {
        $data = $request->validated();
        try {
            $useCase->handle(CreateMessageDto::create(
                auth()->id(),
                $data['recipient_id'],
                $data['text']
            ));

            return response()->json(null, 204);
        } catch (Exception $ex) {
            return response()->json($ex->getMessage(), 400);
        }
    }

    public function show(int $id)
    {
        
    }

    public function update(Request $request, string $id)
    {
        //
    }
}
