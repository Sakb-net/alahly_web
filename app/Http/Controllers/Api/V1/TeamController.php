<?php

namespace App\Http\Controllers\Api\V1;

//use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\API_Controller;
use App\User;
use App\Model\Category;
use App\Model\Page;

class TeamController extends API_Controller {
    /**
     * get data teams , if found sent access_token
     * post method
     * url : http://localhost:8000/api/v1/teams
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *  path="/teams",
     *   tags={"team"},
     *   operationId="teams",
     *   summary="get all main teams",
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
    public function teams(Request $request) {
        $input = $request->all();
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
        $all_teams = Category::cateorySelect(0, 'team', '', '', 1, 0);
        $response['data'] = Category::SelectDataTeam($all_teams, 1);
        return response()->json($response, 200);
    }

    /**
     * get data subteams  
     * get method
     * url : http://localhost:8000/api/v1/subteams
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/subteams",
     *   tags={"team"},
     *   operationId="subteams",
     *   summary="get sub teams for main team by link",
     * @SWG\Parameter(
     *    name="team_link",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *    description="link of subteams",
     *  ),
     * @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    type="string",
     *    description="default is ar (ar - en)",
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
    public function subteams(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $team_link = isset($input['team_link']) ? $input['team_link'] : '';
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $response = [];
        $fields = [];
        if ($team_link == "") {
            $fields['team_link'] = 'team_link';
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
        $catgeory = Category::where('link', $team_link)->where('is_active', 1)->first();
        if (isset($catgeory->id)) {
            $data_category['link'] = $catgeory->link;
            $data_category['name'] = $catgeory->name;
            $data_category['content'] = $catgeory->content;
            //data player
            $data_players = $catgeory->childrens->where('type_state', 'player');
            $data_category['players'] = Category::get_DataTeamUser($data_players);
            $data_coaches = $catgeory->childrens->whereIn('type_state', ['coach', 'help_coach']);
            //data coaches
            $data_category['coaches'] = Category::get_DataTeamUser($data_coaches);
            $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
            $response['data'] = $data_category;
            return response()->json($response, 200);
        } else {
            $response = API_Controller::MessageData('NO_DATA_FOUND', $lang);
            return response()->json($response, 400);
        }
    }

    /**
     * Show player page of one team   
     * get method
     * url : http://localhost:8000/api/v1/team/player
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *  path="/team/player",
     *   tags={"team"},
     *   operationId="teamplayer",
     *   summary="get data of teamplayer",
     * @SWG\Parameter(
     *    name="player_link",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *    description="link of player or coach",
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
    public function teamplayer(Request $request) {
        $input = $request->all();
        $player_link = isset($input['player_link']) ? $input['player_link'] : '';
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $response = [];
        $fields = [];
        if ($player_link == "") {
            $fields['player_link'] = 'player_link';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        $all_data = Category::get_categoryCloum('link', $player_link, 1);
        if (isset($all_data->id)) {
            $data = Category::single_DataTeamUser($all_data);
//            $data_teams['catgeory'] = Category::get_categoryCloum('id', $all_data->parent_id, 1);
            Page::get_typeColum('team');
            $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
            $response['data'] = $data;
            return response()->json($response, 200);
        } else {
            $response = API_Controller::MessageData('NO_DATA_FOUND', $lang);
            return response()->json($response, 400);
        }
    }

}
