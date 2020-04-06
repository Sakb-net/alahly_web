<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\API_Controller;
use App\Http\Controllers\ClassSiteApi\Class_ActionController;
use App\Http\Controllers\ClassSiteApi\Class_CommentController;
use App\User;
use App\Model\Watche;

class ActionController extends API_Controller {
    /**
     * add video to table watches  
     * get method
     * url : http://localhost:8000/api/v1/add_watch
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/add_watch",
     *   tags={"watch"},
     *   operationId="v1/add_watch",
     *   summary="add video watch",
     * @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    required=true,
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="video_link",
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
    public function add_watch(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $video_link = isset($input['video_link']) ? $input['video_link'] : '';
        $response = [];
        $fields = [];
        $lang = 'ar';
        if ($video_link == "") {
            $fields['video_link'] = 'video_link';
        }
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
                $add_watch = Watche::insertWatcheVideoLink($user_id, $video_link, 1);
                if ($add_watch > 0) {
                    $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
                    return response()->json($response, 200);
                } else {
                    $response = API_Controller::MessageData('NOT_SAVED', $lang);
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

    /**
     * add course or comment or question to like list by link and  access_token
     * post method
     * url : http://localhost:8000/api/v1/add_del_like
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/add_del_like",
     *   tags={"like,dislike"},
     *   operationId="v1/add_del_like",
     *   summary="add or delete like for video or news or product or comment or comment_news or comment_video or comment_product",
     *   @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    required=true,
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="link",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *    description="link thing that add to like or delete",
     *  ),
     * @SWG\Parameter(
     *    name="type",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *    description="video or news or product or comment or comment_news or comment_video or comment_product",
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
    public function add_del_like(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $link = isset($input['link']) ? $input['link'] : '';
        $type = isset($input['type']) ? $input['type'] : '';
        $response = [];
        $fields = [];
        $lang = 'ar';
        if ($access_token == "") {
            $fields['access_token'] = 'access-token';
        }
        if ($link == "") {
            $fields['link'] = 'link';
        }
        if ($type == "" || !in_array($type, ['match', 'video', 'news', 'comment', 'comment_news', 'comment_video'])) {
            $fields['type'] = 'type';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        if ($type == 'news') {
            $type = 'blog';
        }
        if ($type == 'comment_news') {
            $type = 'comment_blog';
        }
        if (!empty($access_token)) {
            $data_user = User::user_access_token($access_token, 1);
            if (isset($data_user->id)) {
                $user_id = $data_user->id;
                $result = -1;
                if (in_array($type, ['blog', 'video','product'])) {
                    $get_course = new Class_ActionController();
                    $result = $get_course->action_fav_Data($link, $type, 'like', $user_id, 1);
                } elseif (in_array($type, ['comment', 'comment_blog', 'comment_video','comment_product'])) {
                    $type_comment = 'comment';
                    if ($type == 'comment_blog') {
                        $type_comment = 'blog';
                    } elseif ($type == 'comment_video') {
                        $type_comment = 'video';
                    } elseif ($type == 'comment_product') {
                        $type_comment = 'product';
                    }
                    $get_comment = new Class_CommentController();
                    $result = $get_comment->action_fav_comment($link, $type_comment, $type, 'like', 1, $user_id, 1);
                }
                if ($result['like'] == 1 || $result['like'] == 0) {
                    $response = API_Controller::MessageData('MISSING_FIELD', $lang);
                    $response['Message'] = API_Controller::SUCCESS_MESSAGE;
                    $response['data'] = $result['like'];
                    return response()->json($response, 200);
                } else {
                    $response = API_Controller::MessageData('NOT_SAVED', $lang);
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
