<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Api\V1\Model\CommonModel;
use Illuminate\Support\Facades\Validator;
use Exception;
use JWTAuth;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\User;


/**
 * api/CustomerController 
 * 
 * PHP version 5.6
 * 
 * @category  Laravel 5.4
 * @copyright 2017
 * 
 */
class CustomerController extends ApiBaseController {

    const FILE_SUB_DIR = 'user';

    /*
      |--------------------------------------------------------------------------
      | Password Reset Controller
      |--------------------------------------------------------------------------
      |
      | This controller is responsible for handling password reset requests
      | and uses a simple trait to include this behavior. You're free to
      | explore this trait and override any methods you wish to tweak.
      |
     */

use ResetsPasswords;

    /**
     *
     * @var App\Product 
     */
    protected $_commonModel = NULL;

    /**
     *
     * @var App\Product 
     */
    protected $_userModel = NULL;

    /**
     * Function to Instatntiate CommonModel Model.
     * 
     * @package api/CustomerController
     * @return object App\CommonModel Model
     */
    private function _getCommonModel() {
        if ($this->_commonModel == NULL) {
            $this->_commonModel = new CommonModel();
        }
        return $this->_commonModel;
    }

    /**
     * Function to Instatntiate User Model.
     * 
     * @package api/CustomerController
     * @return object App\User Model
     */
    private function _getUserModel() {
        if ($this->_userModel == NULL) {
            $this->_userModel = new User();
        }
        return $this->_userModel;
    }

    /**
     * 
     * @OA\Post(
     *   path="/api/login",
     *   summary="To login to application",
     *     tags={"Login"},
     *     description="Method to login via API",
     *     operationId="login",
     *     deprecated=false,
     *     @OA\Parameter(name="project-device-id",
     *              in="header",
     *              description="This is unique device identifier.",
     *              required=true,
     *              @OA\Schema(           type="string",        ),),
     *     @OA\Parameter(name="project-device-type",
     *             in="header",
     *              description="This is device type.e.g: ios",
     *              required=true,
     *              @OA\Schema(           type="string",        ),),
     *     @OA\Parameter(name="Accept",
     *              in="header",
     *              description="application/json,",
     *              required=true,
     *              @OA\Schema(           type="string",        ),),
     *     @OA\Parameter(name="Content-Type",
     *              in="header",
     *              description="Content-Type",
     *              required=true,
     *              @OA\Schema(           type="string",        ),),
     @OA\RequestBody(
     *       required=false,
     *       @OA\MediaType(
     *           mediaType="application/x-www-form-urlencoded",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="email",
     *                   description="User email",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="password",
     *                   description="User password",
     *                   type="string"
     *               ),
     *           )
     *       )
     *   ),
     *      @OA\Response(
     *              response=200,
     *              description="User details with token."
     *      ),
     *      @OA\Response(
     *          response="default",
     *          description="Error message with details."
     *      ),
     *      @OA\Response(
     *          response=400, 
     *          description="Invalid username/password supplied."
     *      ),
     *      @OA\Response(
     *          response=500, 
     *          description="Application issue, Please contact API maintenance Team."
     *      )
     * )
     */

    /**
     * Method to login via API
     *
     * @package api/CustomerController
     * @return Object $serviceResponse
     */
    public function doLogin(Request $request) {
        $response = $this->responseGenerator;
        try {
            $rules = array(
                'email'     => 'required|email|max:255',
                'password'  => 'required|min:8',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $response->setResponseStatus(FALSE);
                $response->setResponseMessage(trans('messages.validation_error'));
                $response->setMessages($validator->errors()->toArray());
                $response->setStatus(FALSE);
                $response->setMessage(trans('messages.validation_error'));
            } else {
                $userDetails = $this->_getCommonModel()->getUserdetailsWithToken($request->only('email', 'password'));
                $this->_getUserData($userDetails);
                $response->setStatus(TRUE);
                $response->setMessage(trans('messages.success'));
            }
        } catch (Exception $ex) {
            $message = trans('messages.common_error');
            $response->setMessage($message);
            $debugTrace = $ex->getMessage() . "|" . $ex->getFile() . "|" . $ex->getLine();
            $this->handleAPIErrorMessages($debugTrace);
        }
        $serviceResponse = $response->getServiceResponse();
        return $serviceResponse;
    }
    
