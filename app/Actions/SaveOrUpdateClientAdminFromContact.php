<?php

namespace App\Actions;

use App\Models\ClientAdmin;
use App\Models\Contact;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Throwable;

class SaveOrUpdateClientAdminFromContact
{
    use AsAction;

    public function handle($contact_id, $password)
    {
        DB::beginTransaction();

        try {
            $contact = Contact::findOrFail($contact_id);

            $existing_client_admin = ClientAdmin::where('tenant_id', $contact->tenant_id)->first();

            if($existing_client_admin) {

                $contact_client_admin = $contact->clientAdmin;

                if($contact_client_admin) {
                    $contact_client_admin->user->update([
                        'password' => bcrypt($password)
                    ]);

                    DB::commit();
                    return $contact_client_admin;
                }

                $existing_client_user = $existing_client_admin->user;

                $existing_client_admin->delete();
                $existing_client_user->delete();
            }

            $user = User::create([
                'email' => $contact->email,
                'password' => bcrypt($password),
                'role_id' => 2
            ]);

            // replace the data
            // $client_admin = $contact->replicate();

            // make into array for mass assign.
            //make sure you activate $guarded in your Staff model
            $client_admin = $contact->toArray();
            $client_admin['user_id'] = $user->id;
            $client_admin['contact_id'] = $contact->id;
            $client_admin['tenant_id'] = $contact->tenant_id;

            $saved_client_admin = ClientAdmin::create($client_admin);

            if($saved_client_admin) {
                DB::commit();
                return $saved_client_admin;
            } else {
                DB::rollBack();
                return null;
            }
        }  catch (Throwable $e) {
            DB::rollBack();
            return null;
        } catch (Exception $e) {
            DB::rollBack();
            return null;
        }

    }

    public function asController(Request $request, $id)
    {
        return $this->handle($request->contact_admin, $request->admin_password);
    }

    public function jsonResponse(ClientAdmin $clientAdmin = null, Request $request)
    {
        if($clientAdmin) {
            return response()->json([
                'type' => 'success',
                'client_admin_email' => $clientAdmin->email,
                'client_admin_name' => $clientAdmin->full_name,
                'client_admin_client' => $clientAdmin->tenant->company
            ]);
        } else {
            return response()->json([
                'type' => 'error',
                'text' => 'unknown error occurred. please try again later'
            ]);
        }
    }
}
