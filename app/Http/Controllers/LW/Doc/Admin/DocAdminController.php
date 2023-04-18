<?php
namespace App\Http\Controllers\LW\Doc\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DocAdminController extends Controller
{

	public function index()
	{
        return view('doc.admin.index');
	}

    public function dataTableI18n()
    {
    	return trans('pagination.i18n');
    }
}
