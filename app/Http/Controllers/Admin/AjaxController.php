<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Model\Post;
use App\Model\Category;
use App\Model\CategoryProduct;
use App\Model\Comment;
use App\Model\Contact;
use App\Model\Search;

class AjaxController extends AdminController {

    public function ajax_get_subteam(Request $request) {
        $subteams = $cat_subteams = [];
//        if ($this->user->can(['access-all', 'user-all'])) { 
        $input = $request->all();
        if ($input['id'] != 0) {
            $category_main = Category::find($input['id']);
            $lang = 'ar';
            if (isset($category_main->lang)) {
                $lang = $category_main->lang;
            }
            $subteams_all = Category::where('type', 'subteam')->where('lang', $lang)->where('parent_id', $input['id'])->where('is_active', 1)->pluck('id', 'name')->toArray();
            if (count($subteams_all) != 0) {
                if ($this->user->lang == 'ar') {
                    $first_title = ['اختر الفريق الفرعى ' => 0];
                } else {
                    $first_title = ['Choose Ssub Team' => 0];
                }
                $subteams = array_flip(array_merge($first_title, $subteams_all));
            }
        }
//        }
        $response = view('admin.champions.ajax_get_subcategory', compact('subteams', 'cat_subteams'))->render();
//        return response()->json($response);
        return response()->json(['status' => '1', 'response' => $response]);
    }
    public function ajax_subcategoryProduct(Request $request) {
        $subcategories = $productSubcategories = [];
//        if ($this->user->can(['access-all', 'user-all'])) { 
        $input = $request->all();
        if ($input['id'] != 0) {
            $category_main = CategoryProduct::find($input['id']);
            $lang = 'ar';
            if (isset($category_main->lang)) {
                $lang = $category_main->lang;
            }
            $subcategories_all = CategoryProduct::where('type', 'sub')->where('lang', $lang)->where('parent_id', $input['id'])->where('is_active', 1)->pluck('id', 'name')->toArray();
            if (count($subcategories_all) != 0) {
                if ($this->user->lang == 'ar') {
                    $first_title = ['اختر القسم الفرعى' => 0];
                } else {
                    $first_title = ['Choose subCategory' => 0];
                }
                $subcategories = array_flip(array_merge($first_title, $subcategories_all));
            }
        }
//        }
        $response = view('admin.products.ajax_get_subcategory', compact('subcategories', 'productSubcategories'))->render();
//        return response()->json($response);
        return response()->json(['status' => '1', 'response' => $response]);
    }

    public function ajaxSubcategory(Request $request) {
        $subcategories = $postSubcategories = [];
//        if ($this->user->can(['access-all', 'user-all'])) { 
        $input = $request->all();
        if ($input['id'] != 0) {
            $category_main = Category::find($input['id']);
            $lang = 'ar';
            if (isset($category_main->lang)) {
                $lang = $category_main->lang;
            }
            $subcategories_all = Category::where('type', 'sub')->where('lang', $lang)->where('parent_id', $input['id'])->where('is_active', 1)->pluck('id', 'name')->toArray();
            if (count($subcategories_all) != 0) {
                if ($this->user->lang == 'ar') {
                    $first_title = ['اختر القسم الفرعى' => 0];
                } else {
                    $first_title = ['Choose subCategory' => 0];
                }
                $subcategories = array_flip(array_merge($first_title, $subcategories_all));
            }
        }
//        }
        $response = view('admin.posts.posts.ajax_get_subcategory', compact('subcategories', 'postSubcategories'))->render();
//        return response()->json($response);
        return response()->json(['status' => '1', 'response' => $response]);
    }

    //****************************************************************
    public function userStatus(Request $request) {
        $response = false;
        if ($this->user->can(['access-all', 'user-all'])) {
            $input = $request->all();
            if ($input['id'] != 1) {
                $user = User::find($input['id']);
                $user->is_active = $input['status'];
                $response = $user->save();
            }
        }
        return response()->json($response);
    }

    public function postStatus(Request $request) {
        $response = false;
        if ($this->user->can(['access-all', 'post-type-all', 'post-all', 'post-edit'])) {
            $input = $request->all();
            $post = new Post();
            $response = $post->updatePostActive($input['id'], $input['status']);
        }

        return response()->json($response);
    }

    public function postRead(Request $request) {
        $response = false;
        if ($this->user->can(['access-all', 'post-type-all', 'post-all', 'post-edit'])) {
            $input = $request->all();
            $post = new Post();
            $response = $post->updatePostRead($input['id']);
        }

        return response()->json($response);
    }

    public function categoryStatus(Request $request) {
        $response = false;
        if ($this->user->can(['access-all', 'post-type-all', 'post-all', 'category-all', 'category-edit'])) {
            $input = $request->all();
            $category = new Category();
            $response = $category->updateCategoryActive($input['id'], $input['status']);
        }

        return response()->json($response);
    }

    public function searchStatus(Request $request) {
        $response = false;
        if ($this->user->can(['access-all', 'post-type-all', 'post-all'])) {
            $input = $request->all();
            $search = new Search();
            $response = $search->updateSearchActive($input['id'], $input['status']);
        }

        return response()->json($response);
    }

    public function commentStatus(Request $request) {
        $response = false;
        if ($this->user->can(['access-all', 'post-type-all', 'post-all', 'comment-all', 'comment-edit'])) {
            $input = $request->all();
            $comment = new Comment();
            $response = $comment->updateCommentActive($input['id'], $input['status']);
        }

        return response()->json($response);
    }

    public function commentRead(Request $request) {
        $response = false;
        if ($this->user->can(['access-all', 'post-type-all', 'post-all', 'comment-all', 'comment-edit'])) {
            $input = $request->all();
            $comment = new Comment();
            $response = $comment->updateCommentRead($input['id']);
        }

        return response()->json($response);
    }

    public function contactRead(Request $request) {
        $response = false;
        if ($this->user->can(['access-all', 'post-type-all', 'post-all'])) {
            $input = $request->all();
            $response = Contact::updateContactRead($input['id']);
        }

        return response()->json($response);
    }

    public function contactReply(Request $request) {
        $response = false;
        if ($this->user->can(['access-all', 'post-type-all', 'post-all'])) {
            $input = $request->all();
            $contact = new Contact();
            $response = $contact->updateContactReply($input['id']);
        }

        return response()->json($response);
    }

}
