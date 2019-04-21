<?php
/**
 * Created by zed.
 */

namespace Dezsidog\Youzanphp\Api\Params;


class Tag extends BaseParams
{
    /**
     * @var string 标签名称
     */
    public $tag_name;

    public function __construct(string $tagName)
    {
        $this->tag_name = $tagName;
    }
}