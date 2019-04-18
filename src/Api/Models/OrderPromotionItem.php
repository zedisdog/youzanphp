<?php
/**
 * Created by zed.
 */

declare(strict_types=1);
namespace Dezsidog\Youzanphp\Api\Models;


class OrderPromotionItem
{
    /**
     * @var bool 是否赠品
     */
    public $isPresent;
    /**
     * @var string 交易明细id
     */
    public $oid;
    /**
     * @var int 商品id
     */
    public $itemId;
    /**
     * @var int 规格id
     */
    public $skuId;
    /**
     * @var Promotion[] 优惠明细结构体
     */
    public $promotions;

    public $raw;

    /**
     * OrderPromotionItem constructor.
     * @param array $raw
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function __construct(array $raw)
    {
        $this->raw = $raw;
        $this->parse();
    }

    /**
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    protected function parse()
    {
        $this->isPresent = $this->raw['is_present'];
        $this->oid = $this->raw['oid'];
        $this->itemId = $this->raw['item_id'];
        $this->skuId = $this->raw['sku_id'];
        $this->promotions = [];
        foreach ($this->raw['promotions'] as $item) {
            array_push($this->promotions, new Promotion($item));
        }
    }
}