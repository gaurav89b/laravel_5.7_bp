<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Exception;
use App\Configurations;
use Auth;
use App\StoreModel;
use App\User;
use App\PartnerAvailability;
use Log;

class ConfigurationsController extends Controller {

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function manage(Request $request) {
        $configModel = new Configurations();
        $aConfigurations = $configModel->getConfigurations();
        if ($request->isMethod('post')) {
            foreach ($request->all() as $key => $value) {
                if (empty($value)) {
                    return redirect()->back()->withInput($request->all())->withErrors(trans('admin/configurations.all_required_message'));
                }
            }
            $inputRequest = $request->all();
            unset($inputRequest['_token']);
            $configModel->saveConfigurations($inputRequest);
            \Session::flash('message', trans('admin/configurations.success_message'));
            $aConfigurations = $configModel->getConfigurations();
        }
        return view('admin.configurations.manage', compact('aConfigurations'));
    }

}
