<?php

namespace App\Actions;

use Exception;
use Throwable;
use App\Models\Role;
use App\Models\User;
use App\Models\Contact;
use App\Models\ClientAdmin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ClientCustomer;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Validation\ValidationException;

class SaveOrUpdateClientGuestFromContact
{
    use AsAction;

    public function handle($email, $password, $customer_id, $tenant_id)
    {
        DB::beginTransaction();

        try {
            $clientCustomer = ClientCustomer::find($customer_id);
            $role = Role::find(3);

            if ($clientCustomer) {
                $clientCustomer->user()->update([
                    'email' => $email,
                    'password' => bcrypt($password)
                ]);

                $clientCustomer->user->givePermissionTo($role->permissions);

                $clientCustomer->update([
                    'email' => $email
                ]);

                DB::commit();
                return array(
                'clientCustomer' => $clientCustomer
            );
            }
            // dd($clientCustomer);
            // $role = Role::create([
            //         'name' => $tenant_id . '-' . 'Customer',
            //         'type' => 'customer',
            //         'tenant_id' => $tenant_id
            //     ]);

            if (User::where('email', $email)->exists()) {
                return array(
                'clientCustomer' => null,
                'err' => 'The email has already been taken'
            );
            }

            $user = User::create([
                'email' => $email,
                'password' => bcrypt($password),
                'role_id' => 3
            ]);

            $user->givePermissionTo($role->permissions);

            $customer = $user->clientCustomer()->create([
                'first_name' => 'Guest',
                'last_name' => 'User',
                'email' => $email,
                'tenant_id' => $tenant_id
            ]);

            if ($customer) {
                DB::commit();
                return array(
                'clientCustomer' => $customer
            );
            } else {
                DB::rollBack();
                return array(
                'clientCustomer' => null,
                'text' => 'unknown error occurred. please try again later'
            );
            }
        } catch (Throwable $e) {
            DB::rollBack();
            return null;
        } catch (Exception $e) {
            DB::rollBack();
            return null;
        }
    }

    public function asController(Request $request, $tenant_id)
    {
        return $this->handle($request->guest_email, $request->guest_password, $request->customer_id, $tenant_id);
    }

    public function jsonResponse(array $res, Request $request)
    {
        if ($res['clientCustomer']) {
            return response()->json([
                'type' => 'success',
                'client_guest_id' => $res['clientCustomer']->id,
                'client_guest_email' => $res['clientCustomer']->email,
                'client_guest_name' => $res['clientCustomer']->full_name,
                'client_guest_client' => $res['clientCustomer']->tenant->company
            ]);
        } else {
            return response()->json([
                'type' => 'error',
                'text' => $res['err']
            ]);
        }
    }
}
