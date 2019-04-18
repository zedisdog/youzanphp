<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


class ExpressInfo
{
    /**
     * @var int 物流类型
     */
    public $expressId;
    /**
     * @var string 物流编号
     */
    public $expressNo;

    public $raw;

    public function __construct(array $raw)
    {
        $this->raw = $raw;
        $this->parse();
    }

    protected function parse()
    {
        $this->expressId = $this->raw['express_id'];
        $this->expressNo = $this->raw['express_no'];
    }
}