<?php

namespace App\Http\Controllers\Api\V1;

//use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\API_Controller;
use App\User;
use App\Model\Match;

class MatchController extends API_Controller {
    /**
     * get data matches , if found sent access_token
     * post method
     * url : http://localhost:8000/api/v1/matches
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *  path="/matches",
     *   tags={"match"},
     *   operationId="matches",
     *   summary="get all matches according type is (all - next - prev)",
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
     *    description=" limit is number matches will send in each time default ( 12 )",
     *  ),
     * @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    type="string",
     *    description="default ar (ar - en)",
     *  ),
     * @SWG\Parameter(
     *    name="type",
     *    in= "formData",
     *    type="string",
     *    description="default next (all - next - prev)",
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
    public function matches(Request $request) {
        $input = $request->all();
        $num_page = isset($input['num_page']) ? $input['num_page'] : 0;
        $limit = isset($input['limit']) ? $input['limit'] : 12;
        $type = isset($input['type']) ? $input['type'] : 'next';
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $offset = $num_page * $limit;
        $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
        $all_matches = Match::get_MatchActive(1, '', '', $lang, $type, 0, $limit, $offset);
        $matches = Match::dataMatch($all_matches);
        $response['data'] = $matches;
        return response()->json($response, 200);
    }

    /**
     * Show single page of one matches   
     * get method
     * url : http://localhost:8000/api/v1/matches/single
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *  path="/matches/single",
     *   tags={"match"},
     *   operationId="matchesSingle",
     *   summary=" get data of single match by link",
     * @SWG\Parameter(
     *    name="match_link",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *    description="link of match",
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
    public function matchesSingle(Request $request) {
        $input = $request->all();
        $match_link = isset($input['match_link']) ? $input['match_link'] : '';
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $response = [];
        $fields = [];
        if ($match_link == "") {
            $fields['match_link'] = 'match_link';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        $match = Match::get_match('link', $match_link, $lang, 1);
        if (isset($match->id)) {
            Match::updateMatchViewCount($match->id);
            $data_match = Match::get_MatchSingle($match, $api = 0);
            $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
            $response['data'] = $data_match;
            return response()->json($response, 200);
        } else {
            $response = API_Controller::MessageData('NO_DATA_FOUND', $lang);
            return response()->json($response, 400);
        }
    }

}
