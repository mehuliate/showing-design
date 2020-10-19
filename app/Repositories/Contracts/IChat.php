<?php

namespace App\Repositories\Contracts;

interface IChat
{
    public function createParticipants($chartId, array $data);
    public function getUserChats();
}
