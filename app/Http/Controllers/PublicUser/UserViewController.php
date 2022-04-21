<?php

namespace App\Http\Controllers\PublicUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\PlantDet;
use App\Models\PhotoPlant;
use App\Models\PlantName;
use App\Models\PlantMeth;
use App\Models\GraftDetail;
use App\Models\MethodGraft;
use DB;
use Illuminate\Support\Facades\Auth;

class UserViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('userview');
        //$this->mmsuqms = config('app.mmsuqms');
    }

    public function plant_show($id)
    {
        $user = Auth::user()->id;
        $d = PlantDet::where('plant_det.id', $id)->join('plant_name', 'plant_name.id', '=', 'plant_det.name_id')
            ->join('plant_variety', 'plant_variety.id', '=', 'plant_det.variety_id')
            //->leftJoin('plant_variety', 'plant_variety.id', '=', 'plant_det.variety_id')
            ->select([
                'plant_det.*',
                'plant_name.name',
                'plant_variety.description as variety'
            ])->first();


        $t = [];
        $gd = [];
        $c = null;
        $article_id = null;

        $md = PlantMeth::where('plant_det_id', $id)->first();
        // return $md;
        if ($md) {
            $mg = DB::table('methods_grafts')->where('meth_detail_id', $md->id)->get();
            $article_id = $md->id;
            foreach ($mg as $de) {
                // $gd = GraftDetail::where('id', $d->graft_id)->with(['files'])->get();

                $t[] = $de->graft_id;
            }
            $gd = GraftDetail::whereIn('id', $t)->with(['files'])->get();

            $c = DB::table('article_comment')->where('article_comment.meth_detail_id', $md->id)->where('article_comment.active', 1)
                ->join('users', 'users.id', '=', 'article_comment.user_id')
                ->select([
                    'article_comment.*',
                    'users..name'
                ])->orderBy('article_comment.created_at', 'DESC')->get();
        }

        // $a = [];
        //foreach ($det as $d) {
        $p = PhotoPlant::where('plant_det_id', $d->id)->first();
        $a = [
            'id' => $d->id,
            'name_id' => $d->name_id,
            'user_id' => $user,
            'article_id' =>   $article_id,
            'variety_id' => $d->variety_id,
            'description' => $d->description,
            'name' => $d->name,
            'variety' => $d->variety,
            'puto' => $p,
            'tech' => $gd,
            'comments' => $c,
            'updated_at' => $d->updated_at
        ];
        // }

        return $a;
    }

    public function search_engine(Request $request)
    {
        $search = $request->search;

        $posts = PlantMeth::join('plant_det', 'plant_det.id', '=', 'methods_details.plant_det_id')
            ->join('plant_name', 'plant_name.id', '=', 'plant_det.name_id')
            ->join('plant_variety', 'plant_variety.id', '=', 'plant_det.variety_id')
            ->where('methods_details.search_key', 'LIKE', "%{$search}%")
            ->orWhere('plant_name.name', 'LIKE', "%{$search}%")
            ->orWhere('plant_variety.description', 'LIKE', "%{$search}%")
            ->orWhereHas('grafts.graft', function ($q) use ($search) {
                return $q->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%')
                    ->orWhere('advantage', 'LIKE', '%' . $search . '%')
                    ->orWhere('disadvantage', 'LIKE', '%' . $search . '%')
                    ->orWhere('season', 'LIKE', '%' . $search . '%')
                    ->orWhere('pre_treatment', 'LIKE', '%' . $search . '%')
                    ->orWhere('post_treatment ', 'LIKE', '%' . $search . '%');
            })->get();

        /* $posts = MemoReceipt::leftJoin($this->mysqldb1 . '.pi1', 'pi1.id', '=', 'memo_receipt.employee_id')
            ->leftJoin($this->mysqldb1 . '.employment_info', 'employment_info.pi_number', '=', 'pi1.id')
            ->leftJoin($this->mysqldb1 . '.positions', 'positions.id', '=', 'employment_info.position_id')
            ->leftJoin($this->supplieslive . '.locations', 'locations.id', '=', 'memo_receipt.location_id')
            ->leftJoin('res_centers', 'res_centers.id', '=', 'memo_receipt.rc_id')
            ->join('users', 'users.id', '=', 'memo_receipt.user_id')
            ->orWhere('memo_receipt.par', 'LIKE', "%{$search}%")
            ->orWhere('res_centers.description', 'LIKE', "%{$search}%")
            ->orWhere('res_centers.acronym', 'LIKE', "%{$search}%")
            ->orWhere('locations.location', 'LIKE', "%{$search}%")
            ->orWhere('pi1.firstname', 'LIKE', "%{$search}%")
            ->orWhere('pi1.middlename', 'LIKE', "%{$search}%")
            ->orWhere('pi1.surname', 'LIKE', "%{$search}%")
            ->orWhere('pi1.idnumber', 'LIKE', "%{$search}%")
            ->orWhere('users.name', 'LIKE', "%{$search}%")
            ->orWhereHas('issuedserial.serial', function ($q) use ($search) {
                return $q->where('serial_number', 'LIKE', '%' . $search . '%');
            })
            ->orWhereHas('issuedserial.serial.details', function ($q) use ($search) {
                return $q->where('item_no', 'LIKE', '%' . $search . '%')
                    ->orWhere('par', 'LIKE', '%' . $search . '%');
            })
            ->select([
                'memo_receipt.*',
                'pi1.firstname',
                'pi1.surname',
                'pi1.middlename',
                'pi1.idnumber',
                'positions.position',
                'locations.location',
                'res_centers.description as rc_des',
                'res_centers.acronym as rc_acronym',
                'users.name'
            ])->get();*/
    }
}