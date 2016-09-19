<?php

namespace Illuminate\Pagination;

use Illuminate\Support\HtmlString;
use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;
use Illuminate\Contracts\Pagination\Presenter as PresenterContract;

class BootstrapThreePresenter implements PresenterContract
{
    use BootstrapThreeNextPreviousButtonRendererTrait, UrlWindowPresenterTrait;

    /**
     * The paginator implementation.
     *
     * @var \Illuminate\Contracts\Pagination\Paginator
     */
    protected $paginator;

    /**
     * The URL window data structure.
     *
     * @var array
     */
    protected $window;

    /**
     * Create a new Bootstrap presenter instance.
     *
     * @param  \Illuminate\Contracts\Pagination\Paginator  $paginator
     * @param  \Illuminate\Pagination\UrlWindow|null  $window
     * @return void
     */
    public function __construct(PaginatorContract $paginator, UrlWindow $window = null)
    {
        $this->paginator = $paginator;
        $this->window = is_null($window) ? UrlWindow::make($paginator) : $window->get();
    }

    /**
     * Determine if the underlying paginator being presented has pages to show.
     *
     * @return bool
     */
    public function hasPages()
    {
        return $this->paginator->hasPages();
    }

    /**
     * Convert the URL window into Bootstrap HTML.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function render()
    {
        if ($this->hasPages()) {
            return new HtmlString(sprintf(
                //'<ul class="pagination">%s %s %s</ul>',
                '%s %s %s',
                $this->getPreviousButton(),
                $this->getLinks(),
                $this->getNextButton()
          //      $this->getTails() 不显示确定
            ));
        }

        return '';
    }

    /**
     * Get HTML wrapper for an available page link.
     *
     * @param  string  $url
     * @param  int  $page
     * @param  string|null  $rel
     * @return string
     */
    protected function getAvailablePageWrapper($url, $page, $rel = null)
    {
        $rel = is_null($rel) ? '' : ' rel="'.$rel.'"';
        if($page == '上一页'){
            return '<span><a href="'.htmlentities($url).'"'.$rel.'><i class="f-tran f-tran-prev">&lt;</i>'.$page.'</a></span>';
        }else if($page == '下一页'){
            return '<span><a href="'.htmlentities($url).'"'.$rel.' class="nextPage">'.$page.'<i class="f-tran f-tran-next">&gt;</i></a></span>';
        }else{
            return '<span><a href="'.htmlentities($url).'"'.$rel.' class="tcdNumber">'.$page.'</a></span>';
        }
        
        //return '<li><a href="'.htmlentities($url).'"'.$rel.'>'.$page.'</a></li>';
    }

    /**
     * Get HTML wrapper for disabled text.
     *
     * @param  string  $text
     * @return string
     */
    protected function getDisabledTextWrapper($text)
    {
        if($text == '上一页'){
            return '<span class="f-noClick"><a href="javascript:;"><i class="f-tran f-tran-prev">&lt;</i>'.$text.'</a></span>';
        }else{
            return '<span  class="f-noClick"><a href="javascript:;" class="nextPage">'.$text.'<i class="f-tran f-tran-next">&gt;</i></a></span>';
        }
        
        //return '<li class="disabled"><span>'.$text.'</span></li>';
    }

    /**
     * Get HTML wrapper for active text.
     *
     * @param  string  $text
     * @return string
     */
    protected function getActivePageWrapper($text)
    {
        return '<span class="current"><a>'.$text.'</a></span><span>';
        //return '<li class="active"><span>'.$text.'</span></li>';
    }

    /**
     * Get a pagination "dot" element.
     *
     * @return string
     */
    protected function getDots()
    {
        return '<span>...</span>';
        //return $this->getDisabledTextWrapper('...');
    }
    
    /**
     * Get a pagination "tail" element.
     *
     * @return string
     */
    protected function getTails()
    {
        $html = '<span class="f-mar-left">共<em>'.$this->paginator->lastPage().'</em>页，去第</span>';
        $html .= '<span><input type="text" id="txtGotoPage" value="" style="padding:0;margin-bottom:0px">页</span>';
        $html .= '<span class="f-mar-left"><a title="确定" href="javascript:;" id="btnGotoPage">确定</a></span>';
        
        return $html;
    }

    /**
     * Get the current page from the paginator.
     *
     * @return int
     */
    protected function currentPage()
    {
        return $this->paginator->currentPage();
    }

    /**
     * Get the last page from the paginator.
     *
     * @return int
     */
    protected function lastPage()
    {
        return $this->paginator->lastPage();
    }
}
