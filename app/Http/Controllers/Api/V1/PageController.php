<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\API_Controller;
//use App\Http\Controllers\ClassSiteApi\Class_TicketController;
use App\Http\Controllers\ClassSiteApi\Class_PageController;
use App\User;

class PageController extends API_Controller {
    /**
     * add new version   
     * get method
     * url : http://localhost:8000/api/v1/version
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/version",
     *   tags={"page"},
     *   operationId="version",
     *   summary="get version",
     * @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    description="default = ar (ar, en)" ,
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
    public function version(Request $request) {
        $input = $request->all();
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $version = array('v_ios' => 1, 'v_android' => 1);
        $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
        $response['data'] = $version;
        return response()->json($response, 200);
    }

    /**
     * add new home   
     * get method
     * url : http://localhost:8000/api/v1/home
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/home",
     *   tags={"page"},
     *   operationId="home",
     *   summary="get data of home",
     * @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    description="default = ar (ar, en)" ,
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="limit",
     *    in= "formData",
     *    description="default = 5" ,
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
    public function home(Request $request) {
        $input = $request->all();
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $limit = isset($input['limit']) ? $input['limit'] : 5;

        $data_page = new Class_PageController();
        $return_data = $data_page->Page_Home($lang, $limit, 1);
        $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
        $response['data'] = $return_data;
        return response()->json($response, 200);
    }

    /**
     * add new about   
     * get method
     * url : http://localhost:8000/api/v1/about
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/about",
     *   tags={"page"},
     *   operationId="about",
     *   summary="about",
     * @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    description="default = ar (ar, en)" ,
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
    public function about(Request $request) {
        $input = $request->all();
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $data_page = new Class_PageController();
        $return_data = $data_page->Page_about(1);
        $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
        $response['data'] = $return_data;
        return response()->json($response, 200);
    }

    /**
     * add new terms   
     * get method
     * url : http://localhost:8000/api/v1/terms
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/terms",
     *   tags={"page"},
     *   operationId="terms",
     *   summary="terms",
     * @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    description="default = ar (ar, en)" ,
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
    public function terms(Request $request) {
        $input = $request->all();
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $data_page = new Class_PageController();
        $return_data = $data_page->PageContent('terms', $lang, 1);
        $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
        $response['data'] = $return_data;
        return response()->json($response, 200);
    }

    /**
     * add new champions   
     * get method
     * url : http://localhost:8000/api/v1/champions
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/champions",
     *   tags={"page"},
     *   operationId="champions",
     *   summary="champions",
     * @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    description="default = ar (ar, en)" ,
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
    public function champions(Request $request) {
        $input = $request->all();
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $data_page = new Class_PageController();
        $return_data = $data_page->Page_champions(1);
        $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
        $response['data'] = $return_data;
        return response()->json($response, 200);
    }

    /**
     * add new audience   
     * get method
     * url : http://localhost:8000/api/v1/audience
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/audience",
     *   tags={"page"},
     *   operationId="audience",
     *   summary="audience",
     * @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    description="default = ar (ar, en)" ,
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
    public function audience(Request $request) {
        $input = $request->all();
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $data_page = new Class_PageController();
        $return_data = $data_page->Page_audience(1);
        $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
        $response['data'] = $return_data;
        return response()->json($response, 200);
    }

    /**
     * add new calendar   
     * get method
     * url : http://localhost:8000/api/v1/calendar
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/calendar",
     *   tags={"page"},
     *   operationId="calendar",
     *   summary="calendar",
     * @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    description="default = ar (ar, en)" ,
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
    public function calendar(Request $request) {
        $input = $request->all();
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $data_page = new Class_PageController();
        $return_data = $data_page->Page_calendar(1);
        $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
        $response['data'] = $return_data;
        return response()->json($response, 200);
    }
    /**
     * add new contact_us   
     * get method
     * url : http://localhost:8000/api/v1/contact_us
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/contact_us",
     *   tags={"page"},
     *   operationId="contact_us",
     *   summary="contact_us",
     * @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    description="default = ar (ar, en)" ,
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
    public function contact_us(Request $request) {
        $input = $request->all();
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $data_page = new Class_PageController();
        $return_data = $data_page->Page_contactUs('contact', $lang, 1);
        $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
        $response['data'] = $return_data;
        return response()->json($response, 200);
    }

    /**
     * add new contactUs   
     * get method
     * url : http://localhost:8000/api/v1/add_contact_us
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/add_contact_us",
     *   tags={"page"},
     *   operationId="add_contact_us",
     *   summary="add message of contact_us",
     * @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="content",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="user_email",
     *    in= "formData",
     *    description="should send it when access_token is empty" ,
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="user_name",
     *    in= "formData",
     *    description="should send it when access_token is empty ",
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="visitor",
     *    in= "formData",
     *    description="This Ip of device",
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="type",
     *    in= "formData",
     *    description="default type is contact and can use (contact)",
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    description="default = ar (ar, en)" ,
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
    public function add_contact_us(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $content = isset($input['content']) ? $input['content'] : '';
        $user_name = isset($input['user_name']) ? $input['user_name'] : '';
        $user_email = isset($input['user_email']) ? $input['user_email'] : '';
        $visitor = isset($input['visitor']) ? $input['visitor'] : 'ip';
        $type = isset($input['type']) ? $input['type'] : 'contact';
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $response = [];
        $fields = [];

        if ($content == "") {
            $fields['content'] = 'content';
        }
//        if ($access_token == "") {
//            $fields['access_token'] = 'access-token';
//        }
        if ($access_token == "") {
            if ($user_name == "") {
                $fields['user_name'] = 'user_name';
            }
            if ($user_email == "") {
                $fields['user_email'] = 'user_email';
            } else {
                if (filter_var($user_email, FILTER_VALIDATE_EMAIL) === false) {
                    $response = API_Controller::MessageData('INVALID_EMAIL', $lang);
                    return response()->json($response, 400);
                }
            }
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
                $user_name = $data_user->display_name;
                $user_email = $data_user->email;
            } else {
                $response = API_Controller::MessageData('USER_NOT_Found', $lang);
                return response()->json($response, 401);
            }
        }
        $input = [
            'name' => $user_name,
            'email' => $user_email,
            'type' => $type,
            'content' => $content,
            'visitor' => $visitor
        ];
        $insert_contact = new Class_PageController();
        $contact_us = $insert_contact->add_contact_Us($input, $user_id, 1);
        if ($contact_us['state_add'] == 1) {
            $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
            $response['state_add'] = $contact_us['state_add'];
            return response()->json($response, 200);
        } else {
            $response = API_Controller::MessageData('NOT_SAVED', $lang);
            return response()->json($response, 400);
        }
    }

}
