<?php

namespace App\Libraries;

use App\Models\BackEnd\UserMenu;
use Request;
use Auth;

class BuildMenu {

    static function admin_menu() {
        $permissionMenu = Auth::user()->roles->pluck('menu_access')->first();

        $list_menu = UserMenu::where('state', '1')->orderBy('ordering','ASC')->get();
        //dd($list_menu);
        $uri_string = '/'.Request::segment(2);
        $arr_menu_id = array();
        $getIdMenu = '';
        foreach ($list_menu as $row) {
            $arr_menu_id[$row->id] = $row->url;
            if ($uri_string === $row->url) {
                $getIdMenu = $row->parent_id;
            }
        }

        $result = self::build_menu($list_menu, 0, explode(',', $permissionMenu), ($getIdMenu) ? $getIdMenu : '');
        return $result;
    }

    static function build_menu($tree, $parent, $id, $url_selected = NULL) {

        $str = "";
        $is_child = false;
        $i = 0;
        $url = "";
        foreach ($tree as $row) {
            $name = trim(trans('menu.' . $row->name));

            if ($url_selected == $row->id) {
                $active_open = ' m-menu__item--open m-menu__item--expanded';

            } elseif($url_selected != $row->id) {
                $active_open = '';
            }

            if ($row->parent_id == $parent) {
                $uri_string = Request::segment(2);
                $url = trim($row->url, '/');
                $link = url(\Config::get('sysconfig.prefix') . $row->url);
                if ($parent == 0) {
                    $sub = self::build_menu($tree, $row->id, $id, $url_selected);
                    if ($sub === "" && in_array($row->id, $id)) {
                        $str .= '<li class="m-menu__item ' . (($url == $uri_string) ? ' m-menu__item--active' : '') . '">' . ' <a href="' . $link . '" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon  ' . $row->class_name . '"></i> <span class="m-menu__link-text">' . @$name . '</span> </a>' . '';
                    } else if ($sub !== "" && $sub !== false) {


                        $str .= '<li  class="m-menu__item m-menu__item--submenu' . $active_open . '" aria-haspopup="true" m-menu-submenu-toggle="hover">' . ' <a href="javascript:void(0);" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon ' . $row->class_name . '"></i><span class="m-menu__link-text">' . @$name . '</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>' . '' . $sub . '</li>';
                    }
                } else {
                    if (in_array($row->id, $id)) {
                        $sub = self::build_menu($tree, $row->id, $id, $url_selected);
                        if ($sub === "") {
                            $str .= '<li class="m-menu__item ' . (($url === $uri_string) ? ' m-menu__item--active' : '') . '" aria-haspopup="true">' . '<a href="' . $link . '" class="m-menu__link "> <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">' . @$name . '</span></a>' . '</li>';
                        } else if ($sub !== "" && $sub !== false) {
                            $str .= '<li class="m-menu__item ' . (($url === $uri_string) ? ' m-menu__item--active' : '') . '" aria-haspopup="true" m-menu-submenu-toggle="hover">' . '<a href="' . $link . '" class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">' . @$name . '</span></a>' . $sub . '</li>';
                        }
                    }
                }
                $is_child = true;
            }
            $i++;
        }
        if ($str === "" && $is_child === false) {
            return "";
        } else if ($str === "" && $is_child === true) {
            return false;
        } else {
            if ($parent == 0) {
                $str = $str;
            } else {
                $str = " <div class=\"m-menu__submenu \"><span class=\"m-menu__arrow\"></span><ul class=\"m-menu__subnav \"> {$str} </ul></div>";
            }
        }
        return $str;
    }

}
