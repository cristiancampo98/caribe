<?php

namespace App\Http\Controllers;

use App\Traits\ClientTrait;
use Illuminate\Http\Request;

class ClientStorageController extends Controller
{
	use ClientTrait;

    public function getClients()
    {
    	return self::getClientsToOrder();
    }

    public function getClientsPaginate()
    {
        return self::getAllClientsPaginate();
    }

    public function getDocuments()
    {
        return self::getMultimediaByParams();
    }
}
