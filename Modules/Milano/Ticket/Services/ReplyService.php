<?php

namespace Milano\Ticket\Services;

use Milano\Media\Services\MediaFileService;
use Milano\Ticket\Models\Ticket;
use Milano\Ticket\Repositories\ReplyRepo;
use Milano\Ticket\Repositories\TicketRepo;
use Illuminate\Http\UploadedFile;

class ReplyService
{
    static function store(Ticket $ticket, $reply, $attachment)
    {
        $repo = new ReplyRepo();
        $ticketRepo = new TicketRepo();
        $media_id = null;
        if ($attachment && ( $attachment instanceof UploadedFile)){
            $media_id = MediaFileService::privateUpload($attachment)->id;
        }

        $reply = $repo->store($ticket->id, $reply, $media_id);
        if ($reply->user_id != $ticket->user_id){
            $ticketRepo->setStatus($ticket->id, Ticket::STATUS_REPLIED);
        }else{
            $ticketRepo->setStatus($ticket->id, Ticket::STATUS_OPEN);
        }
        return $reply;
    }
}
