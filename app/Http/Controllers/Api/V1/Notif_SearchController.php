<?php

namespace App\Http\Controllers\Api\V1;

//use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\API_Controller;
use App\Http\Controllers\ClassSiteApi\Class_TicketController;
use App\User;
use App\Model\UserNotif;

class Notif_SearchController extends API_Controller {
    /**
     * get data about search   
     * get method
     * url : http://localhost:8000/api/v1/search
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/search",
     *   tags={"search"},
     *   operationId="search",
     *   summary="search",
     * @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="search",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *  ),
     *   @SWG\Response(
     *    response=200,
     *    description="success",
     *   ),
     *   @SWG\Response(
     *    response=400,
     *    description="error",
     *  )
     * )
     */
    public function search(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $search = isset($input['search']) ? $input['search'] : '';
        $response = [];
        $fields = [];
        $lang = 'ar';
        if ($search == "") {
            $fields['search'] = 'search';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        $user_id = 0;
        if (!empty($access_token)) {
            $data_user = User::user_access_token($access_token, 1);
            if (isset($data_user->id)) {
                $user_id = $data_user->id;
            }
        }
        $get_result = new Class_TicketController();
        $result_search = []; // $get_result->get_ResultSearchWord($search, $user_id, 1);
        //save word search and count num search about it
        // $add_search = $get_result->insert_SearchWord($request, $search, $user_id, 1);
        $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
        $response['data'] = $result_search;
        return response()->json($response, 200);
    }

    /**
     * get notifications of course   
     * get method
     * url : http://localhost:8000/api/v1/notifications
     *
     * @return response Json
     */

    /**
     * @SWG\Get(
     *   path="/notifications",
     *   tags={"notifications"},
     *   summary="notifications",
     *   operationId="notifications",
     *   @SWG\Parameter(
     *     name="access-token",
     *     in="header",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     *
     */
    public function notifications() {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $response = [];
        $fields = [];
        $lang = 'ar';
        if ($access_token == "") {
            $fields['access_token'] = 'access-token';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        if (!empty($access_token)) {
            $data_user = User::user_access_token($access_token, 1);
            if (isset($data_user->id)) {
                $user_id = $data_user->id;
                //data of notification
                //$get_notif = UserNotif::get_UserNotif($user_id, 1, 0);
                $data_notif = []; // UserNotif::SelectDataNotif($get_notif, 1);
                $count_notif = (string) count($data_notif);
                $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
                $response['count_notif'] = $count_notif;
                $response['data'] = $data_notif;
                return response()->json($response, 200);
            } else {
                $response = API_Controller::MessageData('USER_NOT_Found', $lang);
                return response()->json($response, 401);
            }
        } else {
            $response = API_Controller::MessageData('ACCESSTOKEN_NOT_Found', $lang);
            return response()->json($response, 401);
        }
    }

    /**
     * update notifications to read=1  
     * get method
     * url : http://localhost:8000/api/v1/update_notif
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/update_notif",
     *   tags={"notifications"},
     *   operationId="update_notif",
     *   summary="update notifications",
     * @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    required=true,
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="id",
     *    in= "formData",
     *    required=true,
     *    description="id of notification",
     *    type="number",
     *  ),
     *   @SWG\Response(
     *    response=200,
     *    description="success",
     *   ),
     *   @SWG\Response(
     *    response=400,
     *    description="error",
     *  )
     * )
     */
    public function update_notif(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $id = isset($input['id']) ? $input['id'] : '';
        $response = [];
        $fields = [];
        $lang = 'ar';
        if ($id == "") {
            $fields['id'] = 'id';
        }
        if ($access_token == "") {
            $fields['access_token'] = 'access-token';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
            $response['Message'] = API_Controller::MISSING_FIELD;
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        if (!empty($access_token)) {
            $data_user = User::user_access_token($access_token, 1);
            if (isset($data_user->id)) {
                $user_id = $data_user->id;
                //data of notification by id
                $data_notif = UserNotif::get_UserNotifID($id, $user_id, 1, 0, '');
                if (isset($data_notif->id)) {
//                    $get_class = new Class_TicketController();
//                    $get_class->Update_readArray($data_notif->posts->lang_id);
                    $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
                    return response()->json($response, 200);
                } else {
                    $response = API_Controller::MessageData('ERROR_MESSAGE', $lang);
                    return response()->json($response, 400);
                }
            } else {
                $response = API_Controller::MessageData('USER_NOT_Found', $lang);
                return response()->json($response, 401);
            }
        } else {
            $response = API_Controller::MessageData('ACCESSTOKEN_NOT_Found', $lang);
            return response()->json($response, 401);
        }
    }

}
