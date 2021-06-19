<?php

namespace App\Actions;

use App\Models\ClientAdmin;
use Exception;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use Lorisleiva\Actions\Concerns\AsAction;

class StatusToggle
{
    use AsAction;

    public function handle($table, $status, $id)
    {
        try {
            DB::table($table)->where('id', $id)->update([
                'status' => $status
            ]);

            if($table == 'users' && $status == '0') {
                DB::table('sessions')->where('user_id', $id)->delete();
            }

            if($table == 'tenants') {
                $client_admins = ClientAdmin::where('tenant_id', $id)->get();
                foreach($client_admins as $admin) {
                    $admin->user()->update([
                        'status' =>$status
                    ]);

                    if($status == '0') {
                        DB::table('sessions')->where('user_id', $admin->user->id)->delete();
                    }
                }
            }

            return true;
        } catch (Throwable $e) {
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function asController(Request $request, $id)
    {
        return $this->handle($request->table, $request->status, $id);
    }

    public function jsonResponse(bool $res, Request $request) : Response
    {
        if($res) {
            return response('', 200);
        } else {
            return response('', 500);
        }
    }
}
