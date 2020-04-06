<?php

namespace App\Http\Controllers\Api\V1;

//use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\API_Controller;
use App\User;

class AttachmentController extends API_Controller {
    /**
     * upload image   
     * get method
     * url : http://localhost:8000/api/v1/uploadImage
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/uploadImage",
     *   tags={"upload"},
     *   operationId="uploadImage",
     *   summary="upload image by using String Based46 ",
     * @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    required=true,
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="image",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *    description="String Based46 of uploadImage",
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
    public function uploadImage(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $image = isset($input['image']) ? $input['image'] : '';
        $response = [];
        $fields = [];
        $lang = 'ar';
        if ($image == "") {
            $fields['image'] = 'image';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        if (!empty($access_token)) {
            $data_user = User::user_access_token($access_token, 1);
            if (isset($data_user->id)) {
                $name = generateRandomToken() . ".png";
                $path = 'uploads/photos/' . $name;
                if (file_put_contents($path, base64_decode($image))) {
                    $default_server = 'http://' . $_SERVER['SERVER_NAME'];
                    $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
                    $response['data'] = $default_server .'/'. $path;
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

    /**
     * upload imagefile   
     * get method
     * url : http://localhost:8000/api/v1/uploadImageFile
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/uploadImageFile",
     *   tags={"upload"},
     *   operationId="uploadImageFile",
     *   summary="upload image by uploading image from your computer ",
     * @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    required=true,
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="image",
     *    in= "formData",
     *    required=true,
     *    type="file",
     *    description="file uploadImage",
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
    public function uploadImageFile(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
//          print_r($_FILES['image']);die;
//        $image = isset($input['image']) ? $input['image'] : '';
        $image = isset($_FILES['image']) ? $_FILES['image'] : '';
        $response = [];
        $fields = [];
        $lang = 'ar';
        if ($image == "") {
            $fields['image'] = 'image';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        if (!empty($access_token)) {
            $data_user = User::user_access_token($access_token, 1);
            if (isset($data_user->id)) {
//                $name = generateRandomToken() . ".png";
//                $path = 'uploads/' . $name;

                $media = '';
                $mediaFilename = '';
                $mediaName = '';

                if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {   //&& empty($mediaFilename)
                    $fileInfo = array(
                        'file' => $_FILES["image"]["tmp_name"],
                        'name' => $_FILES['image']['name'],
                        'size' => $_FILES["image"]["size"],
                        'type' => $_FILES["image"]["type"],
                        'types' => 'png,jpg,jpeg,gif,PNG,JPG,JPEG,GIF'
                    );
                    $media = Wo_ShareFile($fileInfo);
                    if (!empty($media)) {
                        $mediaFilename = $media['filename'];
                        $mediaName = $media['name'];
                        $path = 'http://' . $_SERVER['SERVER_NAME'].'/' . $mediaFilename;
                        $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
                        $response['name'] = $mediaName;
                        $response['data'] = $path;
                        return response()->json($response, 200);
                    } else {
                        $response = API_Controller::MessageData('ERROR_MESSAGE', $lang);
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
     * upload video   
     * get method
     * url : http://localhost:8000/api/v1/uploadVideo
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/uploadVideo",
     *   tags={"upload"},
     *   operationId="uploadVideo",
     *   summary="upload video by using String Based46 ",
     * @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    required=true,
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="video",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *    description="String Base46 of uploadVideo",
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
    public function uploadVideo(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $video = isset($input['video']) ? $input['video'] : '';
        $response = [];
        $fields = [];
        $lang = 'ar';
        if ($video == "") {
            $fields['video'] = 'video';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        if (!empty($access_token)) {
            $data_user = User::user_access_token($access_token, 1);
            if (isset($data_user->id)) {
                $name = generateRandomToken();
                $video_path = 'uploads/videos/' . $name . ".mp4";
                if (file_put_contents($video_path, base64_decode($video))) {
                    $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
                    $response['data'] = 'http://' . $_SERVER['SERVER_NAME'] .'/'. $video_path;
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

    /**
     * upload audio   
     * get method
     * url : http://localhost:8000/api/v1/uploadAudio
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/uploadAudio",
     *   tags={"upload"},
     *   operationId="uploadAudio",
     *   summary="upload audio by using String Based46 ",
     * @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    required=true,
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="audio",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *    description="String Base46 of uploadAudio",
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
    public function uploadAudio(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $audio = isset($input['audio']) ? $input['audio'] : '';
        $response = [];
        $fields = [];
        $lang = 'ar';
        if ($audio == "") {
            $fields['audio'] = 'audio';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        if (!empty($access_token)) {
            $data_user = User::user_access_token($access_token, 1);
            if (isset($data_user->id)) {
                $name = generateRandomToken() . ".m4a";
                $path = 'uploads/sounds/' . $name;
                if (file_put_contents($path, base64_decode($audio))) {
                    $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
                    $response['data'] = 'http://' . $_SERVER['SERVER_NAME'].'/' . $path;
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

    /**
     * upload imagefile   
     * get method
     * url : http://localhost:8000/api/v1/uploadImageFile
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/uploadAudioFile",
     *   tags={"upload"},
     *   operationId="uploadAudioFile",
     *   summary="upload audio by uploading audio from your computer",
     * @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    required=true,
     *    type="string",
     *  ),
     * @SWG\Parameter(
     *    name="audio",
     *    in= "formData",
     *    required=true,
     *    type="file",
     *    description="file uploadAudio",
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
    public function uploadAudioFile(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();

        $audio = isset($_FILES['audio']) ? $_FILES['audio'] : '';
        $lang = 'ar';
        $response = [];
        $fields = [];
        if ($audio == "") {
            $fields['audio'] = 'audio';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        if (!empty($access_token)) {
            $data_user = User::user_access_token($access_token, 1);
            if (isset($data_user->id)) {
//                $name = generateRandomToken() . ".png";
//                $path = 'uploads/sounds/' . $name;

                $media = '';
                $mediaFilename = '';
                $mediaName = '';

                if (isset($_FILES['audio']['name']) && !empty($_FILES['audio']['name'])) {   //&& empty($mediaFilename)
                    $fileInfo = array(
                        'file' => $_FILES["audio"]["tmp_name"],
                        'name' => $_FILES['audio']['name'],
                        'size' => $_FILES["audio"]["size"],
                        'type' => $_FILES["audio"]["type"],
                        'types' => 'mp3,wav,m4a'            //'mp4,m4v,webm,flv,mov,mpeg'
                    );
                    $media = Wo_ShareFile($fileInfo);
                    if (!empty($media)) {
                        $mediaFilename = $media['filename'];
                        $mediaName = $media['name'];
                        $path = 'http://' . $_SERVER['SERVER_NAME'].'/' . $mediaFilename;
                        if (!empty($path)) {
                            $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
                            $response['name'] = $mediaName;
                            $response['data'] = $path;
                            return response()->json($response, 200);
                        } else {
                            $response = API_Controller::MessageData('ERROR_MESSAGE', $lang);
                            $response['data'] = 'Upload Path Not Found';
                            return response()->json($response, 400);
                        }
                    } else {
                        $response = API_Controller::MessageData('ERROR_MESSAGE', $lang);
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

//***************************

    public static function uploadImageUser($image, $user_id, $column_name = 'image') {
        $user = User::GetByColumValue('id', $user_id, 1)->first();
        if (isset($user->id)) {
            $name = generateRandomToken() . ".png";
            $path = 'uploads/' . $name;
            if (file_put_contents($path, base64_decode($image))) {
                //save path to column
                $path_image = 'http://' . $_SERVER['SERVER_NAME'] .'/'. $path;
                $updated = User::updateColum($user_id, $column_name, $path_image, 0);
                if ($updated)
                    return $path_image;
                else
                    return "";
            }else {
                return "";
            }
        } else {
            return "";
        }
    }

}
