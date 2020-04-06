<?php

namespace App\Http\Controllers\Api\V1;

//use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\API_Controller;
use App\User;
use App\Model\Blog;

class NewsController extends API_Controller {
    /**
     * get data news , if found sent access_token
     * post method
     * url : http://localhost:8000/api/v1/news
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *  path="/news",
     *   tags={"news"},
     *   operationId="v1_news",
     *   summary="get news",
     *   description="",
     *  @SWG\Parameter(
     *    name="num_page",
     *    in= "formData",
     *    type="number",
     *    description=" number of page start from zero ( 0 )",
     *  ),
     *  @SWG\Parameter(
     *    name="limit",
     *    in= "formData",
     *    type="number",
     *    description=" limit is number news will send in each time default ( 12 )",
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
    public function news(Request $request) {
        $input = $request->all();
        $num_page = isset($input['num_page']) ? $input['num_page'] : 0;
        $limit = isset($input['limit']) ? $input['limit'] : 12;
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $offset = $num_page * $limit;
        $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
        $all_news = Blog::get_BlogActive(1, '', '', $lang, 0, $limit, $offset);
        $news = Blog::dataNews($all_news, 1);
        $response['data'] = $news;
        return response()->json($response, 200);
    }

    /**
     * Show single page of one news   
     * get method
     * url : http://localhost:8000/api/v1/news/single
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *  path="/news/single",
     *   tags={"news"},
     *   operationId="newsSingle",
     *   summary="get single news by link",
     * @SWG\Parameter(
     *    name="news_link",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *    description="link of news",
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
    public function newsSingle(Request $request) {
        $input = $request->all();
        $news_link = isset($input['news_link']) ? $input['news_link'] : '';
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $response = [];
        $fields = [];
        if ($news_link == "") {
            $fields['news_link'] = 'news_link';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        $news = Blog::get_blog('link', $news_link, $lang, 1);
        if (isset($news->id)) {
            Blog::updateBlogViewCount($news->id);
            $data_news = Blog::dataNews_single($news, 1);
            $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
            $response['data'] = $data_news;
            return response()->json($response, 200);
        } else {
                $response = API_Controller::MessageData('NO_DATA_FOUND', $lang);
            return response()->json($response, 400);
        }
    }

}
