<?php

namespace App\Http\Controllers\Api\V1;

//use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\API_Controller;
use App\User;
use App\Model\Album;

class GalleryController extends API_Controller {
    /**
     * get data albums , if found sent access_token
     * post method
     * url : http://localhost:8000/api/v1/albums
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *  path="/albums",
     *   tags={"album"},
     *   operationId="albums",
     *   summary="get all albums",
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
     *    description=" limit is number albums will send in each time default ( 12 )",
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
    public function albums(Request $request) {
        $input = $request->all();
        $num_page = isset($input['num_page']) ? $input['num_page'] : 0;
        $limit = isset($input['limit']) ? $input['limit'] : 12;
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $offset = $num_page * $limit;
        $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
        $all_albums = Album::get_ALLAlbumData(null, 'id', 'DESC', $limit, $offset);
        $albums = Album::dataAlbum($all_albums);
        $response['data'] = $albums;
        return response()->json($response, 200);
    }

    /**
     * Show single page of one albums   
     * get method
     * url : http://localhost:8000/api/v1/albums/single
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *  path="/albums/single",
     *   tags={"album"},
     *   operationId="albumsSingle",
     *   summary="get image of single album by album link",
     * @SWG\Parameter(
     *    name="albums_link",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *    description="link of albums",
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
    public function albumsSingle(Request $request) {
        $input = $request->all();
        $albums_link = isset($input['albums_link']) ? $input['albums_link'] : '';
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $response = [];
        $fields = [];
        if ($albums_link == "") {
            $fields['albums_link'] = 'albums_link';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        $albums = Album::get_albumColum('link', $albums_link, 1);
        if (isset($albums->id)) {
            Album::updateAlbumViewCount($albums->id);
            $data_albums['name'] = $albums->name;
//            $data_albums['link'] = $albums->link;
            $data_albums['image'] = $albums->image;
            $data_albums['date'] = $albums->created_at->format('Y-m-d'); //arabic_date_number($albums->created_at->format('Y-m-d'), '-');
            $data_albums['created_at'] = Time_Elapsed_String('@' . strtotime($albums->created_at), $albums->lang);
            //sub album
            $all_albums = Album::get_ALLAlbumData($albums->id);
            $sub_albums = Album::dataAlbum($all_albums);
            $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
            $response['data'] = $data_albums;
            $response['sub_albums'] = $sub_albums;
            return response()->json($response, 200);
        } else {
            $response = API_Controller::MessageData('NO_DATA_FOUND', $lang);
            return response()->json($response, 400);
        }
    }

}
