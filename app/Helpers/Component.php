<?php


namespace App\Helpers;

trait Component
{
    /**
     * @var $url
     * @var $classname
     * @var $id
     * @var $fontawesome
     * @var $text
     * @var $title
     */
    protected function btn($url, $className = 'btn-default',  $fontawesome = null, $text = null, $title = null, $code = null)
    {
        $html = '<a href="' . $url . '" class="mr-1 btn btn-sm ' . $className . '"';

        if ($title) {
            $html .= 'title="' . $title . '"';
        }
        if ($code) {
            $html .=  $code;
        }
        $html .= '>';

        if ($fontawesome) {
            $html .= '<i class="' . $fontawesome . '" aria-hidden="true"></i>';
        }

        if ($text) {
            $html .= $text;
        }
        $html .= '</a>';

        return $html;
    }

    protected function customBtn($url, $className = 'btn-warning', $fontawesome = 'fa fa-check', $text = '', $title = "custom", $code = "")
    {
        return $this->btn(
            $url,
            $className,
            $fontawesome,
            $text,
            $title,
            $code
        );
    }
    protected function editBtn($url, $className = 'btn-info', $fontawesome = 'fa fa-edit', $text = '', $title = "Edit")
    {
        return $this->btn(
            $url,
            $className,

            $fontawesome,
            $text,
            $title
        );
    }

    protected function destroyBtn($url, $className = 'btn-danger delete_row', $fontawesome = 'fa fa-trash', $text = '', $title = "Delete")
    {
        return $this->btn(
            $url,
            $className,

            $fontawesome,
            $text,
            $title
        );
    }

    protected function showBtn($url, $className = 'btn-success', $fontawesome = 'fa fa-eye', $text = '', $title = "View")
    {
        return $this->btn(
            $url,
            $className,
            $fontawesome,
            $text,
            $title
        );
    }

    protected function checkedBtn($id, $route, $coloumName, $value, $checkArray)
    {
        $html =  '<div class="custom-control custom-switch custom-switch-primary">';
        $html .= '<input type="checkbox" url="' . route($route . '.' . $coloumName, $id) . '" class="custom-control-input switchUrl" id="customSwitch' . $id . '"';
        $html .=  in_array($value, $checkArray) ? "checked" : "";
        $html .= '/><label class="custom-control-label" for="customSwitch' . $id . '">';
        $html .= '<span class="switch-icon-left"><i data-feather="check"></i></span>
                                                <span class="switch-icon-right"><i data-feather="x"></i></span>
                                            </label>
                                        </div>';
        return $html;
    }
}
