<?php

namespace App\Http\Controllers\Api\V1;

//use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\API_Controller;
use App\User;
use App\Model\Video;

class videosController extends API_Controller {
    /**
     * get data videos , if found sent access_token
     * post method
     * url : http://localhost:8000/api/v1/videos
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *  path="/videos",
     *   tags={"video"},
     *   operationId="videos",
     *   summary="get all videos",
     *  @SWG\Parameter(
     *    name="num_page",
     *    in= "formData",
     *    type="number",
     *    description=" number of page strat from zero ( 0 )",
     *  ),
     *  @SWG\Parameter(
     *    name="limit",
     *    in= "formData",
     *    type="number",
     *    description=" limit is number videos will send in each time default ( 12 )",
     *  ),
     * @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    type="string",
     *    description="default ar (ar - en)",
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
    public function videos(Request $request) {
        $input = $request->all();
        $num_page = isset($input['num_page']) ? $input['num_page'] : 0;
        $limit = isset($input['limit']) ? $input['limit'] : 12;
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $offset = $num_page * $limit;
        $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
        $all_videos = Video::get_ALLVideoData(null, 'id', 'DESC', $limit, $offset);
        $videos = Video::datavideos($all_videos, 1);
        $response['data'] = $videos;
        return response()->json($response, 200);
    }

    /**
     * Show single page of one videos   
     * get method
     * url : http://localhost:8000/api/v1/videos/single
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *  path="/videos/single",
     *   tags={"video"},
     *   operationId="videosSingle",
     *   summary=" get single video by link",
     * @SWG\Parameter(
     *    name="videos_link",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *    description="link of videos",
     *  ),
     * @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    type="string",
     *    description="default ar (ar - en)",
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
    public function videosSingle(Request $request) {
        $input = $request->all();
        $videos_link = isset($input['videos_link']) ? $input['videos_link'] : '';
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $response = [];
        $fields = [];
        if ($videos_link == "") {
            $fields['videos_link'] = 'videos_link';
        }
        if (!empty($fields)) {
            $response['StatusCode'] = 2;
            $response['Message'] = API_Controller::MISSING_FIELD;
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        $videos = Video::get_videoColum('link', $videos_link, 1);
        if (isset($videos->id)) {
            Video::updateVideoViewCount($videos->id);
            $data_videos = Video::datavideos_single($videos, 1);
            $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);

            $response['data'] = $data_videos;
            return response()->json($response, 200);
        } else {
            $response = API_Controller::MessageData('NO_DATA_FOUND', $lang);
            return response()->json($response, 400);
        }
    }

}
