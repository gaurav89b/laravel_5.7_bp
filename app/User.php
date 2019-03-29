<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisteredUserDetail;
use Exception;
use App\Http\Helper\CommonHelper;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fk_users_role', 'first_name', 'last_name', 'email', 'password', 'is_active', 'updated_at', 'created_at', 'phone', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
    
    public function getUserForListing() {
        $users = User::all();
        
        return $users;
    }
    
    public function getAdminUserForListing($aUserRoles = []) {
        $users = User::all();
        
        return $users;
    }
    
    
    
    public static function generatePassword()
    {
      // Generate random string. 
      return str_random(8);
    }

    /**
     * The function to save user detail.
     *
     * @var array
     * 
     * return UserId
     */
    public function saveUserDetails($userDetails) {
        $aResponse = [
            'status' => false,
            'message' => 'Something went wrong',
            'data' => [],
        ];
        try {
            
            DB::beginTransaction();
            $password = User::generatePassword();
            $aInputRequest = $userDetails;
            $aInputRequest['password'] = bcrypt($password);
            $aInputRequest['created_at'] = CommonHelper::getCurrentDateTime();
            $aInputRequest['updated_at'] = CommonHelper::getCurrentDateTime();
            $aInputRequest = array_merge($aInputRequest, [
                'password' => $aInputRequest['password'],
                'created_at' => $aInputRequest['created_at'],
                'updated_at' => $aInputRequest['updated_at'],
                'is_active' => config('app_constants.status.active')
            ]);
            $aUserInputRequest = $aInputRequest;
            $user = User::create($aUserInputRequest);
            $userId = $user->id;
            $aUserInputRequest['user_id'] = $userId;
            
            DB::commit();
            // push email in queue
            $this->sendRegistrationEmail($user, $password);
            $aResponse['status'] = true;
            $aResponse['data']['user_id'] = $userId;
        } catch (Exception $ex) {
            DB::rollback();
            CommonHelper::event(CommonHelper::getExceptionMessageString($ex), CommonHelper::USER_LOG_FILE, CommonHelper::DAILY);
        }
        return $aResponse;
    }
    
    

    /**
     * 
     * @param object $user
     * @param string $password
     */
    public function sendRegistrationEmail($user, $password) {
        try {
            $data = new \stdClass();
            $data->toName = $user->first_name;
            $data->toEmail = $user->email;
            $data->toPassword = $password;
            $data->subject = config('app.name'). ' User Registration';
            $data->templateId = 'emails.userDetails';
            Mail::send(new RegisteredUserDetail($data));
        } catch (Exception $ex) {
            CommonHelper::event(CommonHelper::getExceptionMessageString($ex), CommonHelper::USER_LOG_FILE, CommonHelper::DAILY);
        }
    }

    
    
    public function updateUser($userId, $aUserInputRequest) {
        $aUserUpdateRequest = array_only($aUserInputRequest, ['first_name', 'last_name', 'email', 'updated_at', 'is_active', 'password', 'image']);
        User::where('id', $userId)
                ->update($aUserUpdateRequest);
        
        
    }
}