    /**
     * 
     * @OA\Get(
     *   path="/api/logout",
     *   summary="To logout of application",
     *     tags={"Logout"},
     *     description="Method to logout via API",
     *     security={
     *          {"api_auth": {}},
     *      },
     *     @OA\Parameter(name="project-device-id",
     *              in="header",
     *              description="This is unique device identifier.",
     *              required=true,
     *              @OA\Schema(           type="string",        ),
     *              ),
     *     @OA\Parameter(name="project-device-type",
     *              in="header",
     *              description="This is device type.e.g: ios",
     *              required=true,
     *              @OA\Schema(           type="string",        ),
     *              ),
     *     @OA\Parameter(name="Accept",
     *              in="header",
     *              description="application/json",
     *              required=true,
     *              @OA\Schema(           type="string",        ),
     *              ),
     *     @OA\Parameter(name="Content-Type",
     *              in="header",
     *              description="Content-Type",
     *              required=true,
     *              @OA\Schema(           type="string",        ),
     *              ),
     *     @OA\Response(
     *              response=200,
     *              description="User details with token."
     *      ),
     *      @OA\Response(
     *          response="default",
     *          description="Error message with details"
     *      ),
     *      @OA\Response(
     *          response=400, 
     *          description="Invalid token supplied."
     *      ),
     *      @OA\Response(
     *          response=500, 
     *          description="Application issue, Please contact API maintenance Team."
     *      )
     * )
     */

    /**
     * Method to logout in API
     * 
     * @package api/CustomerController
     * @param Request $request | required token
     * @return Object $serviceResponse
     */
    public function logout(Request $request) {
        $response = $this->responseGenerator;
        try {
            if (JWTAuth::invalidate(JWTAuth::getToken()) == 1) {
                $response->setResponseMessage(trans('messages.logout_success'));
                $response->setResponseStatus(TRUE);
            } else {
                $response->setResponseStatus(FALSE);
                $response->setResponseMessage(trans('messages.token_invalid'));
            }
            $response->setStatus(TRUE);
            $response->setMessage(trans('messages.success'));
        } catch (Exception $ex) {
            $message = trans('messages.common_error');
            $response->setMessage($message);
            $debugTrace = $ex->getMessage() . "|" . $ex->getFile() . "|" . $ex->getLine();
            $this->handleAPIErrorMessages($debugTrace);
        }
        $serviceResponse = $response->getServiceResponse();
        return $serviceResponse;
    }
    
    /**
     * Api to provide User Data.
     * 
     * @param Object $userDetails
     * @param Boolean $tokenRequired
     */
    public function _getUserData($userDetails, $tokenRequired = TRUE) {
        if ($userDetails['status']) {
            $data = array(
                'id' => $userDetails['data']->id,
                'user_role' => $userDetails['data']->fk_users_role,
                'user_name' => $userDetails['data']->user_name,
                'first_name' => $userDetails['data']->first_name,
                'last_name' => $userDetails['data']->last_name,
                'email' => $userDetails['data']->email,
                'phone' => $userDetails['data']->phone,
                'image' => $userDetails['data']->image,
            );
            if ($tokenRequired) {
                $data = array_merge($data, ['api_token' => $userDetails['token']]);
                if($userDetails['data']->is_active != 1) {
                    JWTAuth::invalidate(JWTAuth::getToken());
                    $this->responseGenerator->setResponseData('');
                    $this->responseGenerator->setResponseStatus(FALSE);
                    $this->responseGenerator->setResponseMessage(trans('messages.user_inactive'));
                    return;
                }
            }
            $fileSubDir = 'user';
            $data['image_base_url'] = $this->getBaseDirectoryForImages($fileSubDir, FALSE);
            $this->responseGenerator->setResponseData($data);
            $this->responseGenerator->setResponseStatus(TRUE);
        } else {
            $this->responseGenerator->setResponseStatus(FALSE);
            $this->responseGenerator->setResponseMessage(trans('messages.user_invalid'));
        }
    }
    

}
