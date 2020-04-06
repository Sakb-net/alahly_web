<?php

namespace App\Http\Controllers\Api\V1;

//use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\API_Controller;
use App\Http\Controllers\ClassSiteApi\Class_CommentController;
use App\User;
use App\Model\Comment;
use App\Model\CommentVideo;
use App\Model\CommentBlog;

class CommentController extends API_Controller {
    /**
     * get allcomments of cart  with type (comment,news,video)  
     * get method
     * url : http://localhost:8000/api/v1/comments
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/comments",
     *   tags={"comment"},
     *   operationId="comments",
     *   summary="get all comments",
     * @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="link",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *    description="this link type only",
     *  ),
     * @SWG\Parameter(
     *    name="type",
     *    in= "formData",
     *    description="default type is video and can use (news,video,product)",
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="limit",
     *    in= "formData",
     *    description="default limit 12  and can you increase limit",
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
    public function comments(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $link = isset($input['link']) ? $input['link'] : '';
        $limit = isset($input['limit']) ? $input['limit'] : 12;
        $type = isset($input['type']) ? $input['type'] : 'video';
        $type_comment = 'comment';
        $response = [];
        $fields = [];
        $lang = 'ar';
        if ($link == "") {
            $fields['link'] = 'link';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        if ($type == 'news') {
            $type = 'blog';
        }
        $get_data = new Class_CommentController();
        $post = $get_data->get_data($link, $type, 0, 1);
        if (isset($post->id)) {
            $user_id = 0;
            if (!empty($access_token)) {
                $data_user = User::user_access_token($access_token, 1);
                if (isset($data_user->id)) {
                    $user_id = $data_user->id;
                } else {
                    $response = API_Controller::MessageData('USER_NOT_Found', $lang);
                    return response()->json($response, 401);
                }
            }
            $get_comment = new Class_CommentController();
            $all_comment = $get_comment->get_commentdata($post, $type, '', 'id', 'DESC', '', '', $user_id, 1, $limit, $type_comment);
            $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
            $response['count_data'] = $all_comment['comt_quest_count'];
            $response['data'] = $all_comment['comments'];
            return response()->json($response, 200);
        } else {
            $response = API_Controller::MessageData('NO_DATA_FOUND', $lang);
            return response()->json($response, 400);
        }
    }

    /**
     * add new comment of cart  with type (comment)  
     * get method
     * url : http://localhost:8000/api/v1/add_comment
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/add_comment",
     *   tags={"comment"},
     *   operationId="add_comment",
     *   summary="add comment",
     * @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="link",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="content",
     *    in= "formData",
     *    description="You must be present if image and video and audio are empty",
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="rate",
     *    in= "formData",
     *    description="this use when type = product",
     *    type="number",
     *  ),
     * @SWG\Parameter(
     *    name="link_parent",
     *    in= "formData",
     *    description="You must be present link of parent comment with answer and reply",
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="user_email",
     *    in= "formData",
     *    description="should be found if access-token is empty",
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="user_name",
     *    in= "formData",
     *    description="should be found if access-token is empty",
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="image",
     *    in= "formData",
     *    description="path image after upload on server",
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="video",
     *    in= "formData",
     *    description="path video after upload on server",
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="audio",
     *    in= "formData",
     *    description="path audio after upload on server",
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="type",
     *    in= "formData",
     *    description="default type is video and can use (news,video,product)",
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
    public function add_comment(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $link = isset($input['link']) ? $input['link'] : '';
        $content = isset($input['content']) ? $input['content'] : '';
        $user_name = isset($input['user_name']) ? $input['user_name'] : '';
        $user_email = isset($input['user_email']) ? $input['user_email'] : '';
        $link_parent = isset($input['link_parent']) ? $input['link_parent'] : NULL;
        $rate = isset($input['rate']) ? $input['rate'] : 0;
        $image = isset($input['image']) ? $input['image'] : NULL;
        $video = isset($input['video']) ? $input['video'] : NULL;
        $audio = isset($input['audio']) ? $input['audio'] : NULL;
        $type = isset($input['type']) ? $input['type'] : 'video';
        $type_comment = 'comment';
        $response = [];
        $fields = [];
        $lang = 'ar';
        if ($link == "") {
            $fields['link'] = 'link';
        }
        if ($content == "" && $image == "" && $video == "" && $audio == "") {
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
        if ($type == "" || !in_array($type, ['match', 'video', 'comment', 'news', 'product'])) {
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
        $get_data = new Class_CommentController();
        $post = $get_data->get_data($link, $type, 0, 1);
        if (isset($post->id)) {
            $user_id = 0;
            if (!empty($access_token)) {
                $data_user = User::user_access_token($access_token, 1);
                if (isset($data_user->id)) {
                    $user_id = $data_user->id;
                } else {
                    $response = API_Controller::MessageData('USER_NOT_Found', $lang);
                    return response()->json($response, 401);
                }
            }
            if (!empty($video) || $video != '') {
                $video = getPathViemo($video);
            }
            $input = [
                'link' => $link,
                'link_parent' => $link_parent,
                'type' => $type,
                'content' => $content,
                'image' => $image,
                'video' => $video,
                'audio' => $audio
            ];
            if ($type == 'blog') {
                $input['blog_id'] = $post->id;
            } elseif ($type == 'video') {
                $input['video_id'] = $post->id;
            } elseif ($type == 'product') {
                $input['product_id'] = $post->id;
                $input['rate'] = $rate;
            } else {
                $input['post_id'] = $post->id;
            }
            if ($access_token == "") {
                $input['name'] = $user_name;
                $input['email'] = $user_email;
            }
            $get_comment = new Class_CommentController();
            $add_comment = $get_comment->add_commentDATA($input, $type, $type_comment, $post, $user_id, 1);
            $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
//            $response['subscribed'] = True;
            $response['data'] = $add_comment['comment'];
            $response['state_add'] = $add_comment['state_add'];
            return response()->json($response, 200);
        } else {
            $response = API_Controller::MessageData('NO_DATA_FOUND', $lang);
            return response()->json($response, 400);
        }
    }

    /**
     * update  comment of cart  with type (comment)  
     * get method
     * url : http://localhost:8000/api/v1/update_comment
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/update_comment",
     *   tags={"comment"},
     *   operationId="update_comment",
     *   summary="update comment",
     * @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    required=true,
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="comment_link",
     *    in= "formData",
     *    required=true,
     *    description="link comment to update data of it",
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="content",
     *    in= "formData",
     *    description="You must be present if image and video and audio are empty",
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="rate",
     *    in= "formData",
     *    description="This use only when type=product",
     *    type="number",
     *  ),
     * @SWG\Parameter(
     *    name="image",
     *    in= "formData",
     *    description="path image after upload on server",
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="type",
     *    in= "formData",
     *    description="default type is video and can use (news,video)",
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="video",
     *    in= "formData",
     *    description="path video after upload on server",
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="audio",
     *    in= "formData",
     *    description="path audio after upload on server",
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
    public function update_comment(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $comment_link = isset($input['comment_link']) ? $input['comment_link'] : '';
        $content = isset($input['content']) ? $input['content'] : '';
        $rate = isset($input['rate']) ? $input['rate'] : 0;
        $image = isset($input['image']) ? $input['image'] : NULL;
        $video = isset($input['video']) ? $input['video'] : NULL;
        $audio = isset($input['audio']) ? $input['audio'] : NULL;
        $type = isset($input['type']) ? $input['type'] : 'video';
        $type_comment = 'comment';
        $response = [];
        $fields = [];
        $lang = 'ar';
        if ($comment_link == "") {
            $fields['comment_link'] = 'comment_link';
        }
        if ($content == "" && $image == "" && $video == "" && $audio == "") {
            $fields['content'] = 'content';
        }
        if ($access_token == "") {
            $fields['access_token'] = 'access-token';
        }
        if ($type == "" || !in_array($type, ['match', 'video', 'comment', 'news', 'product'])) {
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
        if (!empty($access_token)) {
            $data_user = User::user_access_token($access_token, 1);
            if (isset($data_user->id)) {
                $user_id = $data_user->id;
                $get_data = new Class_CommentController();
                $comment = $get_data->get_dataComment($comment_link, $type, 1, 1);
                if (isset($comment->id)) {
                    if ($user_id == $comment->user_id) {
                        if (!empty($video) && $comment->video != $video) {
                            $video = getPathViemo($video);
                        }
                        $input = [
                            'comment_link' => $comment_link,
                            'content' => $content,
                            'image' => $image,
                            'video' => $video,
                            'audio' => $audio,
                        ];
                        if ($type == 'product') {
                            $input['rate'] = $rate;
                        }
                        $get_comment = new Class_CommentController();
                        $update_comment = $get_comment->update_commentDATA($input, $type, $user_id, 1);
                        if ($update_comment) {
                            $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
                            return response()->json($response, 200);
                        } else {
                            $response = API_Controller::MessageData('ERROR_MESSAGE', $lang);
                            return response()->json($response, 400);
                        }
                    } else {
                        $response = API_Controller::MessageData('NoOWner', $lang);
                        return response()->json($response, 400);
                    }
                } else {
                    $response = API_Controller::MessageData('NO_DATA_FOUND', $lang);
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
     * delete comment by id  
     * get method
     * url : http://localhost:8000/api/v1/delete_comment
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/delete_comment",
     *   tags={"comment"},
     *   operationId="delete_comment",
     *   summary="delete comment",
     * @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    required=true,
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="comment_link",
     *    in= "formData",
     *    required=true,
     *    description="link of comment or video or match or product to delete",
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="type",
     *    in= "formData",
     *    description="default type is video and can use (news,video,product)",
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
    public function delete_comment(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $comment_link = isset($input['comment_link']) ? $input['comment_link'] : '';
        $type = isset($input['type']) ? $input['type'] : 'video';
        $type_comment = 'comment';
        $lang = 'ar';
        $response = [];
        $fields = [];
        if ($comment_link == "") {
            $fields['comment_link'] = 'comment_link';
        }
        if ($access_token == "") {
            $fields['access_token'] = 'access-token';
        }

        if ($type == "" || !in_array($type, ['match', 'video', 'comment', 'news', 'product'])) {
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
        if (!empty($access_token)) {
            $data_user = User::user_access_token($access_token, 1);
            if (isset($data_user->id)) {
                $user_id = $data_user->id;
                if ($type == 'blog') {
                    $comment = CommentBlog::commentLink('link', $comment_link, 1);
                } elseif ($type == 'video') {
                    $comment = CommentVideo::commentLink('link', $comment_link, 1);
                } elseif ($type == 'product') {
                    $comment = CommentProduct::commentLink('link', $comment_link, 1);
                } else {
                    $comment = Comment::commentLink('link', $comment_link, 1);
                }
                if (isset($comment->id)) {
                    if ($user_id == $comment->user_id) {
                        $delete_comment = $comment->delete();
                        if ($delete_comment) {
                            $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
                            return response()->json($response, 200);
                        } else {
                            $response = API_Controller::MessageData('ERROR_MESSAGE', $lang);
                            return response()->json($response, 400);
                        }
                    } else {
                        $response = API_Controller::MessageData('NoOWner', $lang);
                        return response()->json($response, 400);
                    }
                } else {
                    $response = API_Controller::MessageData('NO_DATA_FOUND', $lang);
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
