<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Model\Feature;
use App\Model\Order;
//use App\Model\OrderMeta;
//use App\Model\PostMeta;
use App\Model\Post;
//use App\Model\Tag;
//use App\Model\Taggable;
//use App\Model\Comment;
use DB;

class OrderController extends AdminController {
//href="tel:+966506954964"
    //href="https://api.whatsapp.com/send?phone=966537219572&text=السلام+عليكم+ابغى+استفسر+عن+حملة+اعلانية+للسناب+شات"   

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function index(Request $request) {

        if (!$this->user->can(['access-all', 'order-type-all', 'order-all', 'order-list', 'order-edit', 'order-delete', 'order-show'])) {
            return $this->pageUnauthorized();
        }

        $order_active = $order_edit = $order_create = $order_delete = $order_show = $comment_list = $comment_create = 0;

        if ($this->user->can(['access-all', 'order-type-all', 'order-all'])) {
            $order_active = $order_edit = $order_create = $order_delete = $order_show = $comment_list = $comment_create = 1;
        }

        if ($this->user->can('order-edit')) {
            $order_active = $order_edit = $order_create = $order_show = 1;
        }

        if ($this->user->can('order-delete')) {
            $order_delete = 1;
        }

        if ($this->user->can('order-show')) {
            $order_show = 1;
        }

        if ($this->user->can('order-create')) {
            $order_create = 1;
        }

        if ($this->user->can(['comment-all', 'comment-edit'])) {
            $comment_list = $comment_create = 1;
        }

        if ($this->user->can('comment-list')) {
            $comment_list = 1;
        }

        if ($this->user->can('comment-create')) {
            $comment_create = 1;
        }
        $name = 'orders';
        $type_action = 'order';
        $data = Order::with('user')->orderBy('id', 'DESC')->paginate($this->limit);
        return view('admin.orders.index', compact('type_action', 'data', 'name', 'comment_create', 'comment_list', 'order_active', 'order_create', 'order_edit', 'order_delete', 'order_show'))
                        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function type(Request $request, $type) {

        $type_array = ['orders'];
        if (!in_array($type, $type_array)) {
            return $this->pageUnauthorized();
        }

        if (!$this->user->can(['access-all', 'order-type-all', 'order-all', 'order-list', 'order-edit', 'order-delete', 'order-show'])) {
            return $this->pageUnauthorized();
        }

        $order_active = $order_edit = $order_create = $order_delete = $order_show = $comment_list = $comment_create = 0;

        if ($this->user->can(['access-all', 'order-type-all', 'order-all'])) {
            $order_active = $order_edit = $order_create = $order_delete = $order_show = $comment_list = $comment_create = 1;
        }

        if ($this->user->can('order-edit')) {
            $order_active = $order_edit = $order_create = $order_show = $comment_list = $comment_create = 1;
        }

        if ($this->user->can('order-delete')) {
            $order_delete = 1;
        }

        if ($this->user->can('order-show')) {
            $order_show = 1;
        }

        if ($this->user->can('order-create')) {
            $order_create = 1;
        }

        if ($this->user->can(['comment-all', 'comment-edit'])) {
            $comment_list = $comment_create = 1;
        }

        if ($this->user->can('comment-list')) {
            $comment_list = 1;
        }

        if ($this->user->can('comment-create')) {
            $comment_create = 1;
        }

        $name = $type;

        $data = Order::orderBy('id', 'DESC')->with('user')->where('type', $type)->paginate($this->limit);
        return view('admin.orders.index', compact('data', 'name', 'comment_create', 'comment_list', 'order_create', 'order_edit', 'order_active', 'order_delete', 'order_show'))
                        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function create() {

        if (!$this->user->can(['access-all', 'order-type-all', 'order-all', 'order-create', 'order-edit'])) {
            return $this->pageUnauthorized();
        }
        $lang = $this->user->lang;
        $costType_lang = 'costType_' . $lang;
        $orderCourse = $orderUser = [];
        if ($this->user->can(['access-all', 'order-type-all', 'order-all', 'order-edit'])) {
            $order_active = $image = 1;
        } else {
            $order_active = $image = 0;
        }
        if ($this->user->can(['image-upload', 'image-edit'])) {
            $image = 1;
        }
        $users_all = User::where('is_active', 1)->pluck('id', 'email')->toArray();
        if ($this->user->lang == 'ar') {
            $first_title = ['اختر الايميل ' => 0];
            $first_course = ['كل الدورات' => -1];
        } else {
            $first_title = ['Choose Email ' => 0];
            $first_course = ['All Courses' => -1];
        }

        $users = array_flip(array_merge($first_title, $users_all));
        $course_all = Post::where('type', 'course')->where('lang', $lang)->where('is_active', 1)->pluck('lang_id', 'name')->toArray();
        $courses = array_flip(array_merge($first_course, $course_all));
        $new = 1;
        $image_link = NULL;
        $link_return = route('admin.orders.index');
        return view('admin.orders.create', compact('lang', 'costType_lang', 'link_return', 'users', 'orderCourse', 'orderUser', 'courses', 'new', 'order_active', 'image', 'image_link'));
    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */
    public function store(Request $request) {
        $post_type_message_wrong = $post_type_message_correct = null;
        if (!$this->user->can(['access-all', 'order-type-all', 'order-all', 'order-create', 'order-edit'])) {
            if ($this->user->can(['order-list'])) {
                session()->put('error', trans('app.no_access'));
                return redirect()->route('admin.orders.index');
            } else {
                return $this->pageUnauthorized();
            }
        }

        $this->validate($request, [
            'user_id' => "required|ValueSelectID:{$request->user_id}",
//            'post_id' => "required|ValueSelectID:{$request->post_id}",
        ]);

        $input = $request->all();
        foreach ($input as $key => $value) {
//            if ($key != "content") {
            $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
//            }
        }
        $new_add = 0;
        $total_discount = $discount = 100;
        $price = 0.00;
        $insertOrder = $update_insert = $message_share_course = '';
        $message_share = 'تم تفعيل اشتراكك فى دورات (';
        $array_post_id = isset($_POST['post_id']) ? $_POST['post_id'] : array();
        if (in_array(-1, $array_post_id)) {
            $message_share = 'تم تفعيل اشتراكك فى كل دورات (  ';
            $array_post_id = Post::where('type', 'course')->where('lang', 'ar')->where('is_active', 1)->pluck('lang_id', 'lang_id')->toArray();
        }
        foreach ($array_post_id as $key_post => $post_id) {
            $input['post_id'] = $post_id;
            $post = Post::find($input['post_id']);
            if (!empty($post) && !empty($post)) {
                $message_share_course .= $post->name . ' - ';
                $input['post_id'] = $post->lang_id;
                $insertOrder = $update_insert = 0;
                $price_course = $post->price;
                $discount_course = $post->discount;
                $course_title = $post->name;
//            $date = date("Y-m-d");
                $input['link'] = str_replace(' ', '_', $course_title . str_random(8));
                $source_share = 'site_free';
                if ($post->type_cost == 'free') {
                    $total_discount = $discount = 100;
                    $price = 0;
                } else {
                    if ($input['type_cost'] == 'premium') {
                        $source_share = 'site_pay';
                        $discount = 0;
                        $total_discount = $discount_course;
                        $price = round($price_course - ($price_course * ($total_discount / 100)), 2);
                    } elseif ($input['type_cost'] == 'discount') {
                        $source_share = 'site_pay';
                        $total_discount = $input['discount']; //+ $discount_course;
                        $price = round($price_course - ($price_course * ($total_discount / 100)), 2);
                    } elseif ($input['type_cost'] == 'free') {
                        $total_discount = $discount = 100;
                        $price = 0;
                    } else {
                        $total_discount = $discount = 0;
                        $price = 0;
                    }
                }
                //check found course for user_id 
                $dataFoundOrder = Order::get_LastRowShare($input['user_id'], $input['post_id'], 'id');
                if (!empty($dataFoundOrder)) {
                    if ($dataFoundOrder->is_active == 1 && $dataFoundOrder->is_share == 1 && $dataFoundOrder->type_request == 'accept') {
                        $post_type_message_wrong = 'فشلت عملية التسجيل لان دورة' . ' ' . $course_title . ' ' . 'مضافة ومفعلة بالفعل للعضو' . ' '; //. $user_name . ' ' . 'التابع للايميل' . ' ' . $user_email;
                    } elseif ($dataFoundOrder->is_active == 0 && $dataFoundOrder->is_share == 1 && $dataFoundOrder->type_request != 'accept') {
                        $update_insert = Order::updateOrderBuy($dataFoundOrder->id, $input['user_id'], $price, $total_discount, 1, 'accept', 'master', $source_share);
                    } elseif ($dataFoundOrder->is_active == 1 && $dataFoundOrder->is_share == 0 && $dataFoundOrder->type_request == 'accept') {
                        $update_insert = Order::updateOrderShareRepeat($dataFoundOrder->id, 1, 1, 1);
                    } else {
                        $new_add = 1;
                    }
                } else {
                    $new_add = 1;
                }
                if ($new_add == 1) {
                    //no user_id share in course
                    $insertOrder = Order::insertOrder($input['user_id'], $post, $this->user->id, 'master', $source_share, 'accept', $total_discount, 1, $price);
                    $order_id = $insertOrder['id'];
                    $post_type_message_correct = 'تم تسجيل البيانات  بنجاح مع ارسال رسالة الى البريد الالكترونى الخاص بالمضاف له الدورة للمتابعة';
                } else {
                    if ($update_insert) {
                        $post_type_message_correct = 'تم تعديل البيانات  بنجاح مع ارسال رسالة الى البريد الالكترونى الخاص بالمضاف له الدورة للمتابعة';
                    } else {
                        $post_type_message_wrong = 'فشلت عملية التعديل ';
                    }
                }
            }
        }
        if ($insertOrder || $update_insert) {
            //send message to member on email
            $message_share .= $message_share_course . '';
            //send email
            $sen_email = User::SendEmailTOUser($input['user_id'], 'shareChart', $message_share);
        }
        if (!empty($post_type_message_wrong)) {
            session()->put('error', $post_type_message_wrong);
            return redirect()->route('admin.orders.index');
        } elseif (!empty($post_type_message_correct)) {
            session()->put('success', $post_type_message_correct);
            return redirect()->route('admin.orders.index');
        } else {
            session()->put('success', trans('app.save_success'));
            return redirect()->route('admin.orders.index');
        }
    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function show($id) {
        $order = Order::find($id);
        if (!empty($order) && $order->type == 'orders') {

            if (!$this->user->can(['access-all', 'order-type-all', 'order-all', 'order-edit', 'order-show', 'order-show-only'])) {
                if ($this->user->can(['order-list', 'order-create'])) {
                    session()->put('error', trans('app.no_access'));
                    return redirect()->route('admin.orders.index');
                } else {
                    return $this->pageUnauthorized();
                }
            }

            if ($this->user->can('order-show-only') && !$this->user->can(['access-all', 'order-type-all', 'order-all', 'order-edit', 'order-show'])) {
                if (($this->user->id != $order->user_id)) {
                    if ($this->user->can(['order-list', 'order-create'])) {
                        session()->put('error', trans('app.no_access'));
                        return redirect()->route('admin.orders.index');
                    } else {
                        return $this->pageUnauthorized();
                    }
                }
            }

            $user = User::where('is_active', 1)->find($order->user_id);
            if ($this->user->can(['access-all', 'order-type-all', 'order-all', 'order-edit'])) {
                $order_active = 1;
            } else {
                $order_active = 0;
            }
            if ($order_active == 1) {
                $order->updateOrderRead($id);
            }
//            $orderTags = $order->tags->pluck('name')->toArray();
//            $orderCategories = $order->categories->pluck('name')->toArray();
            return view('admin.orders.show', compact('order', 'user', 'order_active'));
        } else {
            $error = new AdminController();
            return $error->pageError();
        }
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function edit($id) {

        $order = Order::find($id);
        if (!empty($order)) {
            if ($this->user->id != $order->user_id) {
                if (!$this->user->can(['access-all', 'order-type-all', 'order-all', 'order-edit', 'order-edit-only'])) {
                    if ($this->user->can(['order-list', 'order-create'])) {
                        session()->put('error', trans('app.no_access'));
                        return redirect()->route('admin.orders.index');
                    } else {
                        return $this->pageUnauthorized();
                    }
                }
            }

            if ($this->user->can('order-edit-only') && !$this->user->can(['access-all', 'order-type-all', 'order-all', 'order-edit'])) {
                if (($this->user->id != $order->user_id)) {
                    if ($this->user->can(['order-list', 'order-create'])) {
                        session()->put('error', trans('app.no_access'));
                        return redirect()->route('admin.orders.index');
                    } else {
                        return $this->pageUnauthorized();
                    }
                }
            }

            $new = 0;
            if ($this->user->can(['access-all', 'order-type-all', 'order-all', 'order-edit'])) {
                $order_active = $image = 1;
            } else {
                $order_active = 0;
            }
            if ($this->user->can(['access-all', 'order-type-all', 'order-all', 'order-edit'])) {
                $order_active = 1;
            } else {
                $order_active = 0;
            }
            if ($order_active == 1) {
                $order->updateOrderRead($id);
            }
            $course_all = Post::where('type', 'course')->where('lang', 'ar')->where('is_active', 1)->pluck('id', 'name')->toArray();
            if ($this->user->lang == 'ar') {
                $first_title = ['اختر الايميل ' => 0];
                $first_course = ['اختر الدورة ' => 0];
            } else {
                $first_title = ['Choose Email ' => 0];
                $first_course = ['Choose Course ' => 0];
            }
            $courses = array_flip(array_merge($first_course, $course_all));
            $orderCourse = [$order->post_id => $order->post_id];
            $orderUser = [$order->user_id => $order->user_id];
            $users_all = User::where('is_active', 1)->pluck('id', 'email')->toArray();
            $users = array_flip(array_merge($first_title, $users_all));

            $link_return = route('admin.orders.index');
            return view('admin.orders.edit', compact('link_return', 'order', 'orderCourse', 'orderUser', 'courses', 'users', 'new', 'order_active'));
        } else {
            $error = new AdminController();
            return $error->pageError();
        }
    }

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function update(Request $request, $id) {

        $order = Order::find($id);
        if (!empty($order)) {
            if (!$this->user->can(['access-all', 'order-type-all', 'order-all', 'order-edit', 'order-edit-only'])) {
                if ($this->user->can(['order-list', 'order-create'])) {
                    session()->put('error', trans('app.no_access'));
                    return redirect()->route('admin.orders.index');
                } else {
                    return $this->pageUnauthorized();
                }
            }

            if ($this->user->can('order-edit-only') && !$this->user->can(['access-all', 'order-type-all', 'order-all', 'order-edit'])) {
                if (($this->user->id != $order->user_id)) {
                    if ($this->user->can(['order-list', 'order-create'])) {
                        session()->put('error', trans('app.no_access'));
                        return redirect()->route('admin.orders.index');
                    } else {
                        return $this->pageUnauthorized();
                    }
                }
            }
            $this->validate($request, [
                'user_id' => "required|ValueSelectID:{$request->user_id}",
                'post_id' => "required|ValueSelectID:{$request->post_id}",
            ]);

            $input = $request->all();
            foreach ($input as $key => $value) {
//            if ($key != "content") {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
//            }
            }
//            $order->update($input);

            $total_discount = $discount = 100;
            $price = 0;
            $post = Post::find($input['post_id']);
            if (!empty($post) && !empty($post)) {
                $insertOrder = $update_insert = 0;
                $price_course = $post->price;
                $discount_course = $post->discount;
                $discount_course = $post->discount;
                $course_title = $post->name;
//            $date = date("Y-m-d");
                $input['link'] = str_replace(' ', '_', $course_title . str_random(8));
                $source_share = 'site_free';
                if ($post->type_cost == 'free') {
                    $total_discount = $discount = 100;
                    $price = 0;
                } else {
                    if ($input['type_cost'] == 'premium') {
                        $source_share = 'site_pay';
                        $discount = 0;
                        $total_discount = $discount_course;
                        $price = round($price_course - ($price_course * ($total_discount / 100)), 2);
                    } elseif ($input['type_cost'] == 'discount') {
                        $source_share = 'site_pay';
                        $total_discount = $discount; //+ $discount_course;
                        $price = round($price_course - ($price_course * ($total_discount / 100)), 2);
                    } elseif ($input['type_cost'] == 'free') {
                        $total_discount = $discount = 100;
                        $price = 0;
                    } else {
                        $total_discount = $discount = 0;
                        $price = 0;
                    }
                }

                $input['name'] = $post->name;
                $input['is_active'] = 1;
                $input['is_share'] = 1;
                $input['type_request'] = 'accept';
                $input['discount'] = $total_discount;
                $input['price'] = $price;
                $input['type'] = 'master';
                $input['source_share'] = $source_share;
                $input['success_link'] = 'success_link';
                $input['error_link'] = 'error_link';
                $input['add_by'] = $this->user->id;
                //check found course for user_id 
                $dataFoundOrder = Order::CheckFoundOrderACtiveShare($input['user_id'], $input['post_id'], 1, 1);
                if (!empty($dataFoundOrder)) {
                    if ($dataFoundOrder->is_active == 1 && $dataFoundOrder->type_request == 'accept') {
                        $post_type_message_wrong = 'فشلت عملية التسجيل لان دورة' . ' ' . $course_title . ' ' . 'مضافة ومفعلة بالفعل للعضو' . ' ' . $user_name . ' ' . 'التابع للايميل' . ' ' . $user_email;
                    } else {
                        $update_insert = $dataFoundOrder->update($input);
                        if ($update_insert) {
                            $post_type_message_correct = 'تم تعديل البيانات  بنجاح مع ارسال رسالة الى البريد الالكترونى الخاص بالمضاف له الدورة للمتابعة';
                        } else {
                            $post_type_message_wrong = 'فشلت عملية التعديل ';
                        }
                    }
                } else {
                    //no user_id share in course
                    $insertOrder = Order::create($input);
                    $order_id = $insertOrder['id'];
                    $post_type_message_correct = 'تم تسجيل البيانات  بنجاح مع ارسال رسالة الى البريد الالكترونى الخاص بالمضاف له الدورة للمتابعة';
                }

                if ($insertOrder || $update_insert) {
                    //send message to member on email

                    $default_server = 'http://' . $_SERVER['SERVER_NAME'];
                    $site_url = $default_server . '/master/';

                    $site_title_setting = ''; //get_setting('site_title');
                    if ($site_title_setting == 'master' || $site_title_setting == "master") {
                        $site_title = $site_title_setting . ' ' . 'site web';
                    } else {
                        $site_title = 'موقع' . ' ' . $site_title_setting;
                    }
                }
            }
            if (!empty($post_type_message_wrong)) {
                session()->put('error', $post_type_message_wrong);
                return redirect()->route('admin.orders.index');
            } elseif (!empty($post_type_message_correct)) {
                session()->put('success', $post_type_message_correct);
                return redirect()->route('admin.orders.index');
            } else {
                session()->put('success', trans('app.save_success'));
                return redirect()->route('admin.orders.index');
            }
        } else {
            $error = new AdminController();
            return $error->pageError();
        }
    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function destroy($id) {

        $order = Order::find($id);
        if (!empty($order)) {
            if (!$this->user->can(['access-all', 'order-type-all', 'order-all', 'order-delete', 'order-delete-only'])) {
                if ($this->user->can(['order-list'])) {
                    session()->put('error', trans('app.no_access'));
                    return redirect()->route('admin.orders.index');
                } else {
                    return $this->pageUnauthorized();
                }
            }

            if ($this->user->can('order-delete-only') && !$this->user->can(['access-all', 'order-type-all', 'order-all', 'order-delete'])) {
                if (($this->user->id != $order->user_id)) {
                    if ($this->user->can(['order-list'])) {
                        session()->put('error', trans('app.no_access'));
                        return redirect()->route('admin.orders.index');
                    } else {
                        return $this->pageUnauthorized();
                    }
                }
            }

            Order::find($id)->delete();
            session()->put('success', trans('app.delete_success'));
//            if ($this->user->can(['access-all', 'order-type-all', 'order-all', 'order-delete'])) {
            return redirect()->route('admin.orders.index');
//            } elseif ($this->user->can(['order-delete-only'])) {
//                return redirect()->route('admin.users.ordertype', [$this->user->id, 'orders']);
//            }
        } else {
            $error = new AdminController();
            return $error->pageError();
        }
    }

    public function allread() {
        if (!$this->user->can(['access-all', 'order-type-all', 'order-all', 'order-delete', 'order-delete-only'])) {
            if ($this->user->can(['order-list'])) {
                session()->put('error', trans('app.no_access'));
                return redirect()->route('admin.orders.index');
            } else {
                return $this->pageUnauthorized();
            }
        }
        if ($this->user->can('order-delete-only') && !$this->user->can(['access-all', 'order-type-all', 'order-all', 'order-delete'])) {
            if (($this->user->id != $order->user_id)) {
                if ($this->user->can(['order-list'])) {
                    session()->put('error', trans('app.no_access'));
                    return redirect()->route('admin.orders.index');
                } else {
                    return $this->pageUnauthorized();
                }
            }
        }
        //read all new order
        Order::updateOrderColum('is_read', 0, 'is_read', 1);
        session()->put('success', trans('app.all_read_success'));
        return redirect()->route('admin.orders.index');
    }

    public function search() {
        if (!$this->user->can(['access-all', 'order-type-all', 'order-all', 'order-list', 'order-edit', 'order-delete', 'order-show'])) {
            return $this->pageUnauthorized();
        }

        $order_active = $order_edit = $order_create = $order_delete = $order_show = $comment_list = $comment_create = 0;

        if ($this->user->can(['access-all', 'order-type-all', 'order-all'])) {
            $order_active = $order_edit = $order_create = $order_delete = $order_show = $comment_list = $comment_create = 1;
        }

        if ($this->user->can('order-edit')) {
            $order_active = $order_edit = $order_create = $order_show = $comment_list = $comment_create = 1;
        }

        if ($this->user->can('order-delete')) {
            $order_delete = 1;
        }

        if ($this->user->can('order-show')) {
            $order_show = 1;
        }

        if ($this->user->can('order-create')) {
            $order_create = 1;
        }

        if ($this->user->can(['comment-all', 'comment-edit'])) {
            $comment_list = $comment_create = 1;
        }

        if ($this->user->can('comment-list')) {
            $comment_list = 1;
        }

        if ($this->user->can('comment-create')) {
            $comment_create = 1;
        }
        $name = 'orders';
        $type_action = 'order';
        $data = Order::orderBy('id', 'DESC')->with('user')->get(); 
        return view('admin.orders.search', compact('data','type_action', 'name', 'comment_create', 'comment_list', 'order_active', 'order_create', 'order_edit', 'order_delete', 'order_show'));
    }

}
