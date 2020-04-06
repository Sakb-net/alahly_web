<?php

namespace App\Http\Controllers\Api\V1;

//use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\API_Controller;
use App\User;
use App\Model\Category;
use App\Http\Controllers\ClassSiteApi\Class_MasterController;

class MasterController extends API_Controller {
    /**
     * get data of all master_sections
     * get method
     * url : http://localhost:8000/api/v1/master_sections
     *
     * @return response Json
     */

    /**
     * @SWG\Get(
     *   path="/master_sections",
     *   tags={"ticket"},
     *   summary="get all sections of master",
     *   operationId="master_sections",
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=400, description="not acceptable"),
     *   @SWG\Response(response=500, description="internal server error")
     * )
     *
     */
    public function master_sections() {
        $lang = 'ar';
        $get_data = new Class_MasterController();
        $data_master = $get_data->DrawMaster('section', 0, 1);
        $master = Category::SelectDataMaster($data_master, 1);
        $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
        $response['data'] = $master;
        return response()->json($response, 200);
    }

    /**
     * get data section_seat  
     * get method
     * url : http://localhost:8000/api/v1/section_seat
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/section_seat",
     *   tags={"ticket"},
     *   operationId="section_seat",
     *   summary="get seats of section by section link",
     * @SWG\Parameter(
     *     name="access-token",
     *     in="header",
     *     required=false,
     *     type="string"
     *   ),
     *    @SWG\Parameter(
     *    name="sec_link",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *    description="link of section_seat",
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
    public function section_seat(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $sec_link = isset($input['sec_link']) ? $input['sec_link'] : '';
        $response = [];
        $fields = [];
        $lang = 'ar';
        if ($sec_link == "") {
            $fields['sec_link'] = 'sec_link';
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
        $get_data = new Class_MasterController();
        $all_data = $get_data->getSectionSeat($sec_link, 1, $user_id);
        $data_master = $get_data->DrawSectionSeat($all_data, 1, $user_id);
        if ($all_data['status'] != 0) {
            $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
            $response['data'] = $data_master;
            return response()->json($response, 200);
        } else {
            $response = API_Controller::MessageData('NO_DATA_FOUND', $lang);
            return response()->json($response, 400);
        }
    }

}
